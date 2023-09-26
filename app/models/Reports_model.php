<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Reports_model extends CI_Model
{
    public function __construct()

    {

        parent::__construct();

    }

    public function addReport($data)

    {

        if ($this->db->insert('purchased_product_details', $data)) {

            return true;

        }

        return false;

    }

    public function getReportByID($purchased_id)

    {


        $q = $this->db->get_where('purchased_product_details', ['purchased_id' => $purchased_id], 1);
        if ($q->num_rows() > 0) {

            return $q->row();

        }
        return false;

    }

    public function updateReport($purchased_id, $data = [])

    {
        if ($this->db->update('purchased_product_details', $data, ['purchased_id' => $purchased_id])) {
            return true;
        }
        return false;
    }


    public function deleteReport($purchased_id)
    {

        if ($this->db->delete('purchased_product_details', ['purchased_id' => $purchased_id])) {

            return true;

        }

        return false;

    }


    public function getAllReports()
    {

        $query = $this->db->query("SELECT `purchased_date` ,COUNT(*) AS volume, SUM( `price_per_product`) AS sales FROM `purchased_product_details` WHERE `order_status` IN ('1','3') GROUP BY `purchased_date` ORDER BY `purchased_date` DESC LIMIT 30");
        $result =  $query->result();
        return $result;


    }

    public function get_current_date($i)
    {
        $q = $this->db->query("SELECT DATE(NOW() - INTERVAL '".$i."' DAY) as current_dt FROM `purchased_product_details`");
        $result = $q->result();
        $result = $result[0]->current_dt;
        return $result;

    }

    public function get_sales_count($current_date)
    {
        $q = $this->db->query("SELECT count(*) as sales_count  FROM `purchased_product_details` WHERE `purchased_date` = '".$current_date."'");
        $result = $q->result();
        $result = $result[0]->sales_count;
        return $result;

    }

    public function get_shipping_count($current_date)
    {
        $q = $this->db->query("SELECT count(*) as shipping_count FROM `purchased_product_details` WHERE `shipment_date` = '".$current_date."'");
        $result = $q->result();
        $result = $result[0]->shipping_count;
        return $result;
    }

    public function get_product_sales_report($start_date,$end_date)
    {
        $query = $this->db->query("SELECT date,LEFT(`product_code`, (LOCATE('_', `product_code`) - 1)) AS cat_name, SUBSTRING_INDEX(`product_code`, '_', 3) AS prodcode, REPLACE(RIGHT(SUBSTRING_INDEX(`product_code`, '_', 3), 3), '_', '') AS color, SUM(proCount) AS salescount FROM `cart_product` WHERE `purchase_status` = '1' AND `date` BETWEEN '$start_date' AND '$end_date' GROUP BY cat_name, prodcode, color;");
        $result =  $query->result();
        return $result;

    }


}

