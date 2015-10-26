<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * IFrame controller
 *
 * The base controller which displays the homepage of the Admin Reports context in the Bonfire app.
 *
 * @package    Bonfire
 * @subpackage Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class IFrame extends MX_Controller
{


	/**
	 * Controller constructor sets the Title and Permissions
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('application');
		$this->load->helper('manage_files');
		$this->load->library('Template');
		$this->load->library('Assets');
		$this->lang->load('application');
		$this->load->library('events');
		$this->load->library('user_agent');
		$this->load->model('embedcontent/embedcontent_model');
		$this->load->model('history/history_model');
		$this->load->model('editedembed/editedembed_model');

		parse_str($_SERVER['QUERY_STRING'],$_GET);

        $this->load->library('installer_lib');
        if (! $this->installer_lib->is_installed()) {
            $ci =& get_instance();
            $ci->hooks->enabled = false;
            redirect('install');
        }

        // Make the requested page var available, since
        // we're not extending from a Bonfire controller
        // and it's not done for us.
        $this->requested_page = isset($_SESSION['requested_page']) ? $_SESSION['requested_page'] : null;
	}//end __construct()

	//--------------------------------------------------------------------
	public function get_client_ip() {
    	$ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	/**
	 * Displays the Reports context homepage
	 *
	 * @return void
	 */
	public function index()
	{

		$sourceurl = '';
		$iframe = urldecode($_GET['f']);


		
		$refer =  $this->agent->referrer();
		$embedHistory=null;
		$editedEmbed = null;
		//echo $refer;
		//getting embedName from url
		$parsedURL=parse_url($iframe);
		$explodedURL=explode("/",$parsedURL['path']);
		$embedName=$explodedURL[2];
		
		$embed=$this->embedcontent_model->find_by('name',$embedName);
		if ($embed == null){
			//try the editedembed
			$editedEmbed=$this->editedembed_model->find_by('name',$embedName);			
			$embed=$this->embedcontent_model->find($editedEmbed->embedid);			
		}


		//echo $embed->name;
		 if ($refer == site_url()){
		 	//echo 'Initiated from our site';

		 }
		 else{
		 	//echo $embed;		 	
		 	$array = array('pageurl' => $refer, 'embedid' => $embed->id);
		 	
		 	$embedHistory=$this->history_model
		 						->where($array)->find_all();
		 	//echo $refer;
		 	if($embedHistory){
		 		//echo $embedHistory->
		 		$singleEmbedHistory=$embedHistory[0];
		 		$data['count']=$singleEmbedHistory->count+1;
		 		//update code
		 		$this->history_model->update($singleEmbedHistory->id,$data);

		 		//generate iframe from editedembed
		 		if($singleEmbedHistory->isedited){
		 			$editedID=$singleEmbedHistory->editedembedid;
		 			$editedEmbed=$this->editedembed_model->find($editedID);
		 			// $iframe=getFolderURL($editedEmbed->name);
		 			// echo $iframe;
		 			// echo SITE_AREA .'/static/'.$editedEmbed->name;
		 			$iframe= $parsedURL["scheme"].'://'.$parsedURL["host"].'/static/'.$editedEmbed->name.'?'.$parsedURL["query"];

		 		}
		 	}
		 	else{
 		
		 		//echo 'new embed'.$iframe;
		 		//iframe has pageurl
		 		if($refer){
			 		$data['pageurl']=$refer;
			 		$data['active']=1;
			 		$data['instances']=1;
			 		$data['count']=1;
			 		$data['ipaddress']=$this->get_client_ip();
			 		$data['embedid']=$embed->id;
			 		$this->history_model->insert($data);
			 		//echo 'embedhistory inserted';
		 		}
		 		else{
		 			//echo 'No refer found';
		 		}


		 		// $this->history_model->insert($data);
		 		
		 	}
		 }


		//echo $refer;
		//echo $ipaddress;
		
		//exit();
		redirect($iframe );
		//$this->load->view('/home/iframe');

		//Template::render("iframe");
	}//end index()

	//--------------------------------------------------------------------


}//end class