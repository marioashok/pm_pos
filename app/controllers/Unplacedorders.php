<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Unplacedorders extends MY_Controller
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

        $this->load->model("unplacedorders_model");
    }

    public function delete($cartId = null)

    {
        if ($this->input->get('cartId')) {
            $cartId = $this->input->get('cartId', true);
        }
         if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }
        if ($this->unplacedorders_model->deleteUnplacedorder($cartId)) {
            $this->session->set_flashdata('message', lang('DELETED'));
            redirect('unplacedorders');
        }

    } 


    public function get_unplacedorders()
    {
        $this->load->library("datatables");

        $this->datatables->select("cart_product.cartId, cart_product.uid,cart_product.product_code,
        cart_product.date, cart_product.product_code,purchased_product_details.order_no,
        purchased_product_details.useremail,purchased_product_details.fullname,purchased_product_details.country");
        $this->datatables->from("cart_product");
        $this->datatables->where("cart_product.purchase_status", 1);
        
        // Get the date of the last 30 days from today
        $last30Days = date("Y-m-d", strtotime("-30 days"));
        $this->datatables->where("DATE(cart_product.date) >=", $last30Days);
        
        // Join with purchased_product_details without selecting any fields from it
        $this->datatables->join("purchased_product_details", "cart_product.uid = purchased_product_details.uid");
        
        $this->datatables->group_by("cart_product.productKey, cart_product.uid, cart_product.date");
        
        $this->datatables->add_column(
            "Actions",
            '
    <div class="text-center">
        <div class="btn-group">
            <a href="' .
                site_url('unplacedorders/delete/$1') .
                '" onClick="return confirm(\'' .
                $this->lang->line("Are you sure you want to delete?") .
                '\')" class="tip btn btn-danger btn-xs" title="' .
                $this->lang->line("delete_pcolor") .
                '"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>',
            "cartId"
        );

        $this->datatables->unset_column("cartId");

        echo $this->datatables->generate();
    }

    public function index()
    {
        $this->data["error"] = validation_errors()
            ? validation_errors()
            : $this->session->flashdata("error");

        $this->data[
            "unplacedorders"
        ] = $this->unplacedorders_model->getAllUnplacedorders();

        $this->data["page_title"] = $this->lang->line("unplacedorders");

        $bc = [
            ["link" => "#", "page" => lang("unplacedorders")],
            ["link" => "#", "page" => lang("list_unplacedorders")],
        ];

        $meta = ["page_title" => lang("UNPLACED ORDERS"), "bc" => $bc];

        $this->page_construct("unplacedorders/index", $this->data, $meta);
    }
}