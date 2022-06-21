<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
        $this->load->model('service_model','service');
        $this->load->model('common_model','common_model');
        $this->data['view'] = 'admin';
        $this->data['base_url'] = base_url();
        $this->session->keep_flashdata('error_message');
        $this->session->keep_flashdata('success_message');
        $this->load->helper('user_timezone_helper');

    }

	public function index()
	{
    $this->common_model->checkAdminUserPermission(3);

		redirect(base_url('categories'));
	}
	public function categories()
	{
        $this->common_model->checkAdminUserPermission(3);
    if($this->session->userdata('admin_id'))
		{
  		$this->data['page'] = 'categories';
  		$this->data['model'] = 'categories';
  		$this->data['list'] = $this->service->categories_list();
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}
	}

	public function add_categories()
	{
      $this->common_model->checkAdminUserPermission(3);

    if($this->session->userdata('admin_id'))
		{

      if ($this->input->post('form_submit')) {  
          
            $uploaded_file_name = '';
            if (isset($_FILES) && isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name'])) {
                $uploaded_file_name = $_FILES['category_image']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/category_images/', 'category_image', time().$filename);    
                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];
                    if (!empty($uploaded_file_name)) {             
                       $image_url='uploads/category_images/'.$uploaded_file_name;  
                       
                       $table_data['category_image'] = $this->image_resize(150,150,$image_url,$filename);
                }
            }
            }
            $table_data['category_name'] = $this->input->post('category_name');
            $table_data['status'] = 1;                
            if($this->db->insert('categories', $table_data))
            {
                 $this->session->set_flashdata('success_message','Category added successfully');    
                 redirect(base_url()."categories");   
            }
            else
            {
                $this->session->set_flashdata('error_message','Something wrong, Please try again');
                redirect(base_url()."categories");   

             } 
               
         
    }


  		$this->data['page'] = 'add_categories';
  		$this->data['model'] = 'categories';
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}
            

	}


  public function edit_categories($id)
  {
        $this->common_model->checkAdminUserPermission(3);

    if($this->session->userdata('admin_id'))
    {


      if ($this->input->post('form_submit')) {  

          
            $uploaded_file_name = '';
            if (isset($_FILES) && isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name'])) {
                $uploaded_file_name = $_FILES['category_image']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/category_images/', 'category_image', time().$filename);    
                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];
                    if (!empty($uploaded_file_name)) {             
                       $image_url='uploads/category_images/'.$uploaded_file_name;    
                       $table_data['category_image'] = $this->image_resize(150,150,$image_url,$filename);
                }
            }
            }
            $id=$this->input->post('category_id');
            $table_data['category_name'] = $this->input->post('category_name');
            $table_data['status'] = 1;
            $this->db->where('id',$id);                
            if($this->db->update('categories', $table_data))
            {
                 $this->session->set_flashdata('success_message','Category updated successfully');    
                 redirect(base_url()."categories");   
            }
            else
            {
                $this->session->set_flashdata('error_message','Something wrong, Please try again');
                redirect(base_url()."categories");   

             } 
               
         
    }


      $this->data['page'] = 'edit_categories';
      $this->data['model'] = 'categories';
      $this->data['categories'] = $this->service->categories_details($id);
      $this->load->vars($this->data);
      $this->load->view('template');
    }
    else {
      redirect(base_url()."admin");
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

  public function check_category_name()
  {

    $category_name = $this->input->post('category_name');
    $id = $this->input->post('category_id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('category_name', $category_name);
      $this->db->where('id !=', $id);
      $this->db->from('categories');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('category_name', $category_name);
      $this->db->from('categories');
      $result = $this->db->get()->num_rows();
    }
    if ($result > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
     ));
  }


  public function delete_category()
  {
        $this->common_model->checkAdminUserPermission(3);

    $id=$this->input->post('category_id');
    $this->db->where('id',$id);
    if($this->db->delete('categories'))
   {
           $this->session->set_flashdata('success_message','Category deleted successfully');    
           redirect(base_url()."categories");   
    }
    else
    {
        $this->session->set_flashdata('error_message','Something wrong, Please try again');
        redirect(base_url()."categories");   

     } 
  }



  public function subcategories()
  {

    if($this->session->userdata('admin_id'))
    {
      $this->data['page'] = 'subcategories';
      $this->data['model'] = 'subcategories';
      $this->data['list'] = $this->service->subcategories_list();
      $this->load->vars($this->data);
      $this->load->view('template');
    }
    else {
      redirect(base_url()."admin");
    }
  }

  public function add_subcategories()
  {
        $this->common_model->checkAdminUserPermission(4);

    if($this->session->userdata('admin_id'))
    {

      if ($this->input->post('form_submit')) {  

          
            $uploaded_file_name = '';
            if (isset($_FILES) && isset($_FILES['subcategory_image']['name']) && !empty($_FILES['subcategory_image']['name'])) {
                $uploaded_file_name = $_FILES['subcategory_image']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/subcategory_images/', 'subcategory_image', time().$filename);    
                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];
                    if (!empty($uploaded_file_name)) {             
                       $image_url='uploads/subcategory_images/'.$uploaded_file_name;    
                       $table_data['subcategory_image'] = $this->subimage_resize(50,50,$image_url,$filename);
                }
            }
            }
            $table_data['subcategory_name'] = $this->input->post('subcategory_name');
            $table_data['category'] = $this->input->post('category');
            $table_data['status'] = 1;                
            if($this->db->insert('subcategories', $table_data))
            {
                 $this->session->set_flashdata('success_message','SubCategory added successfully');    
                 redirect(base_url()."subcategories");   
            }
            else
            {
                $this->session->set_flashdata('error_message','Something wrong, Please try again');
                redirect(base_url()."subcategories");   

             } 
               
         
    }


      $this->data['page'] = 'add_subcategories';
      $this->data['model'] = 'subcategories';
      $this->data['categories'] = $this->service->categories_list();
      $this->load->vars($this->data);
      $this->load->view('template');
    }
    else {
      redirect(base_url()."admin");
    }
            

  }


  public function edit_subcategories($id)
  {
        $this->common_model->checkAdminUserPermission(4);

    if($this->session->userdata('admin_id'))
    {


      if ($this->input->post('form_submit')) {  

          
            $uploaded_file_name = '';
            if (isset($_FILES) && isset($_FILES['subcategory_image']['name']) && !empty($_FILES['subcategory_image']['name'])) {
                $uploaded_file_name = $_FILES['subcategory_image']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/subcategory_images/', 'subcategory_image', time().$filename);    
                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];
                    if (!empty($uploaded_file_name)) {             
                       $image_url='uploads/subcategory_images/'.$uploaded_file_name;    
                       $table_data['subcategory_image'] = $this->subimage_resize(50,50,$image_url,$filename);
                }
            }
            }
            $id=$this->input->post('subcategory_id');
            $table_data['subcategory_name'] = $this->input->post('subcategory_name');
            $table_data['category'] = $this->input->post('category');
            $table_data['status'] = 1;
            $this->db->where('id',$id);                
            if($this->db->update('subcategories', $table_data))
            {
                 $this->session->set_flashdata('success_message','SubCategory updated successfully');    
                 redirect(base_url()."subcategories");   
            }
            else
            {
                $this->session->set_flashdata('error_message','Something wrong, Please try again');
                redirect(base_url()."subcategories");   

             } 
               
         
    }


      $this->data['page'] = 'edit_subcategories';
      $this->data['model'] = 'subcategories';
      $this->data['subcategories'] = $this->service->subcategories_details($id);
      $this->data['categories'] = $this->service->categories_list();
      $this->load->vars($this->data);
      $this->load->view('template');
    }
    else {
      redirect(base_url()."admin");
    }

  }

  public function subimage_resize($width=0,$height=0,$image_url,$filename){          
        
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
   $image_url =  "uploads/subcategory_images/".$filename_without_extension."_".$width."_".$height.".jpg";    
imagejpeg($desired_gdim,$image_url);

return $image_url;

/*
 * Add clean-up code here
 */
} 

  public function check_subcategory_name()
  {
    $category = $this->input->post('category');
    $subcategory_name = $this->input->post('subcategory_name');
    $id = $this->input->post('subcategory_id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('category', $category);
      $this->db->where('subcategory_name', $subcategory_name);
      $this->db->where('id !=', $id);
      $this->db->from('subcategories');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('category', $category);
      $this->db->where('subcategory_name', $subcategory_name);
      $this->db->from('subcategories');
      $result = $this->db->get()->num_rows();
    }
    if ($result > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
     ));
  }


  public function delete_subcategory()
  {
        $this->common_model->checkAdminUserPermission(4);

    $id=$this->input->post('subcategory_id');
    $this->db->where('id',$id);
    if($this->db->delete('subcategories'))
   {
           $this->session->set_flashdata('success_message','SubCategory deleted successfully');    
           redirect(base_url()."subcategories");   
    }
    else
    {
        $this->session->set_flashdata('error_message','Something wrong, Please try again');
        redirect(base_url()."subcategories");   

     } 
  }

  
}
