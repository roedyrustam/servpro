<?php
class Razorpayment_gateway extends CI_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->data['theme']  = 'admin';
        $this->data['module'] = 'razorpayment_gateways';
        $this->load->model('admin_panel_model');
        $this->data['admin_id'] = $this->session->userdata('id');
        $this->user_role        = !empty($this->session->userdata('user_role')) ? $this->session->userdata('user_role') : 0;
        $this->load->helper('common_helper');
    }
    public function index($offset = 0)
    {
        $this->load->library('pagination');
        $config['base_url']        = site_url("admin/razorpayment_gateway/");
        $config['per_page']        = 15;
        $config['total_rows']      = $this->db->count_all_results('razorpay_gateway');
        $config['full_tag_open']   = '<ul class="pagination">';
        $config['full_tag_close']  = '</ul>';
        $config['first_link']      = 'First';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link']       = '&laquo;';
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="active"><a href="javascript:;">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        $config['next_link']       = '&raquo;';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['last_link']       = 'Last';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $this->data['page']        = 'index';
        $this->data['list']        = $this->admin_panel_model->razor_payment_gateway($offset, $config['per_page']);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function create()
    {
        removeTag($this->input->post());
        if ($this->input->post('form_submit')) {
            if ($this->data['admin_id'] > 1) {
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
                redirect(base_url() . 'admin/payment_gateway');
            } else {
                $data['gateway_name'] = $this->input->post('gateway_name');
                $data['gateway_type'] = $this->input->post('gateway_type');
                $data['api_key']      = $this->input->post('api_key');
				$data['api_secret']   = $this->input->post('api_secret');
                $data['status']       = $this->input->post('status');
                if ($this->db->insert('razorpay_gateway', $data)) {
                    $message = '<div class="alert alert-success text-center in" id="flash_succ_message">Payment Gateway create successfully.</div>';
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/razorpayment_gateway');
            }
        }
        $this->data['page'] = 'create';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function edit($id)
    {
        removeTag($this->input->post());
        if ($this->input->post('form_submit')) {
            if ($this->data['admin_id'] > 1) {
                $this->session->set_flashdata('message', '<p class="alert alert-danger">Permission Denied</p>');
                redirect(base_url() . 'admin/razorpayment_gateway');
            } else {
                $data['gateway_name'] = $this->input->post('gateway_name');
                $data['gateway_type'] = $this->input->post('gateway_type');
                $data['api_key']      = $this->input->post('api_key');
                $data['api_secret']   = $this->input->post('api_secret');
                $data['status']       = $this->input->post('status');
                $this->db->where('id', $id);
                if ($this->db->update('razorpay_gateway', $data)) {
                    if ($this->input->post('gateway_type') == 'sandbox') {
                        $datass['razorpay_apikey'] = $this->input->post('api_key');
						$datass['razorpay_apisecret'] = $this->input->post('api_secret');
                    } else {
                        $datass['razorpaylive_apikey'] = $this->input->post('api_key');
						$datass['razorpaylive_apisecret'] = $this->input->post('api_secret');
                    }
                    foreach ($datass as $key => $val) {
                        $this->db->where('key', $key);
                        $this->db->delete('system_settings');
                        $table_data['key']         = $key;
                        $table_data['value']       = $val;
                        $table_data['system']      = 1;
                        $table_data['groups']      = 'config';
                        $table_data['update_date'] = date('Y-m-d');
                        $table_data['status']      = 1;
                        $this->db->insert('system_settings', $table_data);
                    }
                    $message = '<div class="alert alert-success text-center in" id="flash_succ_message">Razor Payment gateway details updated successfully.</div>';
                }
                $this->session->set_flashdata('message', $message);
                redirect(base_url() . 'admin/razorpayment_gateway');
            }
        }
        $this->data['list'] = $this->admin_panel_model->edit_razorpayment_gateway($id);
        $this->data['page'] = 'edit';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }
    public function delete()
    {
        $id = $this->input->post('tbl_id');
        $this->db->where('id', $id);
        if ($this->db->delete('razorpay_gateway')) {
            $message = '<div class="alert alert-success text-center in" id="flash_succ_message">Payment Gateway deleted successfully.</div>';
            echo 1;
        }
        $this->session->set_flashdata('message', $message);
    }
}