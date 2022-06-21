<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

 	public function __construct() {

 		parent::__construct();
 		$this->load->helper('push_notifications');
        $this->data['view'] = 'user';
        $this->data['base_url'] = base_url();

        $this->load->model('categories_model','category');
        $this->load->model('language_model','language');
        $this->data['language'] = $this->language->active_language();
		$this->data['category'] = $this->category->show_category();

		$this->load->helper('custom_language');
		$lang = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';

		$this->data['language_content'] = get_languages($lang);

        $this->web_validation_array = $this->data['language_content']['language'];

       	$this->load->model('request_model','request');

       	$this->load->model('subscription_model','subscription');
       	$this->load->helper('subscription_helper');
       	$this->latitude = !empty($this->session->userdata('user_latitude'))?$this->session->userdata('user_latitude'):'3.021998';
        $this->longitude =  !empty($this->session->userdata('user_longitude'))?$this->session->userdata('user_longitude'):'101.7055411';
        $user_id = $this->session->userdata('user_id');
        $this->data['user_id'] = $user_id;
        $this->data['subscription_details'] = get_subscription_details(md5($user_id));
    }

	public function index()
	{

  		$this->data['page'] = 'request';
  		$this->data['model'] = 'request';
  		$inputs['user_id'] = $this->session->userdata('user_id');
      	$inputs['page'] = 1;
    	$inputs['latitude'] = $this->latitude;
  	  	$inputs['longitude'] = $this->longitude;
  		$this->data['requests'] = $this->request->get_request($inputs);
  		$this->data['defaultcurrency']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
        $this->data['country_list']=$this->db->where('status',1)->order_by('country_name',"ASC")->get('country_table')->result_array();

  		$this->load->vars($this->data);
  		$this->load->view('template');
	}

		public function create_request()
	{
		$params = $this->input->post();
		if (!empty($_FILES['req_img']['name']))
		$params['request_image'] = $_FILES['req_img']['name'];
		
		if($this->input->post()){
			
			$params = $this->input->post();
      $params['title'] = $this->input->post('title');
      $params['description'] = $this->input->post('description');
      $params['location'] = $this->input->post('location');
      $params['latitude'] = $this->input->post('latitude');
      $params['longitude'] = $this->input->post('longitude');
      $params['request_date'] = $this->input->post('request_date');
      $params['request_time'] = $this->input->post('request_time');
      $params['proposed_fee'] = $this->input->post('proposed_fee');
      $params['countryCode']  = $this->input->post('countryCode');
      $params['contact_number']  = $this->input->post('contact_number');
      $params['request_image'] = (!empty($this->input->post('request_image')))?"uploads/add_request_image/" . $this->input->post('request_image'):'';
			$result = $this->request->create_new_request($params);
			if($result == '1'){
          /*
						$to_user_id = 0;
						$title = $params['title'];
						$user_id = $this->session->userdata('user_id');
						$name  = $this->request->username($user_id);
						$username = $name['username'];
						$message = '<b>'.$username.'</b> added new request';
            $notification_type = 'Create Request';
						$this->notifications($notification_type,$title,$message,$to_user_id,$user_id);
          */

				$this->session->set_flashdata('success_message',$this->web_validation_array['lg12_new_request_has']);
			}
			$this->session->set_flashdata('success_message',$this->web_validation_array['lg12_new_request_has']);
			echo $result;
			die();
		}
	}


		public function load_request()
	{
 		$inputs['user_id'] = $this->session->userdata('user_id');;
    	$inputs['page'] = $this->input->post('nextpage');
  		$inputs['latitude'] = $this->latitude;
  	  	$inputs['longitude'] = $this->longitude;
		$requests = $this->request->get_request($inputs);
		echo json_encode($requests);
		die();
	}

		public function search_request_load()
	{
		$inputs = array();
		$inputs['user_id'] = $this->session->userdata('user_id');;
    	$inputs['page'] = ($this->input->post('nextpage')>0)?$this->input->post('nextpage'):1;
    	$inputs['search_title'] = $this->input->post('search_title');
    	$inputs['request_date'] = !empty($this->input->post('request_date'))?$this->input->post('request_date'):'';
    	if(!empty($inputs['request_date'])){
    		$inputs['request_date'] = date('Y-m-d',strtotime($inputs['request_date']));
    	}
    	$inputs['request_time'] = $this->input->post('request_time');
    	$inputs['min_price'] = $this->input->post('min_price');
    	$inputs['max_price'] = $this->input->post('max_price');
    	$inputs['location'] = $this->input->post('location');

  		$inputs['latitude'] =!empty($this->input->post('latitude'))?$this->input->post('latitude'):$this->latitude;
  	  	$inputs['longitude'] =!empty($this->input->post('longitude'))?$this->input->post('longitude'):$this->longitude;
        $inputs['latitude'] = $this->latitude;
        $inputs['longitude'] = $this->longitude;

    		$requests = $this->request->get_request($inputs);
    		echo json_encode($requests);
    		die();
	}

	public function myrequest()
	{

  		$this->data['page'] = 'my_request';
  		$this->data['model'] = 'request';
  		$inputs['user_id'] = $this->session->userdata('user_id');
      $inputs['page'] = 1;
    	$this->data['requests'] = $this->request->my_request($inputs);
    	$this->data['defaultcurrency']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
  		$this->load->vars($this->data);
  		$this->load->view('template');
	}

		public function load_myrequest()
	{

 		$inputs = $this->input->post();
    	$inputs['user_id'] = $this->session->userdata('user_id');
    	$requests = $this->request->my_request($inputs);
		echo json_encode($requests);
		die();
	}



	public function add_request()
	{

		$this->data['page'] = 'add-request';
		$this->data['model'] = 'request';
        $this->data['country_list']=$this->db->where('status',1)->order_by('country_name',"ASC")->get('country_table')->result_array();

		$this->load->vars($this->data);
		$this->load->view('template');
	}

    public function edit_request($r_id) {

		$this->data['page'] = 'edit-request';
		$this->data['model'] = 'request';
        $this->data['request_details'] = $this->request->get_request_details($r_id);
    $this->data['country_list']=$this->db->where('status',1)->order_by('country_name',"ASC")->get('country_table')->result_array();
		$this->load->vars($this->data);
		$this->load->view('template');
	}

  public function update_request()
	{
		if($this->input->post()){
			$params = $this->input->post();
			$result = $this->request->update_request($params);

			$array = $params['data'];
      		parse_str($array, $params);
			if($result == 1){
          /*
						$to_user_id = 0;
						$title = $params['title'];
						$user_id = $this->session->userdata('user_id');
						$name  = $this->request->username($user_id);
						$username = $name['username'];
						$message = '<b>'.$username.'</b> updated his request';
            $notification_type = 'Update Request';
						$this->notifications($notification_type,$title,$message,$to_user_id,$user_id);
          */

				$this->session->set_flashdata('success_message',$this->web_validation_array['lg12_your_request_ha']);
			}
      elseif($result == 2){
				$this->session->set_flashdata('error_message',$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'].', '.$this->web_validation_array['lg12_please_try_agai']);
			}

			echo $result;
			die();
		}
	}

	public function request_view($r_id) {
      	$user_id = $this->session->userdata('user_id');
  		$this->data['page'] = 'request-view';
  		$this->data['model'] = 'request';
      	$this->data['request_details'] = $this->request->get_request_details($r_id);
      	$this->data['subscription_details'] = get_subscription_details(md5($user_id));
      	$this->data['defaultcurrency']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'default_currency'")->result_array();
  		$this->load->vars($this->data);
  		$this->load->view('template');
	}

	public function request_accept()
	{
		$r_id = $this->input->post('req_id');
		$result = $this->request->request_accept($r_id);
    if($result){
      $request_details = $this->request->get_request_details($r_id);
            /* Notification starts */
			      $to_user_id = $request_details['requester_id'];
						$title = $request_details['title'];
						$user_id = $this->session->userdata('user_id');
						$name  = $this->request->username($user_id);
						$username = $name['username'];
						$message = $username.' accepted your request';
            $notification_type = 'Request Accept';
						$this->notifications($notification_type,$title,$message,$to_user_id,$user_id);
            /* Notification ends */
      			$message=$this->web_validation_array['lg12_request_has_bee'];
		  $this->session->set_flashdata('success_message',$message);
      echo 1;
    }
    else{
			$message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'];
		  $this->session->set_flashdata('error_message',$message);
      echo 2;
    }
	}

  public function delete_request()
	{
		$r_id = $this->input->post('req_id');
    $accept = $this->request->get_accept();
    if(!in_array($r_id, $accept)){
  		$result = $this->request->delete_request($r_id);
      if($result){
  			$message=$this->web_validation_array['lg12_your_request_ha1'];
  		  $this->session->set_flashdata('success_message',$message);
        echo 1;
      }
      else{
  			$message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_something_went_'];
  		  $this->session->set_flashdata('error_message',$message);
        echo 2;
      }
  	}
    else{
      $message=$this->web_validation_array['lg12_sorry'].', '.$this->web_validation_array['lg12_you_cant_delete'].', '.$this->web_validation_array['lg12_someone_accepte'];
      $this->session->set_flashdata('error_message',$message);
      echo 3;
    }
  }

   public function notifications($notification_type,$title,$message,$to_user_id = 0,$login_id)
    {
    	$ios_target = array();
		$android_target = array();
	    $body =array(
						'notification_type'=>$notification_type,
						'title'=>   $title,
						'message'=> $message
						);


			$target	= $this->request->get_deviceids($to_user_id,$login_id);
			$deviceid = 0;

				$ios_target = $target['ios'];
				if(count($ios_target) > 0){
					$ios_target = array_map('current', $ios_target);
					$deviceid =1;
				}
				$android_target = $target['android'];
				if(count($android_target) > 0){
					$android_target = array_map('current', $android_target);
					$deviceid = 1;
				}

		$data['body'] = $body;
		// Android Notifications
		if(count($android_target) > 0){
			$android_result_array = sendFCMMessage($data,$android_target);
		}
		// iOS Notifications
		if(count($ios_target) > 0){
			$ios_result_array = sendFCMiOSMessage($data,$ios_target);
		}
    }



    public function mybooking()
	{

  		$this->data['page'] = 'my_booking';
  		$this->data['model'] = 'request';
  		$inputs['user_id'] = $this->session->userdata('user_id');
        $inputs['page'] = 1;
    	$this->data['requests'] = $this->request->mybooking($inputs);
  		$this->load->vars($this->data);
  		$this->load->view('template');
	}


	public function load_mybooking()
	{

  		$inputs = $this->input->post();
    	$inputs['user_id'] = $this->session->userdata('user_id');
    	$requests = $this->request->mybooking($inputs);
		echo json_encode($requests);
		die();
	}


	 public function bookingservice()
	{

  		$this->data['page'] = 'booking_service';
  		$this->data['model'] = 'request';
  		$inputs['user_id'] = $this->session->userdata('user_id');
        $inputs['page'] = 1;
        $this->data['requests'] = $this->request->bookingservice($inputs);
    	$this->load->vars($this->data);
  		$this->load->view('template');
	}

	public function load_mybookservice()
	{

 		$inputs = $this->input->post();
    	$inputs['user_id'] = $this->session->userdata('user_id');
    	$requests = $this->request->bookingservice($inputs);
		echo json_encode($requests);
		die();
	}

	 public function booking_status($id)
	{
		$this->db->where('md5(id)',$id);
		if($this->db->update('book_service',array('service_status' =>2)))
        {
		     $this->session->set_flashdata('success_message','Completed success');
                redirect('booking-service');
        }
        else
        {
             $this->session->set_flashdata('error_message','Complete failed');
             redirect('booking-service');
        }
	}

	public function post_reviews()
	{
		$inputs = $this->input->post();

		$new_details['user_id'] = $this->session->userdata('user_id');

        $new_details['p_id'] = $inputs['p_id'];

        $new_details['type'] = '';

        $new_details['rating'] = $inputs['rating'];

        $new_details['review'] = $inputs['review'];

        $new_details['created'] =  date('Y-m-d H:i:s');

        $this->db->where('status',1);

        $this->db->where('p_id',$inputs['p_id']);

        $this->db->where('user_id', $user_id);

        $count = $this->db->count_all_results('rating_review');

        if($count == 0)

        {

              if($this->db->insert('rating_review', $new_details))
              {
              		 $this->session->set_flashdata('success_message','Thanks for rating');
                     redirect('my-booking');
              }
              else
              {
              		$this->session->set_flashdata('error_message','Rating failed');
                    redirect('my-booking');
              }
        }

        else

        {

          return $result = 2;

        }
	}

	public function image_resize($width=0,$height=0,$image_url,$filename){          
        
    $source_path = base_url().$image_url;
    list($source_width, $source_height, $source_type) = getimagesize($source_path);
    switch ($source_type) {
    case IMAGETYPE_GIF:
        $source_gdim = imagecreatefromgif($source_path);
        break;
    case IMAGETYPE_JPEG:
        $source_gdim = imagecreatefromjpeg($source_path);
        break;
    case IMAGETYPE_PNG:
        $source_gdim = imagecreatefrompng($source_path);
        break;
}

$source_aspect_ratio = $source_width / $source_height;
$desired_aspect_ratio = $width / $height;

if ($source_aspect_ratio > $desired_aspect_ratio) {
    /*
     * Triggered when source image is wider
     */
    $temp_height = $height;
    $temp_width = ( int ) ($height * $source_aspect_ratio);
} else {
    /*
     * Triggered otherwise (i.e. source image is similar or taller)
     */
    $temp_width = $width;
    $temp_height = ( int ) ($width / $source_aspect_ratio);
}

/*
 * Resize the image into a temporary GD image
 */

$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
imagecopyresampled(
    $temp_gdim,
    $source_gdim,
    0, 0,
    0, 0,
    $temp_width, $temp_height,
    $source_width, $source_height
);

/*
 * Copy cropped region from temporary image into the desired GD image
 */

$x0 = ($temp_width - $width) / 2;
$y0 = ($temp_height - $height) / 2;
$desired_gdim = imagecreatetruecolor($width, $height);
imagecopy(
    $desired_gdim,
    $temp_gdim,
    0, 0,
    $x0, $y0,
    $width, $height
);

/*
 * Render the image
 * Alternatively, you can save the image in file-system or database
 */
$filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
   $image_url =  "/uploads/category_images/".$filename.".jpg";    
imagejpeg($desired_gdim,$image_url);

return $image_url;

/*
 * Add clean-up code here
 */
} 

}
