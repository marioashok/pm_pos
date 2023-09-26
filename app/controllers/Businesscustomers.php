<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Businesscustomers extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('businesscustomers_model');
    }

    public function add()
    {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }

        $this->form_validation->set_rules('email', lang('email'), 'required');

        if ($this->form_validation->run() == true) {
            $data = ['firstname' => $this->input->post('firstname'),'email' => $this->input->post('email'),'country' => $this->input->post('country'),'state' => $this->input->post('state'),'zipcode' => $this->input->post('zipcode')];
        }

        if ($this->form_validation->run() == true && $this->businesscustomers_model->addBusinessCustomer($data)) {
            $this->session->set_flashdata('message', lang('businesscustomers_added'));
            redirect('businesscustomers');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('add_businesscustomer');
            $bc                       = [['link' => site_url('businesscustomers'), 'page' => lang('businesscustomers')], ['link' => '#', 'page' => lang('add_businesscustomer')]];
            $meta                     = ['page_title' => lang('add_businesscustomer'), 'bc' => $bc];
            $this->page_construct('businesscustomers/add', $this->data, $meta);
        }
    }

    public function delete($user_id = null)
    {
        
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        if ($this->input->get('user_id')) {
            $user_id = $this->input->get('user_id');
        }

        if ($this->businesscustomers_model->deleteBusinessCustomer($user_id)) {
            $this->session->set_flashdata('message', lang('category_deleted'));
            redirect('businesscustomers');
        }
    }

    public function edit($user_id = null)
    {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        if ($this->input->get('user_id')) {
            $user_id = $this->input->get('user_id');
        }

        $this->form_validation->set_rules('email', lang('email'), 'required');
        
        if ($this->form_validation->run() == true) {
            $data = ['firstname' => $this->input->post('firstname'),'email' => $this->input->post('email'),'country' => $this->input->post('country'),'state' => $this->input->post('state'),'zipcode' => $this->input->post('zipcode')];
        }

        if ($this->form_validation->run() == true && $this->businesscustomers_model->updateBusinessCustomer($user_id, $data)) {
            $this->session->set_flashdata('message', lang('businesscustomers_updated'));
            redirect('businesscustomers');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['businesscustomer'] = $this->businesscustomers_model->getBusinessCustomerByID($user_id);
            $this->data['page_title'] = lang('new_businesscustomer');
            $bc                       = [['link' => site_url('businesscustomer'), 'page' => lang('businesscustomers')], ['link' => '#', 'page' => lang('edit_businesscustomer')]];
            $meta                     = ['page_title' => lang('edit_businesscustomer'), 'bc' => $bc];
            $this->page_construct('businesscustomers/edit', $this->data, $meta);
        }
    }

    public function get_businesscustomers()
    {
        $this->load->library('datatables');
        $this->datatables->select
        ($this->db->dbprefix('register') . '.user_id as user_id,'
            .$this->db->dbprefix('register').'.firstname as firstname,'
            .$this->db->dbprefix('register').'.lastname as lastname,'
            .$this->db->dbprefix('register').'.email as email,'
            .$this->db->dbprefix('register').'.country as country,'
            .$this->db->dbprefix('register').'.state as state,'
            .$this->db->dbprefix('register').'.city as city,'
            .$this->db->dbprefix('register').'.usertype as usertype,'
            .$this->db->dbprefix('register').'.zipcode as zipcode'
            ,false);
        
        $this->datatables->from('register')
        ->where('usertype','business');
        $this->datatables->add_column('Actions', "<div class='text-center'><a href='" . site_url('businesscustomers/edit/$1') . "' title='" . lang('edit_businesscustomer') . "' class='tip btn btn-success btn-xs'><i class='fa fa-edit'></i></a> <a href='" . site_url('businesscustomers/delete/$1') . "' onClick=\"return confirm('" . lang('alert_x_businesscustomer') . "')\" title='" . lang('delete_businesscustomer') . "' class='tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></div></div>", 'user_id, firstname, email,country,state,zipcode');
        $this->datatables->unset_column('user_id');
        echo $this->datatables->generate();
    }

    public function index()
    {
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['businesscustomers'] = $this->businesscustomers_model->getAllBusinessCustomers();
        $this->data['page_title'] = lang('businesscustomers');
        $bc                       = [['link' => '#', 'page' => lang('businesscustomers')]];
        $meta                     = ['page_title' => lang(''), 'bc' => $bc];
        $this->page_construct('businesscustomers/index', $this->data, $meta);
    }
}
