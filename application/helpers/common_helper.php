<?php



if(!function_exists('settings')){
  function settings($value){
   $CI =& get_instance();

   $query=$CI->db->query("select * from system_settings WHERE status = 1");
   $result=$query->result_array();
   $response='';
   if(!empty($result))
   {
    foreach($result as $data){
      if($data['key'] == $value){
       $response = $data['value'];
     }
   }
 }
 return $response;
}
}

 function settings_currency($val){
    $ci =& get_instance();
    $query = $ci->db->query("select * from system_settings");
    
    $settings = $query->result_array();
    
    $result=array();        
        
    if(!empty($settings)){
      foreach($settings as $datas){
        if($datas['key']=='currency_option'){
          $result['currency'] = $datas['value'];
        }
      }
    }
    
    if(!empty($result[$val])) {
      $results= $result[$val];
    }
    else {
      $results= 'INR';
    }

    return $results;
 }

?>



