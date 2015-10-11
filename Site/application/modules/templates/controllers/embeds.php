<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Embeds controller
 */
class Embeds extends Admin_Controller
{
    protected $permissionCreate = 'Templates.Embeds.Create';
    protected $permissionDelete = 'Templates.Embeds.Delete';
    protected $permissionEdit   = 'Templates.Embeds.Edit';
    protected $permissionView   = 'Templates.Embeds.View';

    /**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
        $this->auth->restrict($this->permissionView);
		$this->load->model('templates/templates_model');
		$this->load->helper('manage_files');
        $this->lang->load('templates');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
		Template::set_block('sub_nav', 'embeds/_sub_nav');

		Assets::add_module_js('templates', 'templates.js');
	}

	/**
	 * Display a list of Templates data.
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
					$template_to_be_deleted = $this->templates_model->find_by('id', $pid);
					$file_to_delete = $template_to_be_deleted->filename;
					
					$deletepath = $this->config->item('smartembed_template_location') . $file_to_delete;

					$is_file_delete = false;
					$is_file_delete = deleteFile($deletepath);
					
				    /********************************************/
					$deleted = $this->templates_model->delete($pid);
                    if ($deleted == false || $is_file_delete == false) {
                        $result = false;
                    }
				}
				if ($result) {
					Template::set_message(count($checked) . ' ' . lang('templates_delete_success'), 'success');
				} else {
					Template::set_message(lang('templates_delete_failure') . $this->templates_model->error, 'error');
				}
			}
		}
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/embeds/templates/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->templates_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->templates_model->limit($limit, $offset);
        
		$records = $this->templates_model->find_all();

		Template::set('records', $records);
        
    Template::set('toolbar_title', lang('templates_manage'));

		Template::render();
	}
    
    /**
	 * Create a Templates object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict($this->permissionCreate);
        
		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_templates()) {
				log_activity($this->auth->user_id(), lang('templates_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'templates');
				Template::set_message(lang('templates_create_success'), 'success');

				redirect(SITE_AREA . '/embeds/templates');
			}

            // Not validation error
			if ( ! empty($this->templates_model->error)) {
				Template::set_message(lang('templates_create_failure') . $this->templates_model->error, 'error');
            }
		}

		Template::set('toolbar_title', lang('templates_action_create'));

		Template::render();
	}
	/**
	 * Allows editing of Templates data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		if (empty($id)) {
			Template::set_message(lang('templates_invalid_id'), 'error');

			redirect(SITE_AREA . '/embeds/templates');
		}
        
		if (isset($_POST['save'])) {
			$this->auth->restrict($this->permissionEdit);

			if ($this->save_templates('update', $id)) {
				log_activity($this->auth->user_id(), lang('templates_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'templates');
				Template::set_message(lang('templates_edit_success'), 'success');
				redirect(SITE_AREA . '/embeds/templates');
			}

            // Not validation error
            if ( ! empty($this->templates_model->error)) {
                Template::set_message(lang('templates_edit_failure') . $this->templates_model->error, 'error');
			}
		}
        
		elseif (isset($_POST['delete'])) {
			$this->auth->restrict($this->permissionDelete);

			if ($this->templates_model->delete($id)) {
				log_activity($this->auth->user_id(), lang('templates_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'templates');
				Template::set_message(lang('templates_delete_success'), 'success');

				redirect(SITE_AREA . '/embeds/templates');
			}

            Template::set_message(lang('templates_delete_failure') . $this->templates_model->error, 'error');
		}
        
        Template::set('templates', $this->templates_model->find($id));

		Template::set('toolbar_title', lang('templates_edit_heading'));
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
	private function save_templates($type = 'insert', $id = 0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		
        // Validate the data
        $this->form_validation->set_rules($this->templates_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }
        
        
      
        

		// Make sure we only pass in the fields we want
		
		$data = $this->templates_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method

        $return = false;
		if ($type == 'insert') {

			$config['file_name'] = $data['name'];

			$config['upload_path'] = $this->config->item('upload_path');
			$config['allowed_types'] = $this->config->item('allowed_types');
			$config['max_size']	= $this->config->item('max_size');
			$config['file_name'] = $data['name'];

			$this->load->library('upload', $config);

			$this->upload->do_upload('filename');

			$dataF = array('upload_data' => $this->upload->data());

			if (empty($_FILES['filename']['name']) || $_FILES['filename']['name'] == ''){
				
	        	$this->form_validation->add_to_error_array('filename', $this->upload->display_errors('', ''));
      		}
			
			$data['filename']['name'] = $dataF['upload_data']['file_name'];
			
			unset($data);
			$data = array();
			$data['filename'] = $dataF['upload_data']['file_name'];
			$data['name']  = $config['file_name'];
			$id = $this->templates_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			}
		} elseif ($type == 'update') {
			$return = $this->templates_model->update($id, $data);
		}

		return $return;
	}

	
}