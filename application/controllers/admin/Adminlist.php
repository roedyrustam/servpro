<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminlist extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
        $this->load->model('Admin_panel_model','admin_panel');
        $this->load->model('common_model','common_model');
        $this->load->library('Encryption','encryption');
        $this->data['view'] = 'admin';
        $this->data['base_url'] = base_url();
        $this->session->keep_flashdata('error_message');
        $this->session->keep_flashdata('success_message');
        $this->load->helper('user_timezone_helper');

    }

	public function index()
	{
    $this->common_model->checkAdminUserPermission(2);

		redirect(base_url('adminlist'));
	}
	public function adminlist()
	{
    $this->common_model->checkAdminUserPermission(2);

    if($this->session->userdata('admin_id'))
		{
  		$this->data['page'] = 'adminlist';
  		$this->data['model'] = 'adminlist';
  		$this->data['list'] = $this->admin_panel->all_admin_list();
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}
	}

	public function add_adminlist()
	{
    $this->common_model->checkAdminUserPermission(2);

    if($this->session->userdata('admin_id'))
		{         $accesscheck = $this->input->post('accesscheck');


      if ($this->input->post('form_submit')) {

            $uploaded_file_name = '';
            if (isset($_FILES) && isset($_FILES['profile_image']['name']) && !empty($_FILES['profile_image']['name'])) {
                $uploaded_file_name = $_FILES['profile_image']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/profile_image/', 'profile_image', time().$filename);
                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];
                    if (!empty($uploaded_file_name)) {
                       $image_url='uploads/profile_image/'.$uploaded_file_name;
                       $table_data['profile_thumb'] = $this->image_resize(50,50,$image_url,$filename);
                       $table_data['profile_picture'] = 'uploads/profile_image/'.$uploaded_file_name;
                }
            }
            }

            $pswd=base64_encode($this->input->post('password'));
            $table_data['name'] = $this->input->post('firstname');
            $table_data['email'] = $this->input->post('email_id');
            $table_data['username'] = $this->input->post('username');
            $table_data['password'] = $pswd;
            if($this->db->insert('administrators', $table_data))
            {
                 $this->session->set_flashdata('success_message','administrators added successfully');
                  $insert_id = $this->db->insert_id();
                 $username            = $this->input->post('username');
                 $module_result = $this->db->select('*')->get('module_list')->result_array();
                foreach ($module_result as $module){
                  $adminparams['admin_user_id'] = $insert_id;
                  $adminparams['module_id'] = $module['module_id'];
                  $access_result = $this->db->where('admin_user_id',$insert_id)->where('module_id',$module['module_id'])->select('access_id')->get('module_access')->result_array();
                  if (!empty($data_days) && in_array($module['module_id'], $accesscheck)){
                      $adminparams['access_status'] = 1;
                  }else{
                      $adminparams['access_status'] = 0;
                  }
                  if(!empty($access_result)){
                      $result=$this->db->where('access_id',$access_result[0]['access_id'])->update('module_access',$adminparams);
                  }else{
                      $result=$this->db->insert('module_access',$adminparams);
                  }

                }
                 redirect(base_url()."adminlist");
            }
            else
            {
                $this->session->set_flashdata('error_message','Something wrong, Please try again');
                redirect(base_url()."add-adminlist");

             }


    }


  		$this->data['page'] = 'add_adminlist';
  		$this->data['model'] = 'adminlist';
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."adminlist");
		}


	}


  public function edit_adminlist($id)
  {
    $this->common_model->checkAdminUserPermission(2);

    if($this->session->userdata('admin_id'))
    {
               $accesscheck = $this->input->post('accesscheck');



      if ($this->input->post('form_submit')) {


            $uploaded_file_name = '';
            if (isset($_FILES) && isset($_FILES['profile_image']['name']) && !empty($_FILES['profile_image']['name'])) {
                $uploaded_file_name = $_FILES['profile_image']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/profile_image/', 'profile_image', time().$filename);
                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];
                    if (!empty($uploaded_file_name)) {
                       $image_url='uploads/profile_image/'.$uploaded_file_name;
                       $table_data['profile_thumb'] = $this->image_resize(550,400,$image_url,$filename);
                       $table_data['profile_picture'] = 'uploads/profile_image/'.$uploaded_file_name;
                }
            }
            }
            $id=$this->input->post('admin_id');
           $table_data['name'] = $this->input->post('firstname');
            $table_data['email'] = $this->input->post('email_id');
            $table_data['username'] = $this->input->post('username');
            $this->db->where('ADMINID',$id);
            if($this->db->update('administrators', $table_data))
            {
                 $this->session->set_flashdata('success_message','Adminlist updated successfully');
                  $username            = $this->input->post('username');
                 $module_result = $this->db->select('*')->get('module_list')->result_array();
                foreach ($module_result as $module){
                $adminparams['admin_user_id'] = $id;
                $adminparams['module_id'] = $module['module_id'];
                $access_result = $this->db->where('admin_user_id',$id)->where('module_id',$module['module_id'])->select('access_id')->get('module_access')->result_array();
            if (in_array($module['module_id'], $accesscheck)){
            $adminparams['access_status'] = 1;
            }else{
            $adminparams['access_status'] = 0;
            }
            if(!empty($access_result)){
            $result=$this->db->where('access_id',$access_result[0]['access_id'])->update('module_access',$adminparams);
            }else{
            $result=$this->db->insert('module_access',$adminparams);
            }

        }
                 redirect(base_url()."adminlist");
            }
            else
            {
                $this->session->set_flashdata('error_message','Something wrong, Please try again');
                redirect(base_url()."adminlist");

             }


    }


      $this->data['page'] = 'edit_adminlist';
      $this->data['model'] = 'adminlist';
      $this->data['adminlist'] = $this->admin_panel->edit_adminlist_details($id);
      $this->load->vars($this->data);
      $this->load->view('template');
    }
    else {
      redirect(base_url()."adminlist");
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
   $image_url =  "uploads/category_images/".$filename_without_extension."_".$width."_".$height.".jpg";
imagejpeg($desired_gdim,$image_url);

return $image_url;

/*
 * Add clean-up code here
 */
}



  public function delete_adminlist()
  {
    $this->common_model->checkAdminUserPermission(2);

    $id=$this->input->post('admin_id');
    $this->db->where('ADMINID',$id);
    if($this->db->delete('administrators'))
   {
           $this->session->set_flashdata('success_message','Adminlist deleted successfully');
           redirect(base_url()."adminlist");
    }
    else
    {
        $this->session->set_flashdata('error_message','Something wrong, Please try again');
        redirect(base_url()."adminlist");

     }
  }





}
