<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subcategories extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('subcategories_model');
    }

    public function add()
    {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }

        $this->form_validation->set_rules('name', lang('category_name'), 'required');

        if ($this->form_validation->run() == true) {
            $data = ['discount' => $this->input->post('discount'), 
            'name' => $this->input->post('name'),
            'category_id' => $this->input->post('category_id'),
            'code' => $this->input->post('code'),
            'type_indicator' => $this->input->post('type_indicator'),
            'featured_product_id' => $this->input->post('featured_product_id')
        ];
 

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');

                $config['upload_path']   = 'uploads/subcategories/';
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
                    redirect('subcategories/add');
                }

                $photo         = $this->upload->file_name;
                $data['image'] = $photo;

                $this->load->library('image_lib');
                $config['image_library']  = 'gd2';
                $config['source_image']   = 'uploads/subcategories/' . $photo;
                $config['new_image']      = 'uploads/subcategories/thumbs/' . $photo;
                $config['maintain_ratio'] = true;
                $config['width']          = 50;
                $config['height']         = 50;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    $this->upload->set_flashdata('error', $this->image_lib->display_errors());
                    redirect('subcategories/add');
                }

                $ext = pathinfo($photo, PATHINFO_EXTENSION);
                $string = $this->input->post('name');
                $newString = str_replace(' ', '_', $string);
                $get_last_id = $this->subcategories_model->retrieveLastID()+1;
                $newFileName = $get_last_id . "_" . $newString . "." . $ext;
                $data['image'] = $newFileName;
                rename("uploads/subcategories/" . $photo, "uploads/subcategories/" . $newFileName);
                rename("uploads/subcategories/thumbs/" . $photo, "uploads/subcategories/thumbs/" . $newFileName);
                  
            }
        }

        if ($this->form_validation->run() == true && $this->subcategories_model->addSubCategory($data)) {
            $this->session->set_flashdata('message', lang('category_added'));
            redirect('subcategories');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('add_category');
            $this->data['categories'] = $this->site->getAllCategories();
            $bc                       = [['link' => site_url('subcategories'), 'page' => lang('subcategories')], ['link' => '#', 'page' => lang('add_subcategory')]];
            $meta                     = ['page_title' => lang('add_category'), 'bc' => $bc];
            $this->page_construct('subcategories/add', $this->data, $meta);
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

        if ($this->subcategories_model->deleteSubcategory($id)) {
            $this->session->set_flashdata('message', lang('category_deleted'));
            redirect('subcategories');
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
            $data = ['discount' => $this->input->post('discount'), 
            'name' => $this->input->post('name'),
            'category_id' => $this->input->post('category_id'),
            'code' => $this->input->post('code'),
            'type_indicator' => $this->input->post('type_indicator'),
            'featured_product_id' => $this->input->post('featured_product_id')
        ];

 

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');

                $config['upload_path']   = 'uploads/subcategories/';
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
                    redirect('subcategories/add');
                }

                $photo         = $this->upload->file_name;
                $data['image'] = $photo;

                $this->load->library('image_lib');
                $config['image_library']  = 'gd2';
                $config['source_image']   = 'uploads/subcategories/' . $photo;
                $config['new_image']      = 'uploads/subcategories/thumbs/' . $photo;
                $config['maintain_ratio'] = true;
                $config['width']          = 50;
                $config['height']         = 50;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    $this->upload->set_flashdata('error', $this->image_lib->display_errors());
                    redirect('subcategories/edit');
                }
                $ext = pathinfo($photo, PATHINFO_EXTENSION);
                $string = $this->input->post('name');
                $newString = str_replace(' ', '_', $string);
                $get_last_id = $id;
                $newFileName = $get_last_id . "_" . $newString . "." . $ext;
                $data['image'] = $newFileName;
                rename("uploads/subcategories/" . $photo, "uploads/subcategories/" . $newFileName);
                rename("uploads/subcategories/thumbs/" . $photo, "uploads/subcategories/thumbs/" . $newFileName);
            }else{
                   // No new image uploaded, update other fields
    
                // Get the existing image filename from the database
                $existingFileName = $this->subcategories_model->retrieveImageNameById($id);
    
                if ($existingFileName) {
                    $ext = pathinfo($existingFileName, PATHINFO_EXTENSION);
                    $string = $this->input->post('name');
                    $newString = str_replace(' ', '_', $string);
                    $get_last_id = $id;
                    $newFileName = $get_last_id . "_" . $newString . "." . $ext;
                    $data['image'] = $newFileName;
    
                    // Rename the image file in storage location
                    rename("uploads/subcategories/" . $existingFileName, "uploads/subcategories/" . $newFileName);
                    rename("uploads/subcategories/thumbs/" . $existingFileName, "uploads/subcategories/thumbs/" . $newFileName);
    
                    // Update the image filename in the database
                    $this->subcategories_model->updateImage($id, $newFileName);
                }
            }
        }

        if ($this->form_validation->run() == true && $this->subcategories_model->updateSubcategory($id, $data)) {
            $this->session->set_flashdata('message', lang('category_updated'));
            redirect('subcategories?category_id=' . $this->input->post('category_id'));
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['subcategory']  = $this->subcategories_model->getSubcategoryByID($id);
            $this->data['page_title']  = lang('new_category');
            $this->data['categories']  = $this->site->getAllCategories();
            $bc                       = [['link' => site_url('subcategories'), 'page' => lang('subcategories')], ['link' => '#', 'page' => lang('edit_category')]];
            $meta                     = ['page_title' => lang('edit_category'), 'bc' => $bc];
            $this->page_construct('subcategories/edit', $this->data, $meta);
        }
    }

    public function get_subcategories()
    {
    
        $this->load->library('datatables');
        $this->datatables->select('subcategories.id, subcategories.category_id, subcategories.image, subcategories.discount, subcategories.name, subcategories.code, subcategories.type_indicator, subcategories.featured_product_id,categories.name as cname');
        $this->datatables->from('subcategories');
        $this->datatables->join('categories', 'subcategories.category_id = categories.id');        
        $this->datatables->add_column('Actions', "<div class='text-center'>
        <div class='btn-group'>
        <a href='" . site_url('subcategories/edit/$1') . "' title='" . lang('edit_category') . "' class='tip btn btn-warning btn-xs'><i class='fa fa-edit'></i></a> <a href='" . site_url('subcategories/delete/$1') . "' onClick=\"return confirm('" . lang('alert_x_category') . "')\" title='" . lang('delete_category') . "' class='tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></div></div>", 'id, image, discount, name');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }

  

    public function index()
    {
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['page_title'] = lang('');
        $bc                       = [['link' => '#', 'page' => lang('')]];
        $meta                     = ['page_title' => lang(''), 'bc' => $bc];
        $this->page_construct('subcategories/index', $this->data, $meta);
    }
}
