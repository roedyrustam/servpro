<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ratingstype extends CI_Controller {

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
      $this->common_model->checkAdminUserPermission(5);
		redirect(base_url('ratingstype'));
	}
	public function ratingstype()
	{
        $this->common_model->checkAdminUserPermission(5);

    if($this->session->userdata('admin_id'))
		{
  		$this->data['page'] = 'ratingstype';
  		$this->data['model'] = 'ratingstype';
  		$this->data['list'] = $this->service->ratingstype_list();
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}else {
			redirect(base_url()."admin");
		}
	}

	public function add_ratingstype()
	{

          $this->common_model->checkAdminUserPermission(5);

    if($this->session->userdata('admin_id'))
		{

      if ($this->input->post('form_submit')) {  
          
            $table_data['name'] = $this->input->post('name');
            $table_data['status'] = 1;                
            if($this->db->insert('ratings_type', $table_data))
            {
                 $this->session->set_flashdata('success_message','Ratings type added successfully');    
                 redirect(base_url()."ratingstype");   
            }
            else
            {
                $this->session->set_flashdata('error_message','Something wrong, Please try again');
                redirect(base_url()."ratingstype");   

             } 
               
         
    }


  		$this->data['page'] = 'add_ratingstype';
  		$this->data['model'] = 'ratingstype';
  		$this->load->vars($this->data);
  		$this->load->view('template');
		}
		else {
			redirect(base_url()."admin");
		}
            

	}


  public function edit_ratingstype($id)
  {
          $this->common_model->checkAdminUserPermission(5);

    if($this->session->userdata('admin_id'))
    {


      if ($this->input->post('form_submit')) {  

            $id=$this->input->post('id');
            $table_data['name'] = $this->input->post('name');
            $table_data['status'] = 1;
            $this->db->where('id',$id);                
            if($this->db->update('ratings_type', $table_data))
            {
                 $this->session->set_flashdata('success_message','Ratings type updated successfully');    
                 redirect(base_url()."ratingstype");   
            }
            else
            {
                $this->session->set_flashdata('error_message','Something wrong, Please try again');
                redirect(base_url()."ratingstype");   

             } 
               
         
    }


      $this->data['page'] = 'edit_ratingstype';
      $this->data['model'] = 'ratingstype';
      $this->data['ratingstype'] = $this->service->ratingstype_details($id);
      $this->load->vars($this->data);
      $this->load->view('template');
    }
    else {
      redirect(base_url()."admin");
    }

  }

  
  public function check_ratingstype_name()
  {
    $name = $this->input->post('name');
    $id = $this->input->post('id');
    if(!empty($id))
    {
      $this->db->select('*');
      $this->db->where('name', $name);
      $this->db->where('id !=', $id);
      $this->db->from('ratings_type');
      $result = $this->db->get()->num_rows();
    }
    else
    {
      $this->db->select('*');
      $this->db->where('name', $name);
      $this->db->from('ratings_type');
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


  public function delete_ratingstype()
  {
          $this->common_model->checkAdminUserPermission(5);

    $id=$this->input->post('id');
    $this->db->where('id',$id);
    if($this->db->delete('ratings_type'))
   {
           $this->session->set_flashdata('success_message','Ratings type deleted successfully');    
           redirect(base_url()."ratingstype");   
    }
    else
    {
        $this->session->set_flashdata('error_message','Something wrong, Please try again');
        redirect(base_url()."ratingstype");   

     } 
  }  
}
