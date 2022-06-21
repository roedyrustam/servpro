<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Paytabs_settings extends CI_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme']  = 'admin';
        $this->data['module'] = 'paytabs_settings';
        $this->load->model('admin_panel_model');
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role        = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;
        $this->load->helper('common_helper');
    }
    public function index()
    {
        removeTag($this->input->post());
        $id = 1;
        if ($this->input->post('form_submit')) {
            if ($this->data['admin_id'] > 1) {
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
                redirect(base_url() . 'admin/paytabs_settings');
            } else {
                $data['sandbox_email']     = $this->input->post('sandbox_email');
                $data['sandbox_secretkey'] = $this->input->post('sandbox_secretkey');
                $data['email']             = $this->input->post('email');
                $data['secretkey']         = $this->input->post('secretkey');
                $query                     = $this->db->query("SELECT * FROM paytabs_details");
                $result                    = $query->row_array();
                if (!empty($result)) {
                    $this->db->where('id', $id);
                    $this->db->update('paytabs_details', $data);
                } else {
                    $this->db->insert('paytabs_details', $data);
                }
                $message = '<div class="alert alert-success text-center in" id="flash_succ_message">Paytabs content successfully edited.</div>';
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/paytabs_settings/');
            }
        }
        $this->data['list'] = $this->admin_panel_model->edit_paytabs_settings($id);
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
}