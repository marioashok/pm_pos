<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Editshippingorders extends MY_Controller
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

        $this->load->model("editshippingorders_model");
    }


    public function edit($purchased_id = null)

    {

        if (!$this->Admin) {

            $this->session->set_flashdata('error', $this->lang->line('access_denied'));

            redirect('pos');

        }

        if ($this->input->get('purchased_id')) {

            $purchased_id = $this->input->get('purchased_id', true);

        }


        $this->form_validation->set_rules('fullname', $this->lang->line('fullname'), 'required');
        $this->form_validation->set_rules('address1', $this->lang->line('address1'), 'required');
        $this->form_validation->set_rules('city', $this->lang->line('city'), 'required');
        $this->form_validation->set_rules('state', $this->lang->line('state'), 'required');
        $this->form_validation->set_rules('country', $this->lang->line('country'), 'required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'required');





        if ($this->form_validation->run() == true) {

            $data = [
                'fullname' => $this->input->post('fullname'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'address3' => $this->input->post('address3'),
                'city' => $this->input->post('city'),
                'state'  => $this->input->post('state'),
                'zipcode'  => $this->input->post('zipcode'),
                'country'  => $this->input->post('country'),
                'phone'  => $this->input->post('phone'),

            ];
            

        }



        if ($this->form_validation->run() == true && $this->editshippingorders_model->updateEditshippingorder($purchased_id, $data)) {


            $this->session->set_flashdata('message', $this->lang->line('editshippingorders_updated'));

            redirect('editshippingorders');

        } else {

            $this->data['editshippingorder']   = $this->editshippingorders_model->getEditshippingorderByID($purchased_id);

            $this->data['error']      = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $this->data['page_title'] = lang('edit_editshippingorders');

            $bc                       = [['link' => site_url('editshippingorders'), 'page' => lang('editshippingorders')], ['link' => '#', 'page' => lang('edit_editshippingorder')]];

            $meta                     = ['page_title' => lang('edit_editshippingorders'), 'bc' => $bc];

            $this->page_construct('editshippingorders/edit', $this->data, $meta);

        }

    }

   

    public function delete($purchased_id = null)

    {

        
        if ($this->input->get('purchased_id')) {

            $purchased_id = $this->input->get('purchased_id', true);

        }

         if (!$this->Admin) {

            $this->session->set_flashdata('error', lang('access_denied'));

            redirect('pos');

        }



        if ($this->editshippingorders_model->deleteEditshippingorder($purchased_id)) {


            $this->session->set_flashdata('message', lang('DELETED'));

            redirect('editshippingorders');

        }

    } 


    public function get_editshippingorders()
    {
        $this->load->library("datatables");
        $this->datatables->select("purchased_id,order_no,useremail,order_status"); // Select all columns
        $this->datatables->from("purchased_product_details"); // Set your table name
        $this->datatables->where("order_status", '1'); // Add the condition for order_status
        $this->datatables->where("(trackid = '' OR trackid IS NULL)"); // Add the condition for trackid
        $this->datatables->add_column(
                "Actions",
                '
                <div class="text-center">
                    <div class="btn-group">
                        <a href="' .
                        site_url('editshippingorders/edit/$1') .
                        '" class="tip btn btn-warning btn-xs" title="' .
                        $this->lang->line("edit_editshippingorders") .
                        '"><i class="fa fa-edit"></i></a>
                        <a href="' .
                        site_url('editshippingorders/delete/$1') .
                        '" onClick="return confirm(\'' .
                        $this->lang->line("DELETE?") .
                        '\')" class="tip btn btn-danger btn-xs" title="' .
                        $this->lang->line("DEL") .
                        '"><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>',
                "purchased_id,order_no,useremail,order_status"
);
$this->datatables->unset_column("purchased_id");
echo $this->datatables->generate();
}

public function index()
{
    $this->data["error"] = validation_errors()
        ? validation_errors()
        : $this->session->flashdata("error");

    $this->data[
        "editshippingorders"
    ] = $this->editshippingorders_model->getAllEditshippingorders();

    $this->data["page_title"] = $this->lang->line("editshippingorders");

    $bc = [
        ["link" => "#", "page" => lang("editshippingorders")],
        ["link" => "#", "page" => lang("list_editshippingorders")],
    ];

    $meta = ["page_title" => lang("editshippingorders"), "bc" => $bc];

    $this->page_construct("editshippingorders/index", $this->data, $meta);
}
}