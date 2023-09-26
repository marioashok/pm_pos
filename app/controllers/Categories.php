<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('categories_model');
    }

    public function add()
    {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }

        $this->form_validation->set_rules('name', lang('category_name'), 'required');

        if ($this->form_validation->run() == true) {
            $data = ['discount' => $this->input->post('discount'), 'name' => $this->input->post('name')];

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');

                $config['upload_path']   = 'uploads/categories/';
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
                    redirect('categories/add');
                }

                $photo         = $this->upload->file_name;
                $data['image'] = $photo;

                $this->load->library('image_lib');
                $config['image_library']  = 'gd2';
                $config['source_image']   = 'uploads/categories/' . $photo;
                $config['new_image']      = 'uploads/categories/thumbs/' . $photo;
                $config['maintain_ratio'] = true;
                $config['width']          = 50;
                $config['height']         = 50;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    $this->upload->set_flashdata('error', $this->image_lib->display_errors());
                    redirect('categories/add');
                }

                $ext = pathinfo($photo, PATHINFO_EXTENSION);
                $string = $this->input->post('name');
                $newString = str_replace(' ', '_', $string);
                $get_last_id = $this->categories_model->retrieveLastID();
                $newFileName = $get_last_id . "_" . $newString . "." . $ext;
                $data['image'] = $newFileName;
                rename("uploads/categories/" . $photo, "uploads/categories/" . $newFileName);
                rename("uploads/categories/thumbs/" . $photo, "uploads/categories/thumbs/" . $newFileName);
                  
            }
        }

        if ($this->form_validation->run() == true && $this->categories_model->addCategory($data)) {
            $this->session->set_flashdata('message', lang('category_added'));
            redirect('categories');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('add_category');
            $bc                       = [['link' => site_url('categories'), 'page' => lang('categories')], ['link' => '#', 'page' => lang('add_category')]];
            $meta                     = ['page_title' => lang('add_category'), 'bc' => $bc];
            $this->page_construct('categories/add', $this->data, $meta);
        }
    }

    public function delete($id = null)
    {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect($_SERVER['HTTP_REFERER'] ?? 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->categories_model->deleteCategory($id)) {
            $this->session->set_flashdata('message', lang('category_deleted'));
            redirect('categories');
        }
    }

    public function edit($id = null)
    {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $this->form_validation->set_rules('name', lang('category_name'), 'required');

        if ($this->form_validation->run() == true) {
            $data = ['discount' => $this->input->post('discount'), 'name' => $this->input->post('name')];

 

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');

                $config['upload_path']   = 'uploads/categories/';
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
                    redirect('categories/add');
                }

                $photo         = $this->upload->file_name;
                $data['image'] = $photo;

                $this->load->library('image_lib');
                $config['image_library']  = 'gd2';
                $config['source_image']   = 'uploads/categories/' . $photo;
                $config['new_image']      = 'uploads/categories/thumbs/' . $photo;
                $config['maintain_ratio'] = true;
                $config['width']          = 50;
                $config['height']         = 50;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    $this->upload->set_flashdata('error', $this->image_lib->display_errors());
                    redirect('categories/edit');
                }
                $ext = pathinfo($photo, PATHINFO_EXTENSION);
                $string = $this->input->post('name');
                $newString = str_replace(' ', '_', $string);
                $get_last_id = $id;
                $newFileName = $get_last_id . "_" . $newString . "." . $ext;
                $data['image'] = $newFileName;
                rename("uploads/categories/" . $photo, "uploads/categories/" . $newFileName);
                rename("uploads/categories/thumbs/" . $photo, "uploads/categories/thumbs/" . $newFileName);
            }else{
                   // No new image uploaded, update other fields
    
                // Get the existing image filename from the database
                $existingFileName = $this->categories_model->retrieveImageNameById($id);
    
                if ($existingFileName) {
                    $ext = pathinfo($existingFileName, PATHINFO_EXTENSION);
                    $string = $this->input->post('name');
                    $newString = str_replace(' ', '_', $string);
                    $get_last_id = $id;
                    $newFileName = $get_last_id . "_" . $newString . "." . $ext;
                    $data['image'] = $newFileName;
    
                    // Rename the image file in storage location
                    rename("uploads/categories/" . $existingFileName, "uploads/categories/" . $newFileName);
                    rename("uploads/categories/thumbs/" . $existingFileName, "uploads/categories/thumbs/" . $newFileName);
    
                    // Update the image filename in the database
                    $this->categories_model->updateImage($id, $newFileName);
                }
            }
        }

        if ($this->form_validation->run() == true && $this->categories_model->updateCategory($id, $data)) {
            $this->session->set_flashdata('message', lang('category_updated'));
            redirect('categories');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['category']   = $this->categories_model->getCategoryByID($id);
            $this->data['page_title'] = lang('new_category');
            $bc                       = [['link' => site_url('categories'), 'page' => lang('categories')], ['link' => '#', 'page' => lang('edit_category')]];
            $meta                     = ['page_title' => lang('edit_category'), 'bc' => $bc];
            $this->page_construct('categories/edit', $this->data, $meta);
        }
    }

    public function get_categories()
    {
        $this->load->library('datatables');
        $this->datatables->select('id, image, discount, name,');
        $this->datatables->from('categories');
        $this->datatables->add_column('Actions', "<div class='text-center'>
        <div class='btn-group'>
        <a href='" . site_url('categories/edit/$1') . "' title='" . lang('edit_category') . "' class='tip btn btn-warning btn-xs'><i class='fa fa-edit'></i></a> <a href='" . site_url('categories/delete/$1') . "' onClick=\"return confirm('" . lang('alert_x_category') . "')\" title='" . lang('delete_category') . "' class='tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></div></div>", 'id, image, discount, name');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }

  

    public function index()
    {
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['categories'] = $this->categories_model->getAllCategories();
        $this->data['page_title'] = lang('categories');
        $bc                       = [['link' => '#', 'page' => lang('categories')]];
        $meta                     = ['page_title' => lang('categories'), 'bc' => $bc];
        $this->page_construct('categories/index', $this->data, $meta);
    }
}
