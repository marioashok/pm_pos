<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Retailcustomers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_retailcustomers($data = [])
    {
        if ($this->db->insert_batch('register', $data)) {
            return true;
        }
        return false;
    }

    public function addRetailCustomer($data)
    {
        if ($this->db->insert('register', $data)) {
            return true;
        }
        return false;
    }

    public function deleteRetailCustomer($user_id)
    {
        if ($this->db->delete('register', ['user_id' => $user_id])) {
            return true;
        }
        return false;
    }

    public function updateRetailCustomer($user_id, $data = null)
    {
        if ($this->db->update('register', $data, ['user_id' => $user_id])) {
            return true;
        }
        return false;
    }
    
    public function getAllRetailCustomers()
    {
        $q = $this->db->get('register');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    public function getRetailCustomerByID($user_id)
    {
        $q = $this->db->get_where('register', ['user_id' => $user_id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
}
