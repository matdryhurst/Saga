<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Embeds controller
 */
class Embeds extends Admin_Controller
{
    protected $permissionCreate = 'Embedcontent.Embeds.Create';
    protected $permissionDelete = 'Embedcontent.Embeds.Delete';
    protected $permissionEdit   = 'Embedcontent.Embeds.Edit';
    protected $permissionView   = 'Embedcontent.Embeds.View';

    /**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
        $this->auth->restrict($this->permissionView);
        $this->load->helper('manage_files');
		$this->load->model('embedcontent/embedcontent_model');
		$this->load->model('templates/templates_model');
        $this->lang->load('embedcontent');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
		Template::set_block('sub_nav', 'embeds/_sub_nav');

		Assets::add_module_js('embedcontent', 'embedcontent.js');
	}

	/**
	 * Display a list of EmbedContent data.
	 *
	 * @return void
	 */
	public function index($offset = 0)
	{
        // Deleting anything?
		if (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);
			$checked = $this->input->post('checked');
			if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

				$result = true;
				foreach ($checked as $pid) {
					/*******Physically delete the template from its location******/
					$template_to_be_deleted = $this->embedcontent_model->find_by('id', $pid);
					$file_to_delete = $template_to_be_deleted->name;
					
					$deletepath = $this->config->item('smartembed_static_site_location'). $file_to_delete;
					$is_file_delete = false;
					/////////////////////////////////////////////////////////////////////
					$is_file_delete = deleteFolderAndAllFiles($deletepath);
				    /********************************************/

				    $deleted = $this->embedcontent_model->delete($pid);

                    if ($deleted == false || $is_file_delete == false) {
                        $result = false;
                    }
				}
				if ($result) {
					Template::set_message(count($checked) . ' ' . lang('embedcontent_delete_success'), 'success');
				} else {
					Template::set_message(lang('embedcontent_delete_failure') . $this->embedcontent_model->error, 'error');
				}
			}
		}
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/embeds/embedcontent/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->embedcontent_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->embedcontent_model->limit($limit, $offset);
        
		$records = $this->embedcontent_model->find_all();

		$templatenames = array();

		if($records) {
		  	foreach ($records as $record) {
		   		$name = $this->templates_model->getTemplateById((string)$record->templateid)->name;
		   		array_push($templatenames, $name);
		  	}	
		  	Template::set('templatenames', $templatenames);
		}
 

		Template::set('records', $records);
        
    Template::set('toolbar_title', lang('embedcontent_manage'));

		Template::render();
	}
    
    /**
	 * Create a EmbedContent object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict($this->permissionCreate);
     
		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_embedcontent()) {
				log_activity($this->auth->user_id(), lang('embedcontent_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'embedcontent');
				Template::set_message(lang('embedcontent_create_success'), 'success');
				//Copy the template into a new folder
				$templateData = $this->templates_model->getTemplateById($_POST["templateid"]);				
				$templateFileName = $templateData->filename;

				createFolder($_POST["name"], $templateFileName);				

				redirect(SITE_AREA . '/embeds/embedcontent');
			}

            // Not validation error
			if ( ! empty($this->embedcontent_model->error)) {
				Template::set_message(lang('embedcontent_create_failure') . $this->embedcontent_model->error, 'error');
            }
		}
		else{
			//run the query for the cities we specified earlier
       		      		
       		 
		}
		$templateData=$this->templates_model->getTemplates();
       		 Template::set('templatesDrop', $templateData); 
		Template::set('toolbar_title', lang('embedcontent_action_create'));		
		Template::render();
	}
	/**
	 * Allows editing of EmbedContent data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		$templateData=$this->templates_model->getTemplates();
        Template::set('templatesDrop', $templateData);
		if (empty($id)) {
			Template::set_message(lang('embedcontent_invalid_id'), 'error');

			redirect(SITE_AREA . '/embeds/embedcontent');
		}
        
		if (isset($_POST['save'])) {
			$this->auth->restrict($this->permissionEdit);

			if ($this->save_embedcontent('update', $id)) {
				log_activity($this->auth->user_id(), lang('embedcontent_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'embedcontent');
				Template::set_message(lang('embedcontent_edit_success'), 'success');
				redirect(SITE_AREA . '/embeds/embedcontent');
			}

            // Not validation error
            if ( ! empty($this->embedcontent_model->error)) {
                Template::set_message(lang('embedcontent_edit_failure') . $this->embedcontent_model->error, 'error');
			}
		}
        
		elseif (isset($_POST['delete'])) {
			$this->auth->restrict($this->permissionDelete);

			if ($this->embedcontent_model->delete($id)) {
				log_activity($this->auth->user_id(), lang('embedcontent_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'embedcontent');
				Template::set_message(lang('embedcontent_delete_success'), 'success');
				
				redirect(SITE_AREA . '/embeds/embedcontent');
			}

            Template::set_message(lang('embedcontent_delete_failure') . $this->embedcontent_model->error, 'error');
		}
        
        Template::set('embedcontent', $this->embedcontent_model->find($id));

		Template::set('toolbar_title', lang('embedcontent_edit_heading'));
		Template::render();
	}

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Save the data.
	 *
	 * @param string $type Either 'insert' or 'update'.
	 * @param int	 $id	The ID of the record to update, ignored on inserts.
	 *
	 * @return bool|int An int ID for successful inserts, true for successful
     * updates, else false.
	 */
	private function save_embedcontent($type = 'insert', $id = 0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

        // Validate the data
        $this->form_validation->set_rules($this->embedcontent_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

		// Make sure we only pass in the fields we want
		
		$data = $this->embedcontent_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['sourceurl'] = $data['name'];


        $return = false;
		if ($type == 'insert') {
			$data['count']=1;
			$id = $this->embedcontent_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			}
		} elseif ($type == 'update') {
			$return = $this->embedcontent_model->update($id, $data);
		}

		return $return;
	}
}