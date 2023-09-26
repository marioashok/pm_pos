<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Homepageslider extends MY_Controller

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

        $this->load->model('homepageslider_model');
    }



    public function add()
    {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'required');
        $this->form_validation->set_rules('display_order', $this->lang->line('display_order'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'title' => $this->input->post('title'),
                'url' => $this->input->post('url'),
                'description' => $this->input->post('description'),
                'display_order' => $this->input->post('display_order')
            ];

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');

                $config['upload_path']   = 'uploads/home-slider/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = '500';
                $config['max_width']     = '800';
                $config['max_height']    = '800';
                $config['overwrite']     = false;
                $config['encrypt_name']  = true;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->upload->set_flashdata('error', $error);
                    redirect('homepageslider/add');
                }

                $photo         = $this->upload->file_name;
                $data['image'] = $photo;

                $this->load->library('image_lib');
                $config['image_library']  = 'gd2';
                $config['source_image']   = 'uploads/home-slider/' . $photo;
                $config['new_image']      = 'uploads/home-slider/thumbs/' . $photo;
                $config['maintain_ratio'] = true;
                $config['width']          = 50;
                $config['height']         = 50;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    $this->upload->set_flashdata('error', $this->image_lib->display_errors());
                    redirect('homepageslider/add');
                }
            }
        }

        $ext = pathinfo($photo, PATHINFO_EXTENSION);
        $string = $this->input->post('title');
        $newString = str_replace(' ', '_', $string);
        $get_last_id = $this->homepageslider_model->retrieveLastID() + 1;
        $newFileName = $get_last_id . "_" . $newString . "." . $ext;
        $data['image'] = $newFileName;

        if ($this->form_validation->run() == true && $this->homepageslider_model->addHomepageslider($data)) {
            $this->session->set_flashdata('message', lang('homepageslider_added'));
            rename("uploads/home-slider/" . $photo, "uploads/home-slider/" . $newFileName);
            rename("uploads/home-slider/thumbs/" . $photo, "uploads/home-slider/thumbs/" . $newFileName);
            redirect('homepageslider');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('add_homepageslider');
            $bc                       = [['link' => site_url('add_homepageslider'), 'page' => lang('add_homepageslider')], ['link' => '#', 'page' => lang('add_homepageslider')]];
            $meta                     = ['page_title' => lang('add_homepageslider'), 'bc' => $bc];
            $this->page_construct('homepageslider/add', $this->data, $meta);
        }
    }

    public function edit($id = null)
    {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', $this->lang->line('access_denied'));
            redirect('pos');
        }
    
        if ($this->input->get('id')) {
            $id = $this->input->get('id', true);
        }
    
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'required');
        $this->form_validation->set_rules('display_order', $this->lang->line('display_order'), 'required');
    
        // Initialize the $photo variable
        $photo = '';
    
        if ($this->form_validation->run() == true) {
            $data = [
                'title' => $this->input->post('title'),
                'url' => $this->input->post('url'),
                'description' => $this->input->post('description'),
                'display_order' => $this->input->post('display_order')
            ];
    
            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
    
                $config['upload_path']   = 'uploads/home-slider/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = '500';
                $config['max_width']     = '700';
                $config['max_height']    = '300';
                $config['overwrite']     = false;
                $config['encrypt_name']  = true;
                $this->upload->initialize($config);
    
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('homepageslider/edit/' . $id);
                }
    
                $photo = $this->upload->file_name;
                $data['image'] = $photo;
    
                $this->load->library('image_lib');
                $config['image_library']  = 'gd2';
                $config['source_image']   = 'uploads/home-slider/' . $photo;
                $config['new_image']      = 'uploads/home-slider/thumbs/' . $photo;
                $config['maintain_ratio'] = true;
                $config['width']          = 700;
                $config['height']         = 300;
    
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
    
                if (!$this->image_lib->resize()) {
                    $this->session->set_flashdata('error', $this->image_lib->display_errors());
                    redirect('homepageslider/edit/' . $id);
                }
                $ext = pathinfo($photo, PATHINFO_EXTENSION);
                $string = $this->input->post('title');
                $newString = '';
                for ($i = 0; $i < strlen($string); $i++) {
                    $char = $string[$i];
                    
                    if ($char === '(' || $char === ')' || $char === ' ') {
                        // Replace parentheses and spaces with underscores
                        $newString .= '_';
                    } else {
                        // Keep other characters as they are
                        $newString .= $char;
                    }
                    
                    // Check for consecutive underscores and replace them with a single underscore
                    if (substr($newString, -2) === '__') {
                        $newString = substr($newString, 0, -1);
                    }
                }
                $newFileName = $newString . "_" . $id . "." . $ext;
                $data['image'] = $newFileName;

                rename("uploads/home-slider/" . $photo, "uploads/home-slider/" . $newFileName);
                rename("uploads/home-slider/thumbs/" . $photo, "uploads/home-slider/thumbs/" . $newFileName);

                
            } else {
                // No new image uploaded, update other fields
    
                // Get the existing image filename from the database
                $existingFileName = $this->homepageslider_model->retrieveImageNameById($id);
    
                if ($existingFileName) {
                    $ext = pathinfo($existingFileName, PATHINFO_EXTENSION);
                    $string = $this->input->post('title');
                    $newString = '';
                    for ($i = 0; $i < strlen($string); $i++) {
                        $char = $string[$i];
                        
                        if ($char === '(' || $char === ')' || $char === ' ') {
                            // Replace parentheses and spaces with underscores
                            $newString .= '_';
                        } else {
                            // Keep other characters as they are
                            $newString .= $char;
                        }
                        
                        // Check for consecutive underscores and replace them with a single underscore
                        if (substr($newString, -2) === '__') {
                            $newString = substr($newString, 0, -1);
                        }
                    }
                    $newFileName = $newString . "_" . $id . "." . $ext;
                    $data['image'] = $newFileName;
    
                    // Rename the image file in storage location
                    rename("uploads/home-slider/" . $existingFileName, "uploads/home-slider/" . $newFileName);
                    rename("uploads/home-slider/thumbs/" . $existingFileName, "uploads/home-slider/thumbs/" . $newFileName);
    
                    // Update the image filename in the database
                    $this->homepageslider_model->updateImage($id, $newFileName);
                }
            }
        }
    
        if ($this->form_validation->run() == true && $this->homepageslider_model->updateHomepageslider($id, $data)) {
            $this->session->set_flashdata('message', $this->lang->line('homepageslider_updated'));
            redirect('homepageslider');
        } else {
            $this->data['homepageslider'] = $this->homepageslider_model->getHomepagesliderByID($id);
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->data['page_title'] = lang('HOME PAGE SLIDER');
            $bc = [['link' => site_url('homepageslider'), 'page' => lang('')], ['link' => '#', 'page' => lang('')]];
            $meta = ['page_title' => lang(''), 'bc' => $bc];
            $this->page_construct('homepageslider/edit', $this->data, $meta);
        }
    }
    
    public function delete($id = null)

    {


        if ($this->input->get('id')) {

            $id = $this->input->get('id', true);
        }

        if (!$this->Admin) {

            $this->session->set_flashdata('error', lang('access_denied'));

            redirect('pos');
        }



        if ($this->homepageslider_model->deleteHomepageslider($id)) {


            $this->session->set_flashdata('message', lang('DELETED'));

            redirect('homepageslider');
        }
    }

    public function get_homepageslider()

    {

        $this->load->library('datatables');

        $this->datatables->select('id, title,url,description,type,image,display_order,');

        $this->datatables->from('pm_all_images');

        $this->datatables->add_column('Actions', "<div class='text-center'><div class='btn-group'><a href='" . site_url('homepageslider/edit/$1') . "' class='tip btn btn-warning btn-xs' title='" . $this->lang->line('edit_pcolor') . "'><i class='fa fa-edit'></i></a> <a href='" . site_url('homepageslider/delete/$1') . "' onClick=\"return confirm('" . $this->lang->line('alert_x_pcolor') . "')\" class='tip btn btn-danger btn-xs' title='" . $this->lang->line('delete_pcolor') . "'><i class='fa fa-trash-o'></i></a></div></div>", 'id');

        $this->datatables->unset_column('id');

        echo $this->datatables->generate();
    }



    public function index()

    {

        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['homepagesliders']     = $this->homepageslider_model->getAllHomepagesliders();


        $this->data['page_title'] = $this->lang->line('HOME PAGE SLIDER');

        $bc                       = [['link' => '#', 'page' => lang('HOME PAGE SLIDER')], ['link' => '#', 'page' => lang('LIST HOMEPAGESLIDER')]];

        $meta                     = ['page_title' => lang('HOME PAGE SLIDER'), 'bc' => $bc];

        $this->page_construct('homepageslider/index', $this->data, $meta);
    }
}
