<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Embeds controller
 */
class Embeds extends Admin_Controller
{
    protected $permissionCreate = 'Editedembed.Embeds.Create';
    protected $permissionDelete = 'Editedembed.Embeds.Delete';
    protected $permissionEdit   = 'Editedembed.Embeds.Edit';
    protected $permissionView   = 'Editedembed.Embeds.View';

    /**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
        $this->auth->restrict($this->permissionView);
        $this->load->library('session');
        $this->load->helper('manage_files');
		$this->load->model('editedembed/editedembed_model');
		$this->load->model('embedcontent/embedcontent_model');
		$this->load->model('templates/templates_model');
		$this->load->model('history/history_model');

        $this->lang->load('editedembed');
		
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
		Template::set_block('sub_nav', 'embeds/_sub_nav');

		Assets::add_module_js('editedembed', 'editedembed.js');
	}

	/**
	 * Display a list of EditedEmbed data.
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
					$deleted = $this->editedembed_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
				}
				if ($result) {
					Template::set_message(count($checked) . ' ' . lang('editedembed_delete_success'), 'success');
				} else {
					Template::set_message(lang('editedembed_delete_failure') . $this->editedembed_model->error, 'error');
				}
			}
		}
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/embeds/editedembed/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->editedembed_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->editedembed_model->limit($limit, $offset);
        
		$records = $this->editedembed_model->find_all();

		Template::set('records', $records);
        
    Template::set('toolbar_title', lang('editedembed_manage'));

		Template::render();
	}
    
    /**
	 * Create a EditedEmbed object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict($this->permissionCreate);
        
		// if (isset($_POST['save'])) {
		// 	if ($insert_id = $this->save_editedembed()) {
		// 		log_activity($this->auth->user_id(), lang('editedembed_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'editedembed');
		// 		Template::set_message(lang('editedembed_create_success'), 'success');

		// 		redirect(SITE_AREA . '/embeds/editedembed');
		// 	}

  //           // Not validation error
		// 	if ( ! empty($this->editedembed_model->error)) {
		// 		Template::set_message(lang('editedembed_create_failure') . $this->editedembed_model->error, 'error');
  //           }
		// }
		$historyID=$this->uri->segment(5);
		$history=$this->history_model->find($historyID);
		$embed=$this->embedcontent_model->find($history->embedid);

		//$editembedgoodies=array('history'=>$history,
		// 						'embed'=>$embed);

		if($embed){
			//echo 'Found it '.$embed->name  ;
			//printf("uniqid('', true): %s\r\n", uniqid('".$embed->id.$embed->name."', true));
			//insert new editedembed
			$uniqueName= uniqid($embed->id.'_',true);
			$editedEmbedData['count']=1;
			$editedEmbedData['embedid']=$embed->id;
			$editedEmbedData['name']=$uniqueName;
			$editedEmbedData['sourceurl']=$embed->sourceurl;

			$neweditedEmbedID=$this->editedembed_model->insert($editedEmbedData);

			$array = array('id' => $embed->id);
		 	
		 			
			$embedData = $this->embedcontent_model->where($array)->find_all();

			$embedFileName = $embedData[0]->name;
			
			mkdir(config_item('smartembed_static_site_location'). $uniqueName, 0755);
						
			copyFolder(config_item('smartembed_static_site_location'). $embedFileName, config_item('smartembed_static_site_location'). $uniqueName);

			$this->session->set_userdata('editedembedID',$neweditedEmbedID);
			$this->session->set_userdata('embedname',$uniqueName);

			redirect(SITE_AREA . '/embeds/history/edit/'.$historyID);
			// $_POST['historyID']=$historyID;
			// $_POST['neweditedembedID']=$neweditedembedID;

			//redirect(SITE_AREA . '/embeds/history/');
			// $this->history_model->update($id, $data);
			// print_r($this->history_model->find($historyID));
			//$returnID =$this->history_model->insert($historyData);
			//print_r($historyData);

			//echo 'New Embed ID '.$neweditedembedid.' history '.$historyID.' - '.$returnID;
		}
		// else{
		// 	echo 'Go again';
		// }
		//Template::set('goodies', $editembedgoodies);
		//Template::set('toolbar_title', lang('editedembed_action_create'));

		//Template::render();
	}
	/**
	 * Allows editing of EditedEmbed data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);
		if (empty($id)) {
			Template::set_message(lang('editedembed_invalid_id'), 'error');

			redirect(SITE_AREA . '/embeds/editedembed');
		}
        
		if (isset($_POST['save'])) {
			$this->auth->restrict($this->permissionEdit);

			if ($this->save_editedembed('update', $id)) {
				log_activity($this->auth->user_id(), lang('editedembed_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'editedembed');
				Template::set_message(lang('editedembed_edit_success'), 'success');
				redirect(SITE_AREA . '/embeds/editedembed');
			}

            // Not validation error
            if ( ! empty($this->editedembed_model->error)) {
                Template::set_message(lang('editedembed_edit_failure') . $this->editedembed_model->error, 'error');
			}
		}
        
		elseif (isset($_POST['delete'])) {
			$this->auth->restrict($this->permissionDelete);

			if ($this->editedembed_model->delete($id)) {
				log_activity($this->auth->user_id(), lang('editedembed_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'editedembed');
				Template::set_message(lang('editedembed_delete_success'), 'success');

				redirect(SITE_AREA . '/embeds/editedembed');
			}

            Template::set_message(lang('editedembed_delete_failure') . $this->editedembed_model->error, 'error');
		}
        
        Template::set('editedembed', $this->editedembed_model->find($id));

		Template::set('toolbar_title', lang('editedembed_edit_heading'));
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
	private function save_editedembed($type = 'insert', $id = 0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

        // Validate the data
        $this->form_validation->set_rules($this->editedembed_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

		// Make sure we only pass in the fields we want
		
		$data = $this->editedembed_model->prep_data($this->input->post());


        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
		if ($type == 'insert') {
			$data->count=1;
			$id = $this->editedembed_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			}
		} elseif ($type == 'update') {
			$return = $this->editedembed_model->update($id, $data);
		}

		return $return;
	}
}