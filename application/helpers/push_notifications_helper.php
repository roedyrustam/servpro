<?php 

if(!function_exists('sendFCMMessage')){

/* Example Parameter $data = array('from'=>'Lhe.io','title'=>'FCM Push Notifications');
	$target = 'single token id or topic name';
	or
	$target = array('token1','token2','...'); // up to 1000 in one request for group sending
*/
 function sendFCMMessage($data,$target){
   //FCM API end-point
   $url = 'https://fcm.googleapis.com/fcm/send';
   //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key

          $CI =& get_instance();
         $query = $CI->db->query("select * from system_settings WHERE status = 1");
        $result = $query->result_array();
        $server_key ='';
        if(!empty($result))
        {
            foreach($result as $datas){
           
            if($datas['key'] == 'firebase_server_key'){
                     $server_key = $datas['value'];
            }
            
            }
        }


  		
   $fields = array();
   $fields['data'] = $data;
   if(is_array($target)){
	$fields['registration_ids'] = $target;
   }else{
	$fields['to'] = $target;
   }

   
   //header with content_type api key
   $headers = array(
	'Content-Type:application/json',
        'Authorization:key='.$server_key
   );
   //CURL request to route notification to FCM connection server (provided by Google)			
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
   $result = curl_exec($ch);
   
   if ($result === FALSE) {
	die('Oops! FCM Send Error: ' . curl_error($ch));
   }
   curl_close($ch);
   return $result;
 }
}
if(!function_exists('sendFCMiOSMessage'))
{
   function sendFCMiOSMessage($data,$target){


     $CI =& get_instance();
         $query = $CI->db->query("select * from system_settings WHERE status = 1");
        $result = $query->result_array();
        $server_key ='';
        if(!empty($result))
        {
            foreach($result as $datas){
           
            if($datas['key'] == 'firebase_server_key'){
                     $server_key = $datas['value'];
            }
            
            }
        }

   $ch = curl_init("https://fcm.googleapis.com/fcm/send");

       //Title of the Notification.
    $title = $data['body']['title'];

    //Body of the Notification.
    $body = $data['body']['message'];

    $notification_type = $data['body']['notification_type'];

    //Creating the notification array.
    $notification = array('title' =>$title , 'text' => $body , 'notification' => $notification_type);
    
    
   $notification['notification']= $notification_type;  
   
   if($notification_type == 'chat'){
      
      $notification['chat_from']= $data['body']['from_userid'];  
      $notification['chat_from_name']= $data['body']['from_username'];  
      $notification['time']= $data['body']['time'];  
      $notification['utctime']= $data['body']['utctime'];  
    }
   

    //This array contains, the token and the notification. The 'to' attribute stores the token.
    $arrayToSend = array('notification' => $notification,'priority'=>'high');

    if(is_array($target)){
        $arrayToSend['registration_ids'] = $target;
   }else{
       $arrayToSend['to'] = $target;
   }

    //Generating JSON encoded string form the above array.
    $json = json_encode($arrayToSend);
    //Setup headers:
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key= '. $server_key.''; // key here

    //Setup curl, add headers and post parameters.
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       

    //Send the request
    $response = curl_exec($ch);

    //Close request
    curl_close($ch);
    return $response; 
   }
}

 ?>