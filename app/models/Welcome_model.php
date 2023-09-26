<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getChartData($user_id = null)
    {
        if (!$this->Admin) {
            $user_id = $this->session->userdata('user_id');
        }
        if ($this->db->dbdriver == 'sqlite3') {
            $this->db->select("strftime('%Y-%m', date) as month, SUM(total) as total, SUM(total_tax) as tax, SUM(total_discount) as discount")
            ->where("date >= datetime('now','-6 month')", null, false)
            // ->order_by("strftime('%Y-%m', date)", 'asc')
            ->group_by("strftime('%Y-%m', date)");
        } else {
            $this->db->select("date_format(date, '%Y-%m') as month, SUM(total) as total, SUM(total_tax) as tax, SUM(total_discount) as discount")
            ->where('date >= date_sub( now() , INTERVAL 6 MONTH)', null, false)
            // ->order_by("date_format(date, '%Y-%m')", 'asc')
            ->group_by("date_format(date, '%Y-%m')");
        }
        if ($user_id) {
            $this->db->where('created_by', $user_id);
        }
        if ($store_id = $this->session->userdata('store_id')) {
            $this->db->where('store_id', $store_id);
        }

    }

    public function getUserGroups()
    {
        $this->db->order_by('id', 'desc');
        $q = $this->db->get('users_groups');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

   

    public function userGroups()
    {
        $ugs = $this->getUserGroups();
        if ($ugs) {
            foreach ($ugs as $ug) {
                $this->db->update('users', ['group_id' => $ug->group_id], ['id' => $ug->user_id]);
            }
            return true;
        }
        return false;
    }
}
