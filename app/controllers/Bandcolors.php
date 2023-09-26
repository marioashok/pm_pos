<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Bandcolors extends MY_Controller

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

        $this->load->model('bandcolors_model');

    }

    public function add()
    {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        $this->form_validation->set_rules('color_band_name', $this->lang->line('COLOR NAME'), 'required');
        $this->form_validation->set_rules('color_band_code', $this->lang->line('COLOR CODE'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'color_band_name' => $this->input->post('color_band_name'),
                'color_band_code' => $this->input->post('color_band_code'),
                'color_band_type' => $this->input->post('color_band_type')
            ];
        }

        if ($this->form_validation->run() == true && $this->bandcolors_model->addBandColor($data)) {
            $this->session->set_flashdata('message', lang('Band Colors Added'));
            redirect('bandcolors');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('ADD BAND COLOR');
            $bc                       = [['link' => site_url('add_bandcolor'), 'page' => lang('')], ['link' => '#', 'page' => lang('')]];
            $meta                     = ['page_title' => lang(''), 'bc' => $bc];
            $this->page_construct('bandcolors/add', $this->data, $meta);
        }
    }



    public function edit($color_band_id = null)

    {

        if (!$this->Admin) {

            $this->session->set_flashdata('error', $this->lang->line('access_denied'));

            redirect('pos');

        }

        if ($this->input->get('color_band_id')) {

            $color_band_id = $this->input->get('color_band_id', true);

        }
        $this->form_validation->set_rules('color_band_name', $this->lang->line('COLOR NAME'), 'required');
        $this->form_validation->set_rules('color_band_code', $this->lang->line('COLOR CODE'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'color_band_name' => $this->input->post('color_band_name'),
                'color_band_code' => $this->input->post('color_band_code')
            ];
        }


        if ($this->form_validation->run() == true && $this->bandcolors_model->updateBandColor($color_band_id, $data)) {

            $this->session->set_flashdata('message', $this->lang->line('BAND COLORS UPDATED'));

            redirect('bandcolors');

        } else {

            $this->data['bandcolor']   = $this->bandcolors_model->getBandColorByID($color_band_id);

            $this->data['error']      = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $this->data['page_title'] = lang('BAND COLOR');

            $bc                       = [['link' => site_url('bandcolors'), 'page' => lang('')], ['link' => '#', 'page' => lang('')]];

            $meta                     = ['page_title' => lang(''), 'bc' => $bc];

            $this->page_construct('bandcolors/edit', $this->data, $meta);

        }

    }

    
    public function delete($color_band_id = null)

    {
        if ($this->input->get('color_band_id')) {
            $color_band_id = $this->input->get('color_band_id', true);
        }
         if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        if ($this->bandcolors_model->deleteBandColor($color_band_id)) {
            $this->session->set_flashdata('message', lang('DELETED'));
            redirect('bandcolors');
        }

    } 



    public function get_bandcolors()

    {

        $this->load->library('datatables');

        $this->datatables->select('color_band_id, color_band_name,color_band_code,color_band_type,');

        $this->datatables->from('pm_catholic_color_banding');

        $this->datatables->where("color_band_type", '2');

        $this->datatables->add_column('Actions', "<div class='text-center'><div class='btn-group'><a href='" . site_url('bandcolors/edit/$1') . "' class='tip btn btn-warning btn-xs' title='" . $this->lang->line('edit_pcolor') . "'><i class='fa fa-edit'></i></a> <a href='" . site_url('bandcolors/delete/$1') . "' onClick=\"return confirm('" . $this->lang->line('alert_x_pcolor') . "')\" class='tip btn btn-danger btn-xs' title='" . $this->lang->line('delete_pcolor') . "'><i class='fa fa-trash-o'></i></a></div></div>", 'color_band_id', 
        'color_band_name','color_band_code','color_band_type',);  

        $this->datatables->unset_column('color_band_id');

        echo $this->datatables->generate();

    }



    public function index()

    {

        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        // $this->data['bandcolor']     = $this->bandcolors_model->getAllBandcolors();

        $this->data['page_title'] = $this->lang->line('BAND COLORS');

        $bc                       = [['link' => '#', 'page' => lang('BAND COLORS')], ['link' => '#', 'page' => lang('LIST BAND COLORS')]];

        $meta                     = ['page_title' => lang('BAND COLORS'), 'bc' => $bc];

        $this->page_construct('bandcolors/index', $this->data, $meta);

    }






    



    

}

