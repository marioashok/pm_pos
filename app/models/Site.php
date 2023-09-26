<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Site extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllPrinters()
    {
        $this->db->order_by('title');
        $q = $this->db->get('printers');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllStores()
    {
        $q = $this->db->get('stores');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllCartTempItems()
    {
        $this->db->order_by('date');
        $q = $this->db->get('cart_temp');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllCartProductItems($uid)
    {
        $this->db->where('uid', $uid);
        $this->db->where('purchase_status', "0");
        $q = $this->db->get('cart_product');   
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } 
        return false;
    }
    
    public function getAllCategories()
    {
        
        $q = $this->db->get('categories');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    public function getOtherStores()
    {
        $store_id = $this->session->userdata("store_id");
        $q = $this->db->where("id!=", $store_id)->get("stores");
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }    

    public function getAllUsers()
    {
        $this->db->select("{$this->db->dbprefix('users')}.id as id, first_name, last_name, {$this->db->dbprefix('users')}.email, company, {$this->db->dbprefix('groups')}.name as group, active, {$this->db->dbprefix('stores')}.name as store")
            ->join('groups', 'users.group_id=groups.id', 'left')
            ->join('stores', 'users.store_id=stores.id', 'left')
            ->group_by('users.id');
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }


    
    public function getStoreNameById($id)
    {
        $q = $this->db
            ->select("name")
            ->where(["id" => $id])
            ->get("tec_stores");

        $get_store_ = $q->result();

        $get_store = $get_store_[0]->name;

        return $get_store;
    }

    public function getPrinterByID($id)
    {
        $q = $this->db->get_where('printers', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    public function getSettings()
    {
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getStoreByID($id = null)
    {
        if (!$id) {
            return false;
        }
        $q = $this->db->get_where('stores', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    public function getUser($id = null)
    {
        if (!$id) {
            $id = $this->session->userdata('user_id');
        }
        $q = $this->db->get_where('users', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getUserGroup($user_id = null)
    {
        if ($group_id = $this->getUserGroupID($user_id)) {
            $q = $this->db->get_where('groups', ['id' => $group_id], 1);
            if ($q->num_rows() > 0) {
                return $q->row();
            }
        }
        return false;
    }

    public function getUserGroupID($user_id = null)
    {
        if ($user = $this->getUser($user_id)) {
            return $user->group_id;
        }
        return false;
    }

    public function getUsers()
    {
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getUserSuspenedSales()
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('id, date, customer_name, hold_ref')
        ->order_by('id desc');
        //->limit(10);
        $this->db->where('store_id', $this->session->userdata('store_id'));
        $q = $this->db->get_where('suspended_sales', ['created_by' => $user_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function registerData($user_id)
    {
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $q = $this->db->get_where('registers', ['user_id' => $user_id, 'status' => 'open'], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
}
