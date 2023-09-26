<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Coupons extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            redirect("login");
        }

        if (!$this->Admin) {
            $this->session->set_flashdata("error", lang("access_denied"));

            redirect("pos");
        }

        $this->load->library("form_validation");

        $this->load->model("coupons_model");
    }

      public function add()
    {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
           $this->form_validation->set_rules('coupon_code', $this->lang->line('COUPON CODE'), 'required');

        if ($this->form_validation->run() == true) {
            $data = [
                'coupon_email' => $this->input->post('coupon_email'),
                'coupon_code' => $this->input->post('coupon_code'),
                'coupon_quantity' => $this->input->post('coupon_quantity'),
                'coupon_discount' => $this->input->post('coupon_discount'),
                'coupon_range_from' => $this->input->post('coupon_range_from'),
                'coupon_range_to' => $this->input->post('coupon_range_to'),
                'coupon_free_shipping' => $this->input->post('coupon_free_shipping'),
                'coupon_discount_amt' => $this->input->post('coupon_discount_amt'),
                'coupon_start_date' => date('Y-m-d', strtotime($this->input->post('coupon_start_date'))),
                'coupon_expiry_date' => date('Y-m-d', strtotime($this->input->post('coupon_expiry_date')))
            ];
        }

        if ($this->form_validation->run() == true && $this->coupons_model->addCoupon($data)) {
            $this->session->set_flashdata('message', lang('Coupons Added'));
            redirect('coupons');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('ADD COUPON');
            $bc                       = [['link' => site_url('add_coupon'), 'page' => lang('')], ['link' => '#', 'page' => lang('')]];
            $meta                     = ['page_title' => lang(''), 'bc' => $bc];
            $this->page_construct('coupons/add', $this->data, $meta);
        }
    }


     public function edit($coupon_id= null)

    {

        if (!$this->Admin) {

            $this->session->set_flashdata('error', $this->lang->line('access_denied'));

            redirect('pos');

        }

        if ($this->input->get('coupon_id')) {

            $coupon_id = $this->input->get('coupon_id', true);

        }
        $this->form_validation->set_rules('coupon_code', $this->lang->line('COUPON CODE'), 'required');

        if ($this->form_validation->run() == true) {
            $data = [
                'coupon_email' => $this->input->post('coupon_email'),
                'coupon_code' => $this->input->post('coupon_code'),
                'coupon_quantity' => $this->input->post('coupon_quantity'),
                'coupon_discount' => $this->input->post('coupon_discount'),
                'coupon_range_from' => $this->input->post('coupon_range_from'),
                'coupon_range_to' => $this->input->post('coupon_range_to'),
                'coupon_free_shipping' => $this->input->post('coupon_free_shipping'),
                'coupon_discount_amt' => $this->input->post('coupon_discount_amt'),
                'coupon_start_date' => date('Y-m-d', strtotime($this->input->post('coupon_start_date'))),
                'coupon_expiry_date' => date('Y-m-d', strtotime($this->input->post('coupon_expiry_date')))
            ];
        }


        if ($this->form_validation->run() == true && $this->coupons_model->updateCoupon($coupon_id, $data)) {

            $this->session->set_flashdata('message', $this->lang->line('COUPONS UPDATED'));

            redirect('coupons');

        } else {

            $this->data['coupon']   = $this->coupons_model->getCouponByID($coupon_id);

            $this->data['error']      = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $this->data['page_title'] = lang('COUPON');

            $bc                       = [['link' => site_url('coupons'), 'page' => lang('')], ['link' => '#', 'page' => lang('')]];

            $meta                     = ['page_title' => lang(''), 'bc' => $bc];

            $this->page_construct('coupons/edit', $this->data, $meta);

        }

    }

     public function delete($coupon_id = null)

    {
        if ($this->input->get('coupon_id')) {
            $coupon_id = $this->input->get('coupon_id', true);
        }
         if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        if ($this->coupons_model->deleteCoupon($coupon_id)) {
            $this->session->set_flashdata('message', lang('DELETED'));
            redirect('coupons');
        }

    }

    public function show($coupon_id=null)
    {
        if ($this->input->get('coupon_id')) {
            $coupon_id = $this->input->get('coupon_id', true);
        }
         if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
         if ($this->coupons_model->ShowCoupon($coupon_id)) {
            $this->session->set_flashdata('message', lang('SET'));
            redirect('coupons');
        }

    }

     public function unshow($coupon_id=null)
    {
        if ($this->input->get('coupon_id')) {
            $coupon_id = $this->input->get('coupon_id', true);
        }
         if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
         if ($this->coupons_model->UnshowCoupon($coupon_id)) {
            $this->session->set_flashdata('message', lang('UNSET'));
            redirect('coupons');
        }

    }

        public function approve($coupon_id=null)
    {
        if ($this->input->get('coupon_id')) {
            $coupon_id = $this->input->get('coupon_id', true);
        }
         if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
         if ($this->coupons_model->ApproveCoupon($coupon_id)) {
            $this->session->set_flashdata('message', lang('APPROVED'));
            redirect('coupons');
        }

    }



        public function disapprove($coupon_id=null)
    {
        if ($this->input->get('coupon_id')) {
            $coupon_id = $this->input->get('coupon_id', true);
        }
         if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
         if ($this->coupons_model->DisapproveCoupon($coupon_id)) {
            $this->session->set_flashdata('message', lang('REJECTED'));
            redirect('coupons');
        }

    }




      public function get_coupons()

    {

        $this->load->library('datatables');

        $this->datatables->select('coupon_id,coupon_email,coupon_code,coupon_quantity,coupon_range_from,coupon_range_to,coupon_discount,coupon_discount_amt,coupon_free_shipping,coupon_start_date,coupon_expiry_date,coupon_status,approval');

        $this->datatables->from('pm_coupons');

              $this->datatables->add_column('Approvals',
            "<div class='text-center'><div class='btn-group'>
            <a href='" . site_url('coupons/approve/$1') . "' class='tip btn btn-success btn-xs' title='" . $this->lang->line('APPROVE') . "'><i class='fa fa-check'></i></a> 
            <a href='" . site_url('coupons/disapprove/$1') . "' class='tip btn btn-danger btn-xs' title='" . $this->lang->line('DISAPPROVE') . "'><i class='fa fa-times'></i></a> 
            </div></div>", 'coupon_id');



         $this->datatables->add_column('Tasks',
            "<div class='text-center'><div class='btn-group'>
            <a href='" . site_url('coupons/show/$1') . "' class='tip btn btn-info btn-xs' title='" . $this->lang->line('SHOW') . "'><i class='fa fa-eye'></i></a> 
            <a href='" . site_url('coupons/unshow/$1') . "' class='tip btn btn-primary btn-xs' title='" . $this->lang->line('UNSHOW') . "'><i class='fa fa-eye-slash'></i></a> 
            </div></div>", 'coupon_id');



        $this->datatables->add_column('Actions',
            "<div class='text-center'><div class='btn-group'>
            <a href='" . site_url('coupons/edit/$1') . "' class='tip btn btn-warning btn-xs' title='" . $this->lang->line('EDIT') . "'><i class='fa fa-edit'></i></a> 
            <a href='" . site_url('coupons/delete/$1') . "' onClick=\"return confirm('" . $this->lang->line('DELETE') . "')\" class='tip btn btn-danger btn-xs' title='" . $this->lang->line('DELETE?') . "'><i class='fa fa-trash-o'></i></a>
            </div></div>", 'coupon_id');

        $this->datatables->unset_column('coupon_id');

        echo $this->datatables->generate();

    }



    public function index()
    {
        $this->data["error"] = validation_errors()
            ? validation_errors()
            : $this->session->flashdata("error");

        $this->data['coupon']     = $this->coupons_model->getAllCoupons();

        $this->data["page_title"] = $this->lang->line("COUPONS");

        $bc = [
            ["link" => "#", "page" => lang("COUPONS")],
            ["link" => "#", "page" => lang("LIST COUPONS")],
        ];

        $meta = ["page_title" => lang("COUPONS"), "bc" => $bc];

        $this->page_construct("coupons/index", $this->data, $meta);
    }
}
