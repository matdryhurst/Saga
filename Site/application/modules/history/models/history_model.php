<?php defined('BASEPATH') || exit('No direct script access allowed');

class History_model extends BF_Model
{
    protected $table_name	= 'bf_embedshistory';
	protected $key			= 'id';
	protected $date_format	= 'datetime';
	protected $created_field     = 'createdon';
 	protected $modified_field    = 'modifiedon';

	protected $log_user 	= false;
	protected $set_created	= true;
	protected $set_modified = true;
	protected $soft_deletes	= false;


	// Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
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
			'field' => 'ipaddress',
			'label' => 'lang:history_field_ipaddress',
			'rules' => 'max_length[100]',
		),
		array(
			'field' => 'createdon',
			'label' => 'lang:history_field_createdon',
			'rules' => '',
		),
		array(
			'field' => 'modifiedon',
			'label' => 'lang:history_field_modifiedon',
			'rules' => '',
		),
		array(
			'field' => 'pageurl',
			'label' => 'lang:history_field_pageurl',
			'rules' => 'max_length[100]',
		),
		array(
			'field' => 'count',
			'label' => 'lang:history_field_count',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'instances',
			'label' => 'lang:history_field_instances',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'active',
			'label' => 'lang:history_field_active',
			'rules' => 'max_length[1]',
		),
		array(
			'field' => 'embedid',
			'label' => 'lang:history_field_embedid',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'isedited',
			'label' => 'lang:history_field_isedited',
			'rules' => 'max_length[1]',
		),
		array(
			'field' => 'editedembedid',
			'label' => 'lang:history_field_editedembedid',
			'rules' => 'max_length[11]',
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
	 * Save the data.
	 *
	 * @param string $type Either 'insert' or 'update'.
	 *
	 * @return bool|int An int ID for successful inserts, true for successful
     * updates, else false.
	 */
	public function getEmbedByID($id_embed=string)
    {
        $this->db->select('id,name');
        $this->db->from('embed');
        $this->db->where('id',$id_embed); 
        $query = $this->db->get()->row();
      
        return $query;
    }
    public function getEditedEmbedByID($editedEmbedID=string)
    {
        $this->db->select('id,name');
        $this->db->from('editedembed');
        $this->db->where('id',$editedEmbedID); 
        $query = $this->db->get()->row();
        return $query;
    }

}