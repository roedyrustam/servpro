<?php 

class Currency extends CI_Controller{

  public function __construct() {

    parent::__construct();
    error_reporting(0);

    $this->data['view'] = 'admin';

    $this->data['model'] = 'currency';
    $this->load->model('common_model','common_model');

    $this->load->helper('currency');
    $this->load->model('admin_panel_model');  
    $this->data['base_url'] = base_url();
    $this->load->helper('user_timezone');
    $this->data['admin_id'] = $this->session->userdata('id');
    $this->user_role = !empty($this->session->userdata('user_role'))?$this->session->userdata('user_role'):0;

    $this->data['gig_price'] = $this->admin_panel_model->gig_price();
    $this->load->helper('favourites');

  }

  public function index ($start=0)

  {	 
                $this->common_model->checkAdminUserPermission(13);

    $this->load->library('pagination');

    $config['base_url'] =  base_url("admin/currency/");

    $config['total_rows'] = $this->db->count_all('currency');

    $config['uri_segment'] = 3 ;

    $config['per_page'] = 10;



    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';



    $config['first_link'] = 'First';

    $config['first_tag_open'] = '<li>';

    $config['first_tag_close'] = '</li>';



    $config['prev_link'] = '&laquo;';

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';



    $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';



    $config['next_link'] = '&raquo;';

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</li>';



    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '<li>';

    $config['last_tag_close'] = '</li>';



    $this->pagination->initialize($config);

    $this->data['page'] = 'index';
    $this->data['model'] = 'currency';

    $this->data['links'] = $this->pagination->create_links();

    $start = (int)$this->uri->segment(3);

    $this->data['list'] = $this->admin_panel_model->all_currency(1,$start,$config['total_rows']);     


    
    $this->load->vars($this->data);
    $this->load->view('template');

  }

  public function add_currency()

  {
                    $this->common_model->checkAdminUserPermission(13);


    $this->data['page'] = 'add_currency';


    if($this->input->post('form_submit'))

    {

      $data['currency_name'] = $this->input->post('country_name');

      $data['currency_code'] = $this->input->post('currency_code');
      $data['currency_sign'] = $this->input->post('currency_sign');
      $data['status'] =$this->input->post('status'); //1;
      $data['created_date'] = date('Y-m-d H:i:s');

      if($this->db->insert('currency',$data))

      {
        $message="<div class='alert alert-success text-center in' id='flash_succ_message'>Currency Added Successfully.</div>";
        $this->session->set_flashdata('message', $message);
        redirect(base_url().'admin/currency');

      }

    }

    $this->load->vars($this->data);

    $this->load->view( $this->data['theme'].'/template');

  }

  public function edit_currency($id)

  {                $this->common_model->checkAdminUserPermission(13);


    $this->data['page'] = 'edit_currency';

    $this->data['list'] = $this->admin_panel_model->edit_currency($id);

    if($this->input->post('form_submit'))

    {

     $data['currency_name'] = $this->input->post('country_name');

     $data['currency_code'] = $this->input->post('currency_code');
     $data['currency_sign'] = $this->input->post('currency_sign');
     $data['status'] = $this->input->post('status'); //1;
     $data['created_date'] = date('Y-m-d H:i:s');

     $this->db->where('id',$id);

     if($this->db->update('currency',$data))

     {
      $message="<div class='alert alert-success text-center in' id='flash_succ_message'>Currency Updated Successfully.</div>";
      $this->session->set_flashdata('message', $message);
      redirect(base_url().'admin/currency');

    }

  }        

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');        

}

public function admin_delete_currency(){
                $this->common_model->checkAdminUserPermission(13);

 if($this->data['admin_id'] > 1){
  $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');    
  redirect(base_url().'admin/currency');

}else{

  if($this->input->post('id')){

    $id = $this->input->post('id');

    $result = 1;

    $this->session->set_flashdata('message',"The Currency remove faild");

    if(!empty($id)){

      $this->db->where('id', $id);

      $count =  $this->db->count_all_results('currency'); 

      if($count>0){

        $this->db->where('id', $id);

        $this->db->delete('currency');
        $message="<div class='alert alert-success text-center in' id='flash_succ_message'>The Currency has been removed...</div>";
        $this->session->set_flashdata('message', $message);

        $result = 1;

      }else{
       $message="<div class='alert alert-danger text-center in' id='flash_succ_message'>The Currency can't remove...</div>";
       $this->session->set_flashdata('message', $message);
       $result = 2;

     }

   }

   echo $result;

   die();

 }
}

}

public function admin_default_currency(){
                $this->common_model->checkAdminUserPermission(13);

 if($this->data['admin_id'] > 1){
  $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');    
  redirect(base_url().'admin/currency');

}else{

  if($this->input->post('id')){

    $id = $this->input->post('id');

    $result = 1;

    $this->session->set_flashdata('message',"The Currency can't able to make as default...");

    if(!empty($id)){

      $this->db->where('id', $id);

      $count =  $this->db->count_all_results('currency'); 

      $getcurrency = $this->db->get_where('currency', array('id' => $id))->row();


      if($count>0){

        $data = array(
                'status' => 1
        );
        $this->db->where('id', $id);
        $this->db->update('currency',$data);

        $data1 = array(
                'status' => 0
        );
        $this->db->where_not_in('id', $id);
        $this->db->update('currency',$data1);

        $data2 = array('value' => $getcurrency->currency_code);
        $this->db->where('key', 'default_currency');
        $this->db->update('system_settings',$data2);

        $message="<div class='alert alert-success text-center in' id='flash_succ_message'>The Currency has been marked as Default Currency...</div>";
        $this->session->set_flashdata('message', $message);

        $result = 1;

      }else{
       $message="<div class='alert alert-danger text-center in' id='flash_succ_message'>The Currency can't able to make as default...</div>";
       $this->session->set_flashdata('message', $message);
       $result = 2;

     }

   }

   echo $result;

   die();

 }
}

}



public function country_check()
{
    $this->common_model->checkAdminUserPermission(13);

  $category_name =  $this->input->post('country_name');   
  $id= $this->input->post('id'); 
  $result = $this->admin_panel_model->country_check($category_name,$id);
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

    public function change_Status() {
        $id=$this->input->post('id');
        $status=$this->input->post('status');

        $this->db->where('id',$id);
        $this->db->update('currency',array('status' =>$status));

        $message="<div class='alert alert-success text-center in' id='flash_succ_message'>Currency Status Updated Successfully.</div>";
      $this->session->set_flashdata('message', $message);
      redirect(base_url().'admin/currency');
    }
}

?>