<?php
class Footer_submenu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme']  = 'admin';
        $this->data['model'] = 'footer_submenu';
         $this->load->model('admin_panel_model', 'admin');
        $this->data['base_url'] = base_url();
        $this->data['admin_id']  = $this->session->userdata('id');
        $this->user_role         = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;
        $this->data['main_menu'] = $this->admin->get_all_footer_menu();
        $this->load->helper('ckeditor');
        $this->load->model('common_model','common_model');
        // Array with the settings for this instance of CKEditor (you can have more than one)
        $this->data['ckeditor_editor1'] = array
        (
            //id of the textarea being replaced by CKEditor
            'id'   => 'ck_editor_textarea_id',
            // CKEditor path from the folder on the root folder of CodeIgniter
            'path' => 'assets/js/ckeditor',
            // optional settings
            'config' => array
            (
                'toolbar' => "Full",
                'filebrowserBrowseUrl'      => base_url().'assets/js/ckfinder/ckfinder.html',
                'filebrowserImageBrowseUrl' => base_url().'assets/js/ckfinder/ckfinder.html?Type=Images',
                'filebrowserFlashBrowseUrl' => base_url().'assets/js/ckfinder/ckfinder.html?Type=Flash',
                'filebrowserUploadUrl'      => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                'filebrowserImageUploadUrl' => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                'filebrowserFlashUploadUrl' => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            )
        );  
    }
    public function index($offset = 0)
    {
        $this->data['page']  = 'index';
        $this->data['lists'] = $this->admin_model->get_footer_submenu();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
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
    public function create()
    {
        $this->data['page'] = 'create';
        if ($this->input->post('form_submit')) {
            if ($this->data['admin_id'] > 1) {
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
                redirect(base_url() . 'admin/footer_submenu');
            } else {
                $data['footer_menu']    = $this->input->post('main_menu');
                $value                  = $this->input->post('sub_menu');
                $data['footer_submenu'] = str_replace(' ', '_', $value);
                $data['page_desc']      = $this->input->post('page_desc');
                $data['status']         = $this->input->post('status');
                $data['menu_status']    = $this->input->post('menu_status');
                if ($this->db->insert('footer_submenu', $data)) {
                    $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>footer menu created successfully.</div>";
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/footer_submenu');
            }
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function edit($id)
    {
        $this->data['page']     = 'edit';
        $this->data['datalist'] = $this->admin_model->edit_submenu($id);
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/footer_submenu');
        } else {
            if ($this->input->post('form_submit')) {
                $data['footer_menu']    = $this->input->post('main_menu');
                $value                  = $this->input->post('sub_menu');
                $data['footer_submenu'] = str_replace(' ', '_', $value);
                $data['page_desc']      = $this->input->post('page_desc');
                $data['status']         = $this->input->post('status');
                $data['menu_status']    = $this->input->post('menu_status');
                $this->db->where('id', $id);
                if ($this->db->update('footer_submenu', $data)) {
                    $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>footer menu edited successfully.</div>";
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/footer_submenu');
            }
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function delete_footer_submenu()
    {
        if ($this->data['admin_id'] > 1) {
            $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
            redirect(base_url() . 'admin/footer_submenu');
        } else {
            $id = $this->input->post('tbl_id');
            if (!empty($id)) {
                $this->db->delete('footer_submenu', array(
                    'id' => $id
                ));
                $message = "<div class='alert alert-success text-center fade in' id='flash_succ_message'>footer menu deleted successfully.</div>";
                echo 1;
            }
            $this->session->set_flashdata('message', $message);
        }
    }
    public function category_widget() {
            if($this->input->post("form_submit") == true) {
            $categories = $this->db->get_where('footer_submenu', array('id'=> 1))->row();
            $post_data = $this->input->post();
            $table_data = array(
                'widget_showhide' => ($post_data['categories_showhide'])?'1':'0',
                'page_title' => $post_data['category_title'],
                'widget_name' => 'Categories-Widget',
                'category_view' => $post_data['category_view'],
                'category_count' => $post_data['category_count'],
            );
            if(empty($categories)) {
                $this->db->insert('footer_submenu', $table_data);
            } else {  
                $where = array('id' => 1);
                $this->admin->update_data('footer_submenu', $table_data, $where);
            }
                $this->session->set_flashdata('success_message', 'Categories Widget updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
            }
         }

    public function contact_widget() {
            if($this->input->post("form_submit") == true) {
            $contact_id = $this->db->get_where('footer_submenu', array('id'=> 3))->row();
            $post_data = $this->input->post();
            $table_data = array(
                'widget_showhide' => ($post_data['contact_showhide'])?'1':'0',
                'page_title' => $post_data['contact_title'],
                'widget_name' => 'contact-widget',
                'address' => $post_data['address'],
                'phone' => $post_data['phone'],
                'email' => $post_data['email']
            );
            if(empty($contact_id)) {
                $this->db->insert('footer_submenu', $table_data);
            } else {  
                $where = array('widget_name' => 'contact-widget');
                $this->admin->update_data('footer_submenu', $table_data, $where);
            }
             if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success_message', 'Contact Widget updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
                } else {
                $this->session->set_flashdata('error_message', 'Something went wront, Try again');
                redirect($_SERVER["HTTP_REFERER"]);
            }
         }
    }

     public function link_widget() {
            if($this->input->post("form_submit") == true) {

            $link_id = $this->db->get_where('footer_submenu', array('id'=> 2))->row();
            $post_data = $this->input->post();
            
            $label = $post_data['label'];
            $links = $post_data['link'];
            $i = 1;
            foreach($label as $key => $value) {
                $label = $value;
                $link = $links[$key];
                if(!empty($label) && !empty($link)) {
                    $link_data[] = array(
                        'id' => $i, 
                        'label'     =>  $label,  
                        'link'  => $link
                    );
                }
                $i++; 
            }
            $link_details = json_encode($link_data);
            $table_data = array(
                'widget_showhide' => ($post_data['link_showhide'])?'1':'0',
                'page_title' => $post_data['link_title'],
                'widget_name' => 'Link-Widget',
                'link' => $link_details,
            );
            if(empty($link_id)) {
                $this->db->insert('footer_submenu', $table_data);
            } else {  
                $where = array('id' => 2);
                $this->admin->update_data('footer_submenu', $table_data, $where);
            }
                $this->session->set_flashdata('success_message', 'Link Widget updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
         }
    }

     public function social_widget() {
            if($this->input->post("form_submit") == true) {
            $contact_id = $this->db->get_where('footer_submenu', array('widget_name'=> 'social-widget'))->row();
            $post_data = $this->input->post();
            $data1['facebook']  = $this->input->post('facebook');
            $data1['twitter']  = $this->input->post('twitter');
            $data1['youtube']  = $this->input->post('youtube');
            $data1['linkedin']  = $this->input->post('linkedin');
            $data1['github']  = $this->input->post('github');
            $data1['instagram']  = $this->input->post('instagram');
            $data1['gplus']  = $this->input->post('gplus');
            $data= json_encode($data1);
            $table_data = array(
                'widget_showhide' => ($post_data['social_showhide'])?'1':'0',
                'page_title' => $post_data['socail_title'],
                'widget_name' => 'social-widget',
                'followus_link' => $data
            );
            if(empty($contact_id)) {
                $this->db->insert('footer_submenu', $table_data);
            } else {  
                $where = array('widget_name' => 'social-widget');
                $this->admin->update_data('footer_submenu', $table_data, $where);
            }
                $this->session->set_flashdata('success_message', 'Social Widget updated successfully');
                redirect($_SERVER["HTTP_REFERER"]);
               
         }
    }

     public function copyright_widget() {
         
            if($this->input->post("form_submit") == true) {
            $contact_id = $this->db->get_where('footer_submenu', array('id'=> 5))->row();
            $post_data = $this->input->post();
            $label = $post_data['label1'];
            $link = $post_data['link1'];
            $i = 1;
            foreach($label as $key => $value) {
                $name = $value;
                $url = $link[$key];
                if(!empty($name) && !empty($url)) {
                    $menu_data[] = array(
                        'id' => $i, 
                        'name' =>  $name,  
                        'url'  => $url
                    );
                }
                $i++; 
            }
            $menu_details = json_encode($menu_data);
             $uploaded_file_name = '';
            if (isset($_FILES) && isset($_FILES['footer_logo']['name']) && !empty($_FILES['footer_logo']['name'])) {
                $uploaded_file_name = $_FILES['footer_logo']['name'];
                $uploaded_file_name_arr = explode('.', $uploaded_file_name);
                $filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
                $this->load->library('common');
                $upload_sts = $this->common->global_file_upload('uploads/profile_image/', 'footer_logo', time().$filename);
                if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
                    $uploaded_file_name = $upload_sts['data']['file_name'];
                    if (!empty($uploaded_file_name)) {
                       $image_url='uploads/profile_image/'.$uploaded_file_name;
                       $table_data['profile_thumb'] = $this->image_resize(50,50,$image_url,$filename);
                       $table_data['profile_picture'] = 'uploads/profile_image/'.$uploaded_file_name;
                }
            }
            }
            $table_data = array(
                'widget_showhide' => ($post_data['copyright_showhide'])?'1':'0',
                'page_desc' => $post_data['copyright_title'],
                'widget_name' => 'copyright-widget',
                'link' => $menu_details
            );
            if(empty($contact_id)) {
                $this->db->insert('footer_submenu', $table_data);
            } else {  
                $where = array('widget_name' => 'copyright-widget');
                $this->admin->update_data('footer_submenu', $table_data, $where);
            }
            $this->session->set_flashdata('success_message', 'Copyright Widget updated successfully');
            redirect($_SERVER["HTTP_REFERER"]);
         }
    }
}
