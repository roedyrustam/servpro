<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {   
   public $data;
   public function __construct() {

      parent::__construct();
      $this->load->model('dashboard_model','dashboard');
              $this->load->model('common_model','common_model');

      $this->data['view'] = 'admin';
      $this->session->keep_flashdata('error_message');
      $this->session->keep_flashdata('success_message');
      $this->data['base_url'] = base_url();
      $this->load->helper('user_timezone');
      $this->load->helper('common_helper');
  }

  public function index()
  {  
     $this->common_model->checkAdminUserPermission(11);

     $this->data['page'] = 'index';
     $this->data['model'] = 'cms';
     $this->data['specialities_title']=settings('specialities_title');
     $this->data['specialities_content']=settings('specialities_content');
     $this->data['banner']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'banner'")->result_array();
     $this->data['doctor_title']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'doctor_title'")->result_array();
     $this->data['doctor_content']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'doctor_content'")->result_array();
     $this->data['android_app_link']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'android_app_link'")->result_array();
      $this->data['ios_app_link']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'ios_app_link'")->result_array();
     $this->data['login_image']=$this->db->query("SELECT value FROM `system_settings` WHERE `key` = 'login_image'")->result_array();
     $this->load->vars($this->data);
     $this->load->view('template');
 }

 public function add_doctor(){
                  $this->common_model->checkAdminUserPermission(11);

    $table_data1['update_date']  = date('Y-m-d');
    $table_data1['value']       = $this->input->post("doctor_title");
    $table_data2['update_date']  = date('Y-m-d');    
    $table_data2['value']       = $this->input->post("doctor_content");
    $update=$this->db->where('key=','doctor_title')->update('system_settings', $table_data1);
    $update=$this->db->where('key=','doctor_content')->update('system_settings', $table_data2);
    $message= "CMS updated successfully";
    $this->session->set_flashdata('success_message',$message);
    redirect(base_url()."admin/cms"); 
 }

 public function update_available_feature(){
                  $this->common_model->checkAdminUserPermission(11);

    if(isset($_FILES["availabe_feature_image"]["name"]) && $_FILES["availabe_feature_image"]["name"] != ""){
    $file = $_FILES["availabe_feature_image"]['tmp_name'];
    list($width, $height) = getimagesize($file);

   $av_file         = $_FILES['availabe_feature_image'];
   $src             = 'uploads/availabe_feature_image/'.$av_file['name'];
   $imageFileType   = pathinfo($src,PATHINFO_EXTENSION);
   $image_name     = time().'.'.$imageFileType;
   $src2            = 'uploads/availabe_feature_image/'.$image_name;

   move_uploaded_file($av_file['tmp_name'], $src2);

   $check=$this->db->where('key=','availabe_feature_image')->from('system_settings')->count_all_results();

   $table_data['key']        = 'availabe_feature_image';
   $table_data['value']      = $src2;
   $table_data['system']      = 1;
   $table_data['groups']      = 'config';
   $table_data['update_date']  = date('Y-m-d');
   $table_data['status']       = 1;
   
   if($check>0){
    $update=$this->db->where('key=','availabe_feature_image')->update('system_settings', $table_data);
    }else{
    $update=$this->db->insert('system_settings', $table_data);
   }
   if($update==true){
    $img_urls=base_url().$src2;
    $message= "CMS updated successfully";
    $this->session->set_flashdata('success_message',$message);
    redirect(base_url()."admin/cms");
    }
  }       
 }

 public function add_banner(){
                  $this->common_model->checkAdminUserPermission(11);

  if(isset($_FILES["banner"]["name"]) && $_FILES["banner"]["name"] != ""){
    $file = $_FILES["banner"]['tmp_name'];
    list($width, $height) = getimagesize($file);

   $av_file         = $_FILES['banner'];
   $src             = 'uploads/banner/'.$av_file['name'];
   $imageFileType   = pathinfo($src,PATHINFO_EXTENSION);
   $image_name     = time().'.'.$imageFileType;
   $src2            = 'uploads/banner/'.$image_name;

   move_uploaded_file($av_file['tmp_name'], $src2);

   $check=$this->db->where('key=','banner')->from('system_settings')->count_all_results();

   $table_data['key']        = 'banner';
   $table_data['value']      = $src2;
   $table_data['system']      = 1;
   $table_data['groups']      = 'config';
   $table_data['update_date']  = date('Y-m-d');
   $table_data['status']       = 1;
   
   if($check>0){
    $update=$this->db->where('key=','banner')->update('system_settings', $table_data);
    }else{
    $update=$this->db->insert('system_settings', $table_data);
   }
   if($update==true){
    $img_urls=base_url().$src2;
    $message= "CMS updated successfully";
    $this->session->set_flashdata('success_message',$message);
    redirect(base_url()."admin/cms");
    }
  }else{
    redirect(base_url()."admin/cms");
  }
}

public function add_specialities(){
                $this->common_model->checkAdminUserPermission(11);

    if(!empty($_POST)){
        foreach ($_POST as $key => $value) {

           $table_data['key']        = $key;
           $table_data['value']      = $value;
           $table_data['system']      = 1;
           $table_data['groups']      = 'config';
           $table_data['update_date']  = date('Y-m-d');
           $table_data['status']       = 1;
           $check=$this->db->where('key=',$key)->from('system_settings')->count_all_results();
           if($check>0){
            $update=$this->db->where('key=',$key)->update('system_settings', $table_data);
        }else{
            $update=$this->db->insert('system_settings', $table_data);
        }

    }

    echo json_encode(['success'=>true,'msg'=>"Update Sucessfully"]);

}
}
public function add_login(){ 
                  $this->common_model->checkAdminUserPermission(11);


    if(isset($_FILES)){
        $av_file         = $_FILES['banner'];
        $src             = 'uploads/banner/'.$av_file['name'];
        $imageFileType   = pathinfo($src,PATHINFO_EXTENSION);
        $image_name     = time().'.'.$imageFileType;
        $src2            = 'uploads/banner/'.$image_name;

        move_uploaded_file($av_file['tmp_name'], $src2);

        $check=$this->db->where('key=','banner_image')->from('system_settings')->count_all_results();

        $table_data['key']        = 'banner_image';
        $table_data['value']      = $src2;
        $table_data['system']      = 1;
        $table_data['groups']      = 'config';
        $table_data['update_date']  = date('Y-m-d');
        $table_data['status']       = 1;
        if($check>0){
            $update=$this->db->where('key=','banner_image')->update('system_settings', $table_data);
        }else{
            $update=$this->db->insert('system_settings', $table_data);
        }
        if($update==true){
            echo json_encode(['success'=>true,'msg'=>"Update Sucessfully"]);
        }

        
    }
}
public function add_login_img(){ 
                  $this->common_model->checkAdminUserPermission(11);

    if(isset($_FILES)){
        $file = $_FILES["login_image"]['tmp_name'];
        list($width, $height) = getimagesize($file);

       $av_file         = $_FILES['login_image'];
       $src             = 'uploads/login_image/'.$av_file['name'];
       $imageFileType   = pathinfo($src,PATHINFO_EXTENSION);
       $image_name     = time().'.'.$imageFileType;
       $src2            = 'uploads/login_image/'.$image_name;

       move_uploaded_file($av_file['tmp_name'], $src2);

       $check=$this->db->where('key=','login_image')->from('system_settings')->count_all_results();

       $table_data['key']        = 'login_image';
       $table_data['value']      =  $src2; 
       $table_data['system']      = 1;
       $table_data['groups']      = 'config';
       $table_data['update_date']  = date('Y-m-d');
       $table_data['status']       = 1;
       if($check>0){
        $update=$this->db->where('key=','login_image')->update('system_settings', $table_data);
    }else{
        $update=$this->db->insert('system_settings', $table_data);
    }
    if($update==true){
        $img_urls=base_url().$src2;
        $message= "CMS updated successfully";
        $this->session->set_flashdata('success_message',$message);
        redirect(base_url()."admin/cms");
    }
  }
}


public function add_feature_img(){ 
                  $this->common_model->checkAdminUserPermission(11);

    if(isset($_FILES)){
        $file = $_FILES["availabe_feature_image"]['tmp_name'];
        list($width, $height) = getimagesize($file);

        if($width < "421" || $height < "376") {
           echo json_encode(['success'=>false,'msg'=>"Please upload above 421x376 image size"]);exit;
       }

       $av_file         = $_FILES['availabe_feature_image'];
       $src             = 'uploads/availabe_feature_image/'.$av_file['name'];
       $imageFileType   = pathinfo($src,PATHINFO_EXTENSION);
       $image_name     = time().'.'.$imageFileType;
       $src2            = 'uploads/availabe_feature_image/'.$image_name;

       move_uploaded_file($av_file['tmp_name'], $src2);


       $check=$this->db->where('key=','availabe_feature_image')->from('system_settings')->count_all_results();

       $table_data['key']        = 'availabe_feature_image';
       $table_data['value']      = $src2;
       $table_data['system']      = 1;
       $table_data['groups']      = 'config';
       $table_data['update_date']  = date('Y-m-d');
       $table_data['status']       = 1;
       if($check>0){
        $update=$this->db->where('key=','availabe_feature_image')->update('system_settings', $table_data);
    }else{
        $update=$this->db->insert('system_settings', $table_data);
    }
    if($update==true){
        $img_urls=base_url().$src2;
        echo json_encode(['success'=>true,'msg'=>"Update Sucessfully",'img'=>$img_urls]);
    }


}
}

public function image_resize($width=0,$height=0,$image_url,$filename)
{          
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
        $temp_height = $height;
        $temp_width = ( int ) ($height * $source_aspect_ratio);
    } else {
        $temp_width = $width;
        $temp_height = ( int ) ($width / $source_aspect_ratio);
    }
    $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
    imagecopyresampled(
        $temp_gdim,
        $source_gdim,
        0, 0,
        0, 0,
        $temp_width, $temp_height,
        $source_width, $source_height
    );
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
    $filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    $image_url =  "uploads/login_image/".$filename_without_extension."_".$width."_".$height.".jpg";    
    imagejpeg($desired_gdim,$image_url);

    return $image_url;
}

 public function add_app_link() 
 {
  
    $this->common_model->checkAdminUserPermission(11);
    $table_data1['update_date']  = date('Y-m-d');
    $table_data1['value']       = $this->input->post("android_app_link");
    $table_data1['groups']      = 'config';
    $table_data1['key']        = 'android_app_link';

    $table_data2['update_date']  = date('Y-m-d');    
    $table_data2['value']       = $this->input->post("ios_app_link");
    $table_data2['groups']      = 'config';
    $table_data2['key']        = 'ios_app_link';


    $check=$this->db->where('key=','android_app_link')->from('system_settings')->count_all_results();
    $check_ios_link = $this->db->where('key=','ios_app_link')->from('system_settings')->count_all_results();

    if($check>0)
    {
      $update=$this->db->where('key=','android_app_link')->update('system_settings', $table_data1);
    }
    else
    {
      $update=$this->db->insert('system_settings', $table_data1);
    }
    if($check_ios_link > 0) {
      $update=$this->db->where('key=','ios_app_link')->update('system_settings', $table_data2);
    }
    else
    {
      $update=$this->db->insert('system_settings', $table_data2);
    }
    $message= "CMS updated successfully";
    $this->session->set_flashdata('success_message',$message);
    redirect(base_url()."admin/cms"); 
 }

}