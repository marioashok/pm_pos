<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Cartitems_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

    }


    public function getCartitemByID($uid)

    {

        $q = $this->db->get_where('cart_product', ['uid' => $uid, 'purchase_status' => '0'], 1);

        if ($q->num_rows() > 0) {

            return $q->row();

        }

        return false;

    }

    
    public function deleteCartitem($id)

    {

        if ($this->db->delete('cart_temp', ['id' => $id])) {

            return true;

        }

        return false;

    }

    public function deleteCartProductitem($cartId)

    {

        if ($this->db->delete('cart_product', ['cartId' => $cartId])) {

            return true;

        }

        return false;

    }
    


    
    public function getAllCartTempItems()
    {
        $q = $this->db->get('cart_temp');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
               $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    public function getCartTempByID($uid)
    {
        $q = $this->db->get_where('cart_temp', ['uid' => $uid], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    public function getAllCartProductItems($uid)

    {

        $this->db->select('c.proId, c.cartId, c.proCount, c.product_code, c.mat_id, p.prod_name, i.thumb_image_path');
        $this->db->from('cart_product c');
        $this->db->join('pm_product_list p', 'p.product_id = c.proId');
        $this->db->join('pm_image_list i', 'i.Product_id = c.proId');
        $this->db->where('c.uid', $uid);
        $this->db->where('c.purchase_status', '0');
        $this->db->select('CASE WHEN c.mat_id > 0 THEN m.mat_price ELSE p.Price END AS Price', false);
        $this->db->join('pm_product_matrix_row m', 'm.mat_id = c.mat_id', 'left');
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
        

    }
    
    public function viewCart($id)
    {
        $query = $this->db->query("SELECT * FROM `cart_product` WHERE `uid` = '$store_id'  AND ( `status` = '1'  OR `status` = '2') 
        GROUP BY `date_requested`, `requested_by`, `from_store_id` ORDER BY `date_requested` DESC 
        ");
        return $query->result();
    }
    

}

