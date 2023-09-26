<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Unplacedorders_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

    }

    public function getAllUnplacedOrders()

    {

        $q = $this->db->get('cart_product');

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }

            return $data;

        }

        return false;

    }

    public function deleteUnplacedorder($cartId)
    {

        if ($this->db->delete('cart_product', ['cartId' => $cartId])) {

            return true;

        }

        return false;

    }
    

}

