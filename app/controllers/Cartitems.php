<?php
defined("BASEPATH") or exit("No direct script access allowed");
class Cartitems extends MY_Controller
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
        $this->load->model("cartitems_model");
    }
    public function get_cartitems()
    {
        $this->load->library("datatables");
        // Prepare the email body with proper URL encoding for spaces
        $emailBody1 =
            "Dear Father,%0A%0A" .
            "As you had tried to place the order during our Anniversary Sale, we are happy to extend the offer to you the same discount for a limited time.%0A%0A" .
            "Please use the coupon code HAPPYFEAST2 during checkout (in the address page) for FLAT 23% OFF. The offer is extended till 23rd September, 2023 specially for you and few more who have missed to complete the order.%0A%0A" .
            "Your items are still in the cart and you can access your cart directly from the link below:%0A%0A" .
            "https://www.catholicliturgicals.com/index.php?URL=cart.htm%0A%0A" .
            "Please note there might be a delay in shipping (by around 2-4 weeks) because of Sale backlog. If you want the items urgently, please send me an email and I will fast track your order.%0A%0A" .
            "Please feel free to let me know if you need any assistance.%0A%0A" .
            "With Kind Regards%0A" .
            "~Frank";

        $emailBody2 =
            "Dear Father,%0A%0A" .
            "Your last order did not come through because of reason code - Payment refused by the issuer with the Visa/ Master Card payment gateway. This is a common error that occurs for all international transactions for the first time. If you try making the payment again on the same day, the bank approves the transaction. Some cards decline for international transaction limits and some need approval from the bank.%0A%0A" .
            "You can try making the payment again, and if it does not help, you can also pay with Credit / Debit cards by choosing PayPal payment gateway. Once you select PayPal as a payment option, you can pay by Paypal or Credit / Debit Card. You need not have a PayPal account.%0A%0A" .
            "You can access your cart directly from the link below:%0A%0A" .
            "https://www.catholicliturgicals.com/index.php?URL=ordersummary.htm%0A%0A" .
            "Please feel free to let me know if you need any assistance.%0A%0A" .
            "With Kind Regards%0A" .
            "~Frank";

        $this->datatables->select('
                cart_temp.id, 
                DATE_FORMAT(cart_temp.date, "%Y-%m-%d") AS date,
                cart_temp.uid, 
                cart_temp.regaddrfullname AS fullname, 
                register.email, 
                cart_temp.regaddrphone AS phone,
                cart_temp.regaddrcountry AS country,
                cart_temp.page_id, 
                cart_temp.shipping_mode, 
                cart_temp.total_amount, 
                (SELECT COUNT(*) FROM cart_product WHERE cart_product.uid = cart_temp.uid AND cart_product.purchase_status = "0") AS cart_count');
        $this->datatables->from("cart_temp");
        $this->datatables->join("register", "cart_temp.uid = register.user_id");
        $this->datatables->add_column(
            "Actions",
            "<div class='text-center'>
            <a href='" .
                site_url('cartitems/viewcart/$3') .
                "' title='" .
                lang("VIEW") .
                "' class='tip btn btn-success btn-xs'><i class='fa fa-search'></i></a> 
            <a href='mailto:$5?subject=Your%20Discount%20Offer&body=" .
                $emailBody1 .
                "' title='" .
                lang("EMAIL") .
                "' class='tip btn btn-warning btn-xs'><i class='fa fa-envelope'></i></a>
            <a href='mailto:$5?subject=Payment%20Gateway%20Error&body=" .
                $emailBody2 .
                "' title='" .
                lang("EMAIL") .
                "' class='tip btn btn-primary btn-xs'><i class='fa fa-envelope'></i></a>
            <a href='" .
                site_url('cartitems/delete/$1') .
                "' onClick=\"return confirm('" .
                lang("DELETE?") .
                "')\" title='" .
                lang("DELETE") .
                "' class='tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>
            </div></div>",
            "id,date,uid,regaddrfullname,email,regaddrphone,regaddrcountry,page_id,shipping_mode,total_amount,cart_count"
        );
        $this->datatables->unset_column("id");
        echo $this->datatables->generate();
    }

    public function delete($id = null)
    {
        if ($this->input->get("id")) {
            $id = $this->input->get("id", true);
        }
        if (!$this->Admin) {
            $this->session->set_flashdata("error", lang("access_denied"));
            redirect("pos");
        }
        if ($this->cartitems_model->deleteCartitem($id)) {
            $this->session->set_flashdata("message", lang("DELETED"));
            redirect("cartitems");
        }
    }

    public function delete_cart_product_item($cartId = null)
    {
        if ($this->input->get("cartId")) {
            $id = $this->input->get("cartId", true);
        }

        if (!$this->Admin) {
            $this->session->set_flashdata("error", lang("access_denied"));

            redirect("pos");
        }

        if ($this->cartitems_model->deleteCartProductitem($cartId)) {
            $this->session->set_flashdata("message", lang("DELETED"));

            redirect("cartitems");
        }
    }

    public function viewcart($uid = null)
    {
        $this->data["cartitem"] = $this->cartitems_model->getCartitemByID($uid);
        $this->data["page_title"] = $this->lang->line("VIEW CART ITEMS");
        $bc = [
            ["link" => "#", "page" => lang("VIEW CART ITEMS")],
            ["link" => "#", "page" => lang("VIEW CART ITEMS")],
        ];
        $meta = ["page_title" => lang("VIEW CART ITEMS"), "bc" => $bc];
        $this->page_construct("cartitems/viewcart", $this->data, $data2, $meta);
    }

    public function index()
    {
        $this->data["error"] = validation_errors()
            ? validation_errors()
            : $this->session->flashdata("error");
        $this->data["cartitems"] = $this->site->getAllCartTempItems();
        $this->data["page_title"] = $this->lang->line("cartitems");
        $bc = [
            ["link" => "#", "page" => lang("Cart Items")],
            ["link" => "#", "page" => lang("Cart Items")],
        ];
        $meta = ["page_title" => lang("Cart Items"), "bc" => $bc];
        $this->page_construct("cartitems/index", $this->data, $meta);
    }
}
