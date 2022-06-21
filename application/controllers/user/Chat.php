<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

	 public function __construct() {
        parent::__construct();
        $this->load->model('chat_model','chat');
        $this->load->helper('user_timezone');
        $this->load->helper('push_notifications');
        $this->load->library('encryption');
		$this->load->model('categories_model','category');
        $this->load->model('language_model','language');
        $this->data['language'] = $this->language->active_language();
		$this->data['category'] = $this->category->show_category(); 

			  $this->load->helper('custom_language');
			  $lang = !empty($this->session->userdata('lang'))?$this->session->userdata('lang'):'en';
			  $this->data['language_content'] = get_languages($lang);

        $this->data['view'] = 'user';
        $this->data['base_url'] = base_url();
        $this->latitude = !empty($this->session->userdata('user_latitude'))?$this->session->userdata('user_latitude'):'3.021998';
        $this->longitude =  !empty($this->session->userdata('user_longitude'))?$this->session->userdata('user_longitude'):'101.7055411';$user_id = $this->session->userdata('user_id');
        $this->data['user_id'] = $user_id;
				$this->load->helper('subscription_helper');
        $this->data['subscription_details'] = get_subscription_details(md5($user_id));
        if(empty($this->session->userdata('user_id')))
		{
			redirect(base_url());
		}
    }


	public function index()
	{
		
		$this->data['page'] = 'chat';
		$this->data['model'] = 'chat';
		$id = $this->uri->segment(2);

		$key = '';
		$user_id = $this->session->userdata('user_id');
		$page = 1;
		
		$this->data['chat_from'] = $this->chat->chat_userdeetails($id,$page);
		$this->data['chats'] = $this->chat->conversations($id,$user_id,$page);
		$this->data['user_id'] = $this->session->userdata('user_id');
		$this->data['latitude'] = $this->latitude;
	  	$this->data['longitude'] = $this->longitude;
	  	
		$this->load->vars($this->data);
		$this->load->view('template');
	}

	public function get_chats()
	{
		
		// $this->data['page'] = 'chat';
		// $this->data['model'] = 'chat';
		$id = $this->uri->segment(2);

		$key = '';
		$user_id = $this->session->userdata('user_id');
		$page = 1;
		
		$chat['chat_from'] = $this->chat->chat_userdeetails($id,$page);
		$chat['chats'] = $this->chat->conversations($id,$user_id,$page);
		$chat['user_id'] = $this->session->userdata('user_id');
		$chat['last_record'] = $this->chat->last_record();
		
		$this->data['latitude'] = $this->latitude;
	  	$this->data['longitude'] = $this->longitude;
	  	$json[]=$chat;
	  	echo json_encode($json);
		// $this->load->vars($this->data);
		// $this->load->view('template');
	}

	public function provider_chat_history()
	{
		
		
		$id = $this->uri->segment(2);

		$key = '';
		$user_id = $this->session->userdata('user_id');
		$page = 1;
		
		$chat['chat_from'] = $this->chat->chat_userdeetails($id,$page);
		$chat['chats'] = $this->chat->conversations($id,$user_id,$page);
		$chat['user_id'] = $this->session->userdata('user_id');
		$this->data['latitude'] = $this->latitude;
	  	$this->data['longitude'] = $this->longitude;
	  	$json[]=$chat;
	  	echo json_encode($json);
		
	}


	public function load_previous_chat()
	{
		$page    = $this->input->post('page');
		$id    = $this->input->post('to');
		if($page!=0 && $page!=-1){
			$id = md5($id);
			$user_id = $this->session->userdata('user_id');
			$result  = $this->chat->conversations($id,$user_id,$page);

			echo json_encode($result);
			die();
		}
	}





	public function chat_history()
	{
			$user_id = $this->session->userdata('user_id');
			$history = $this->chat->get_history($user_id,1);

			$this->data['page'] = 'chat-history';
			$this->data['model'] = 'chat';
			$this->data['history'] = $history;
			$inputs['user_id'] = $this->session->userdata('user_id');
    		$inputs['latitude'] = $this->latitude;
  	  		$inputs['longitude'] = $this->longitude;
	  		$this->load->vars($this->data);
			$this->load->view('template');
/*
			$history = $this->chat->search_chat_user('si');
			echo "<pre>";
			print_r($history);
			exit;*/
	}

	public function load_chat_history()
	{
		if(!empty($this->input->post())){
			$page = $this->input->post('page');
			$user_id = $this->session->userdata('user_id');
			$history = $this->chat->get_history($user_id,$page);
			$historynew = array();
			if(count($history['chat_list']) >0){
				foreach ($history['chat_list'] as $data) {
					$time = $data['chat_utc_time'];
					//date_default_timezone_set("Asia/Kuala_Lumpur");
					$date_time = date('Y-m-d H:i:s');
					$id = md5($data['chat_from']);
					$ago = time_differences_ago($time,$date_time);
					$data['ago'] = $ago;
					$historynew[]= $data;
				}
			}
			$history['chat_list'] =$historynew;
			echo json_encode($history);
			die();
		}

	}



	public function chat_conversation()
	{
		if($this->input->post()){
			$array = array();
			 date_default_timezone_set('Asia/Kolkata');
			 $date_time = date('Y-m-d H:i');
			 $date = date('Y-m-d');
			 $array['chat_from'] = $this->input->post('from');
			 $array['chat_to'] = $this->input->post('to');
			 $last_id = $this->input->post('last_id');
			 $array['content'] = $this->input->post('content');
			 $array['chat_utc_time'] = $date_time;
			 $history = $this->chat->chat_conversation($array,$last_id);

			 /* Notification Start */
			 $utctime = $date_time;
			 //$time = utc_date_conversion($utctime);
			 $time = date('h:i A',strtotime($time));
			 $to_user_id   		  = $array['chat_to'];
			 $from_user_id 		  = $array['chat_from'];
			 $message              = $array['content'];

		 	 $name  = $this->chat->username($from_user_id);
			 $title = $name['username'];

			 $toname  = $this->chat->username($to_user_id);
			 $to_name = $toname['username'];
			 $body =array(
						'notification_type'=>'chat',
						'title'=>   $title,
						'message'=> $message,
						'date' => $date,
						'from_username'=> $title,
						'from_userid'=> $from_user_id,
						'to_userid' => $to_user_id,
						'to_username' => $to_name,
						'time'=> $time,
						'utctime'=> $utctime
						);
			 	$login_id = $from_user_id;
				$target	= $this->chat->get_deviceids($to_user_id,$login_id);
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

		$notificationdata =array();
		$notificationdata['body'] = $body;


		// Android Notifications
		$error = 0 ;
		$error1 = 0 ;
		if(count($android_target) > 0){
			$android_result_array = sendFCMMessage($notificationdata,$android_target);
		}else{
			$error = 1;
		}
		// iOS Notifications
		if(count($ios_target) > 0){
			$ios_result_array = sendFCMiOSMessage($notificationdata,$ios_target);
		}else{
			$error1 = 1;
		}
			 /* Notification End */
			 $lists = array();
			 foreach ($history as $mychat) {
			 	$time = $mychat['chat_utc_time'];
			 	$mychat['time'] = date('h:i A',strtotime($time));
			 	$lists[]  = $mychat;
			 }
			 echo json_encode($lists);
			 die();
		}
		die();
	}

	public function conversationcall()
	{
		if($this->input->post()){
		$from     = $this->input->post('from');
		$to       = $this->input->post('to');
		$last_id  = $this->input->post('last_id');
		$history = $this->chat->conversationcall($from,$to,$last_id);
		$lists = array();
		foreach ($history as $mychat) {
		 	$time = $mychat['chat_utc_time'];
		 	$mychat['time'] = date('h:i A',strtotime($time));
		 	$lists[]  = $mychat;
		}
		echo json_encode($lists);
		die();
		}
	die();
	}

	public function unread_count()
	{
		$to=$this->input->post('to');

		$result=$this->db->where('chat_to',$to)->where('status',0)->get('chats')->num_rows();
		echo $result;
	}

	public function readchat()
	{
		$from=$this->input->post('from');
		$to=$this->input->post('to');

		$this->db->where('chat_to',$from);
		$this->db->where('chat_from',$to);
		$this->db->update('chats',array('status'=>1));

	}

}
