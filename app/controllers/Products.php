<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Products extends MY_Controller

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

        $this->load->model('products_model');

    }

   
    public function index()

    {    
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['page_title'] = $this->lang->line('PRODUCTS');

        $bc                       = [['link' => '#', 'page' => lang('PRODUCTS')], ['link' => '#', 'page' => lang('PRODUCTS')]];

        $meta                     = ['page_title' => lang('PRODUCTS'), 'bc' => $bc];

        $this->page_construct('products/index', $this->data, $meta);

    }






    



    

}

