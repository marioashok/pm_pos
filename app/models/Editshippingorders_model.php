<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Editshippingorders_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

    }

    public function deleteEditshippingorder($purchased_id)

    {

        if ($this->db->delete('purchased_product_details', ['purchased_id' => $purchased_id])) {

            return true;

        }

        return false;

    }



    public function updateEditshippingorder($purchased_id, $data = [])

    {

      

        if ($this->db->update('purchased_product_details', $data, ['purchased_id' => $purchased_id])) {

            return true;

        }

        return false;

    }

    public function getEditshippingorderByID($purchased_id)

    {   
         

        $q = $this->db->get_where('purchased_product_details', ['purchased_id' => $purchased_id], 1);
        if ($q->num_rows() > 0) {

            return $q->row();

        }
        return false;

    }



    public function getAllEditshippingorders()

    {

        $q = $this->db->get('purchased_product_details');

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }

            return $data;

        }

        return false;

    }
    
}

