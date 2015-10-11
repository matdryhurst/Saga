<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Embeds controller
 */
class Embeds extends Admin_Controller
{
    protected $permissionCreate = 'History.Embeds.Create';
    protected $permissionDelete = 'History.Embeds.Delete';
    protected $permissionEdit   = 'History.Embeds.Edit';
    protected $permissionView   = 'History.Embeds.View';

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
		$this->load->model('history/history_model');
		$this->load->model('editedembed/editedembed_model');
        $this->lang->load('history');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
			Assets::add_css('jquery-ui-timepicker.css');
			Assets::add_js('jquery-ui-timepicker-addon.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
		Template::set_block('sub_nav', 'embeds/_sub_nav');

		Assets::add_module_js('history', 'history.js');
	}

	/**
	 * Display a list of History data.
	 *
	 * @return void
	 */
	public function index()
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
					$deleted = $this->history_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
				}
				if ($result) {
					Template::set_message(count($checked) . ' ' . lang('history_delete_success'), 'success');
				} else {
					Template::set_message(lang('history_delete_failure') . $this->history_model->error, 'error');
				}
			}
		}
        
        
        
		$records = $this->history_model->where('embedid IS NOT NULL', null)->find_all();

		$historyNames = array();
		$editedEmbedNames = array();

		if($records){
		  foreach ($records as $record) {
		   $name = $this->history_model->getEmbedByID((string)$record->embedid)->name;
		   $editedEmbedName;
		   if($record->isedited){
		   		$editedEmbedName = $this->history_model->getEditedEmbedByID((string)$record->editedembedid)->name;
		   }
		   else{
		   		$editedEmbedName='';
		   }
		   array_push($editedEmbedNames, $editedEmbedName);
		   array_push($historyNames, $name);
		  	};
		  }

	Template::set('editedEmbedNames', $editedEmbedNames);	  
	Template::set('embedNames', $historyNames);

    Template::set('records', $records);
        
    Template::set('toolbar_title', lang('history_manage'));

		Template::render();
	}
    
    /**
	 * Create a History object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict($this->permissionCreate);
        
		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_history()) {
				log_activity($this->auth->user_id(), lang('history_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'history');
				Template::set_message(lang('history_create_success'), 'success');

				redirect(SITE_AREA . '/embeds/history');
			}

            // Not validation error
			if ( ! empty($this->history_model->error)) {
				Template::set_message(lang('history_create_failure') . $this->history_model->error, 'error');
            }
		}

		Template::set('toolbar_title', lang('history_action_create'));

		Template::render();
	}
	/**
	 * Allows editing of History data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$editedEmbedID= $this->session->userdata('editedembedID');
		$embedName= $this->session->userdata('embedname');

		$historyID = $this->uri->segment(5);
		$embedURI=getFolderURL($embedName);
		//echo "editedembedid ".$editedEmbedID.' historyID '.$id;
		$historyData['isedited']=1;
		$historyData['editedembedid']=$editedEmbedID;
		$this->history_model->update($historyID,$historyData);

		Template::set_message('You have successfully edited an embed with name<strong> '.$embedName.'</strong> and folder path <strong>'.$embedURI.'</strong>', 'success');
		redirect(SITE_AREA . '/embeds/history');

	}
	// public function edit()
	// {
	// 	$id = $this->uri->segment(5);
	// 	if (empty($id)) {
	// 		Template::set_message(lang('history_invalid_id'), 'error');

	// 		redirect(SITE_AREA . '/embeds/history');
	// 	}
        
	// 	if (isset($_POST['save'])) {
	// 		$this->auth->restrict($this->permissionEdit);

	// 		if ($this->save_history('update', $id)) {
	// 			log_activity($this->auth->user_id(), lang('history_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'history');
	// 			Template::set_message(lang('history_edit_success'), 'success');
	// 			redirect(SITE_AREA . '/embeds/history');
	// 		}

 //            // Not validation error
 //            if ( ! empty($this->history_model->error)) {
 //                Template::set_message(lang('history_edit_failure') . $this->history_model->error, 'error');
	// 		}
	// 	}
        
	// 	elseif (isset($_POST['delete'])) {
	// 		$this->auth->restrict($this->permissionDelete);

	// 		if ($this->history_model->delete($id)) {
	// 			log_activity($this->auth->user_id(), lang('history_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'history');
	// 			Template::set_message(lang('history_delete_success'), 'success');

	// 			redirect(SITE_AREA . '/embeds/history');
	// 		}

 //            Template::set_message(lang('history_delete_failure') . $this->history_model->error, 'error');
	// 	}
 //        $history=$this->history_model->find($id);

 //        Template::set('history',$history);
 //        Template::set('embedName',$this->history_model->getEmbedByID((string)$history->embedid)->name);
	// 	Template::set('toolbar_title', lang('history_edit_heading'));
	// 	Template::render();
	// }

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
	private function save_history($type = 'insert', $id = 0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

        // Validate the data
        $this->form_validation->set_rules($this->history_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

		// Make sure we only pass in the fields we want
		
		$data = $this->history_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
        $return = false;
		if ($type == 'insert') {
			$id = $this->history_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			}
		} elseif ($type == 'update') {
			$return = $this->history_model->update($id, $data);
		}

		return $return;
	}
	
	public function checkEditedEmbed(){
		$id = $this->uri->segment(5);
		$history=$this->history_model->find($id);
		if($history){
			if($history->isedited){
				//read editedembedid and generate update code
				//echo 'Edited';
				redirect(SITE_AREA . '/embeds/editedembed/create/'.$id);
			}
			else{
				//New editedembed
				//echo 'Not edited';
				redirect(SITE_AREA . '/embeds/editedembed/create/'.$id);			
			}
		}
	}
}