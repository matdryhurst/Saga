<?php defined('BASEPATH') || exit('No direct script access allowed');

class Templates_model extends BF_Model
{
    protected $table_name	= 'template';
	protected $key			= 'id';
	protected $date_format	= 'datetime';

	protected $log_user 	= false;
	protected $set_created	= true;
	protected $set_modified = true;
	protected $soft_deletes	= false;

	protected $created_field     = 'created_on';
	protected $modified_field    = 'modified_on';

	// Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array('delete_related_records');
	protected $after_delete 	= array();

	// For performance reasons, you may require your model to NOT return the id
	// of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
	protected $return_insert_id = true;

	// The default type for returned row data.
	protected $return_type = 'object';

	// Items that are always removed from data prior to inserts or updates.
	protected $protected_attributes = array();

	// You may need to move certain rules (like required) into the
	// $insert_validation_rules array and out of the standard validation array.
	// That way it is only required during inserts, not updates which may only
	// be updating a portion of the data.
	protected $validation_rules 		= array(
		array(
			'field' => 'name',
			'label' => 'lang:templates_field_name',
			'rules' => 'max_length[100]|required|is_unique[template.name]',
		),
		
		array(
			'field' => 'created_on',
			'label' => 'lang:templates_field_created_on',
			'rules' => '',
		),
		array(
			'field' => 'modified_on',
			'label' => 'lang:templates_field_modified_on',
			'rules' => '',
		),
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * getTemplates
     *
     * @return data
     */
    public function getTemplates()
    {
        $this->db->select('id,name');
        $this->db->from('template'); 
        $query = $this->db->get();
         
         foreach($query->result_array() as $row){
            $data[$row['id']]=$row['name'];
        }
        return $data;
    }

    //--------------------------------------------------------------------
	// !PUBLIC METHODS
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
	public function getTemplateById($id_template=string)
    {
        $this->db->select('id,name,filename');
        $this->db->from('template');
        $this->db->where('id',$id_template); 
        $query = $this->db->get()->row();
      
        return $query;
    }

    protected function delete_related_records($primary_key)
	{
		$this->load->model('embedcontent/embedcontent_model');
		$this->load->model('editedembed/editedembed_model');
		$this->load->model('history/history_model');

		$this->load->helper('manage_files');
		 
		
		

		$embeds = $this->embedcontent_model->where_in('templateid', $primary_key)->find_all();
		if ($embeds == null){
			return true;
		}
		foreach($embeds as $embed){

			$wheres = array(
					    'embedid'    => $embed->id
				);
			//clean up the public iframe folder
			$this->history_model->delete_where($wheres);
			$editedembeds = $this->editedembed_model->where('embedid', $embed->id)->find_all();
			if ($editedembeds != null){				
				foreach($editedembeds as $editembed){
				 	$deletepath = $this->config->item('smartembed_static_site_location'). $editembed->name;
				 	$is_file_delete = deleteFolderAndAllFiles($deletepath);
				 	$this->editedembed_model->delete($editembed -> id);
				}
			}

		 	$deletepath = $this->config->item('smartembed_static_site_location'). $embed->name;
		 	$is_file_delete = deleteFolderAndAllFiles($deletepath);
		 	$this->embedcontent_model->delete($embed -> id);
		}

	    return true;
	}
}