<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requester_chat_model extends CI_Model {

	public function __construct() {

        parent::__construct();
        $this->load->database();
        date_default_timezone_set('UTC');
    }

    public function get_history($id,$page)
    {
      
      $this->db->select('id,chat_from,chat_to');
      $this->db->from('chats_requester');
      $this->db->where("chat_from = $id OR chat_to = $id");
      $this->db->order_by('id', 'desc');
      $chat_history = $this->db->get()->result_array();
      $chat_user_ids = array();
      if(!empty($chat_history)){
        foreach ($chat_history as $history) {
          $from = $history['chat_from'];
          if(!in_array($from, $chat_user_ids) && $from!=$id){
            $chat_user_ids[] = $from; 
            $chat_ids[] = $history['id']; 
          }
          $to = $history['chat_to'];
          if(!in_array($to, $chat_user_ids) && $to!=$id){
            $chat_user_ids[] = $to; 
            $chat_ids[] = $history['id']; 
          }
        }
      }
      $history     = array();
      $chathistory = array();
      $count       = 0;
      if(!empty($chat_ids)){

        $offset = ($page>1)?(($page-1)*10):0;
              
        $this->db->select('*');
        $this->db->from('chats_requester C');
        $this->db->join('users UF','UF.user_id= C.chat_to','left');
        $this->db->join('users UT','UT.user_id= C.chat_from','left');
        $this->db->where_in("id",$chat_ids);
        
        $this->db->where('from_delete_sts', 0);
        $this->db->where('to_delete_sts', 0);
        $count = $this->db->get()->num_rows();


        $this->db->select('*');
        $this->db->from('chats_requester C');
        $this->db->join('users UF','UF.user_id= C.chat_to','left');
        $this->db->join('users UT','UT.user_id= C.chat_from','left');
        $this->db->where_in("id",$chat_ids);
        
        $this->db->where('status', 1);
        $unreadcount = $this->db->get()->num_rows();



        $this->db->select('C.id,C.chat_from,C.chat_to,C.content,C.chat_utc_time,C.status,UF.username as fromname,UF.profile_img as from_profile_img,UT.username,UT.profile_img as profile_img');
        $this->db->from('chats_requester C');
        $this->db->join('users UF','UF.user_id= C.chat_to','left');
        $this->db->join('users UT','UT.user_id= C.chat_from','left');
        $this->db->where_in("id",$chat_ids);
        
        $this->db->where('from_delete_sts', 0);
        $this->db->where('to_delete_sts', 0);
        $this->db->order_by('id', 'desc');
        $this->db->limit(10, $offset);
        $chathistory_array =  $this->db->get()->result_array();
        $chathistory = array();
              
              $user_id = $this->session->userdata('user_id');
              if(count($chathistory_array) > 0){

                foreach ($chathistory_array as $value) {
                  if($value['chat_from'] !=  $user_id){
                    $value['unreadcount']=$this->get_unread_count($user_id,$value['chat_from']);
                    unset($value['chat_to'],$value['fromname'],$value['from_profile_img']);
                    $chathistory[] = $value;

              }else{
                  $value['profile_img'] = $value['from_profile_img'];
                  $value['username']  = $value['fromname'];
                  $value['chat_from'] = $value['chat_to'];
                  $value['unreadcount']='0';
                  unset($value['chat_to'],$value['fromname'],$value['from_profile_img']);
                  $chathistory[] = $value;
              }
            }
          }

      }
      
         
       $total_pages = 0;
       $next_page  = -1;

      

      if($count > 0 && $page > 0){

         $total_pages = ceil($count / 10);
         if($page < $total_pages){

           $next_page = ($page + 1);

         }else{

           $next_page = -1;
         }
      }
      $history['next_page']    = $next_page;
      $history['current_page'] = $page;
      $history['total_pages']  = $total_pages;
      $history['chat_list'] = $chathistory;



    return $history;
    }

    public function get_unread_count($chat_to,$chat_from)
  {
   
    $result=$this->db->where('chat_to',$chat_to)->where('chat_from',$chat_from)->where('status',0)->get('chats_requester')->num_rows();
    return $result;
  }

    public function search_chat_user($username)
    {
      if(!empty($username)){
          $query = $this->db->query("SELECT user_id FROM `users` WHERE `username` LIKE '%$username%' ORDER BY `tokenid` ASC");
          if($query->num_rows() > 0){ 
             
             $ids = $query->result_array();
             $ids = array_map('current', $ids);
             $id = $this->session->userdata('user_id');
             print_r($ids);
             exit;

          }
      }
    }

    public function chat_userdeetails($id)
    {
    	$this->db->select('user_id,username, profile_img as image');
    	return $this->db->get_where('users', array('md5(user_id)'=>$id))->row_array();
    }

    public function chat_conversation($array,$last_id)
    {
        $this->db->insert('chats_requester', $array);
        $f_id = $array['chat_from'];
        $t_id = $array['chat_to'];
        return $this->conversationcall($f_id,$t_id,$last_id); 
    }

    public function conversationcall($from,$to,$last_id)
    {
     
     $this->db->where("((chat_from = '$from' AND chat_to = '$to') OR (chat_from = '$to' AND chat_to = '$from'))");
     $this->db->where('id >',$last_id);
     return $this->db->get('chats_requester')->result_array();
          
    }

      public function username($id)
   {
     $this->db->select('username');
     return $this->db->get_where('users', array('user_id'=>$id))->row_array();
   }

      public function get_deviceids($id,$login_id)
   {
      $result_array = array();
      $where        = array();
      $result_array['android'] = array();
      $result_array['ios'] = array();

      $this->db->select('device_id');
      $where['device_type'] = 'ios';
      if($id!=0){
        $where['user_id']     = $id;  
      }
      
      $this->db->where($where);
      $this->db->where('user_id !=', $login_id);
      $result_array['ios']  = $this->db->get('device_details')->result_array();

      $where        = array();
      $where['device_type'] = 'android';
      
      if($id!=0){
        $where['user_id']     = $id;  
      }
      $this->db->select('device_id');
      $this->db->where($where);
      $this->db->where('user_id !=', $login_id);
      $result_array['android']  = $this->db->get('device_details')->result_array();
      return $result_array;
   }

    public function conversations($id,$user_id,$page)
    {
    	$this->db->select('*');
        $this->db->from('chats_requester C');
        $this->db->join('users UF','UF.user_id= C.chat_from','left');
        $this->db->join('users UT','UT.user_id= C.chat_to','left');
        $this->db->where("(md5(chat_from) = '$id' AND chat_to = '$user_id') OR (chat_from = '$user_id' AND md5(chat_to) = '$id')");
        $this->db->where('from_delete_sts', 0);
        $this->db->where('to_delete_sts', 0);
        $count = $this->db->get()->num_rows();
        
        $offset = ($page>1)?(($page-1)*10):0;

        $this->db->select('C.id,C.chat_from,C.chat_to,C.content,C.chat_utc_time,C.status,UF.username as fromname,UT.username as toname,UF.profile_img as from_profile_img,UT.profile_img as to_profile_img');
    		$this->db->from('chats_requester C');
    		$this->db->join('users UF','UF.user_id= C.chat_from','left');
    		$this->db->join('users UT','UT.user_id= C.chat_to','left');
    	$this->db->where("(md5(chat_from) = '$id' AND chat_to = '$user_id') OR (chat_from = '$user_id' AND md5(chat_to) = '$id')");
    	$this->db->where('from_delete_sts', 0);
    	$this->db->where('to_delete_sts', 0);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(10, $offset);
        $chathistory = $this->db->get()->result_array();
        if(count($chathistory) > 0){
          usort($chathistory,function($a,$b){
               $x = $a['id'];
              $y = $b['id'];
               if ($x== $y)
              return 0;
              if ($x < $y)
                return -1;
          else
              return 1;
          });
          
        }
        $chathistory_new = array();
        if(!empty($chathistory)){
          foreach ($chathistory as $chat) {
            $datetime = $chat['chat_utc_time'];
            $time = utc_date_conversion($datetime);
            $chat['time'] = date('h:i A',strtotime($time));
            $chat['date'] = date('Y-m-d',strtotime($time));
            $chathistory_new[] = $chat;
          }
        }
        
        $chathistory = $chathistory_new;
        
        $total_pages = 0;
        $next_page  = -1;

      if($count > 0 && $page > 0){

         $total_pages = ceil($count / 10);
         if($page < $total_pages){

           $next_page = ($page + 1);

         }else{

           $next_page = -1;
         }
      }
      
      date_default_timezone_set("Asia/Kuala_Lumpur");

      $date_time = date('Y-m-d');
      $y_date_time = date('Y-m-d',strtotime("-1 days"));

      $history['today_date']        = $date_time;
      $history['yesterday_date']    = $y_date_time;
      $history['next_page']    = $next_page;
      $history['current_page'] = $page;
      $history['total_pages']  = $total_pages;
      $history['chat_list']    = $chathistory;
      return $history;
    }
     public function request_last_record()
    {
      $this->db->select("*");
      $this->db->from("chats_requester");
      $this->db->limit(1);
      $this->db->order_by('id',"DESC");
      return $this->db->get()->row_array();
      
    }
			 
}
