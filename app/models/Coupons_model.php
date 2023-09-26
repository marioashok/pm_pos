<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Coupons_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addCoupon($data)
    {
        if ($this->db->insert("pm_coupons", $data)) {
            return true;
        }
        return false;
    }

    public function getCouponByID($coupon_id)
    {
        $q = $this->db->get_where(
            "pm_coupons",
            ["coupon_id" => $coupon_id],
            1
        );
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function updateCoupon($coupon_id, $data = [])
    {
        if (
            $this->db->update("pm_coupons", $data, [
                "coupon_id" => $coupon_id,
            ])
        ) {
            return true;
        }
        return false;
    }

    public function deleteCoupon($coupon_id)
    {
        if (
            $this->db->delete("pm_coupons", [
                "coupon_id" => $coupon_id,
            ])
        ) {
            return true;
        }

        return false;
    }

    public function ShowCoupon($coupon_id)
    {
        // Update the coupon_status column to 0 for the specified coupon ID
        $this->db->where("coupon_id", $coupon_id);
        $update_data = array("coupon_status" => 1);
        if ($this->db->update("pm_coupons", $update_data)) {
            return true; // Successfully updated the coupon status
        }

        return false; // Failed to update the coupon status
    }

    public function UnshowCoupon($coupon_id)
    {
        // Update the coupon_status column to 0 for the specified coupon ID
        $this->db->where("coupon_id", $coupon_id);
        $update_data = array("coupon_status" => 0);
        if ($this->db->update("pm_coupons", $update_data)) {
            return true; // Successfully updated the coupon status
        }

        return false; // Failed to update the coupon status
    }

     public function ApproveCoupon($coupon_id)
    {
    // Update the approval column to 0 for the specified coupon ID
    $this->db->where("coupon_id", $coupon_id);
    $update_data = array("approval" => 1);

    if ($this->db->update("pm_coupons", $update_data)) {
        return true; // Successfully updated the approval status
    }

    return false; // Failed to update the approval status
    }

   public function DisapproveCoupon($coupon_id)
    {
    // Update the approval column to 0 for the specified coupon ID
    $this->db->where("coupon_id", $coupon_id);
    $update_data = array("approval" => 0);

    if ($this->db->update("pm_coupons", $update_data)) {
        return true; // Successfully updated the approval status
    }

    return false; // Failed to update the approval status
    }


    public function getAllCoupons()
    {
        $q = $this->db->get("pm_coupons");

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return false;
    }
}
