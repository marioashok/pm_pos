<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Reports extends MY_Controller

{

    public function __construct()

    {

        parent::__construct();



        if (!$this->loggedIn) {

            redirect('login');

        }

        if (!$this->Admin) {

            $this->session->set_flashdata('error', lang('access_denied'));

            redirect('pos');

        }



        $this->load->library('form_validation');

        $this->load->model('reports_model');

    }



    public function index()

    {

        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['report']     = $this->reports_model->getAllReports();

        $this->data['page_title'] = $this->lang->line('VISITOR REPORTS');

        $bc                       = [['link' => '#', 'page' => lang('REPORTS')], ['link' => '#', 'page' => lang('VISITOR REPORTS')]];

        $meta                     = ['page_title' => lang('VISITOR REPORTS'), 'bc' => $bc];

        $this->page_construct("reports/index", $this->data, $meta);

    }

     public function reports_io()
    {
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['report']     = $this->reports_model->getAllReports();

        $this->data['page_title'] = $this->lang->line('Orders - In / Out Report');

        $bc                       = [['link' => '#', 'page' => lang('Orders - In / Out Report')], ['link' => '#', 'page' => lang('Orders - In / Out Report')]];

        $meta                     = ['page_title' => lang('Orders - In / Out Report'), 'bc' => $bc];
        $this->page_construct("reports/reports_io", $this->data, $meta);
    }

    public function product_sales()
    {
         $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['report']     = $this->reports_model->getAllReports();

        $this->data['page_title'] = $this->lang->line(' ');

        $bc                       = [['link' => '#', 'page' => lang(' ')], ['link' => '#', 'page' => lang(' ')]];

        $meta                     = ['page_title' => lang(''), 'bc' => $bc];
        $this->page_construct("reports/product_sales", $this->data, $meta);
    }













}

