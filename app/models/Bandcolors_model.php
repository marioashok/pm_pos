<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Bandcolors_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

    }

    public function addBandColor($data)

    {

        if ($this->db->insert('pm_catholic_color_banding', $data)) {

            return true;

        }

        return false;

    }

    public function getBandColorByID($color_band_id)

    {   
         

        $q = $this->db->get_where('pm_catholic_color_banding', ['color_band_id' => $color_band_id], 1);
        if ($q->num_rows() > 0) {

            return $q->row();

        }
        return false;

    }

    public function updateBandColor($color_band_id, $data = [])

    {
        if ($this->db->update('pm_catholic_color_banding', $data, ['color_band_id' => $color_band_id])) {
            return true;
        }
        return false;
    }


    public function deleteBandColor($color_band_id)
    {

        if ($this->db->delete('pm_catholic_color_banding', ['color_band_id' => $color_band_id])) {

            return true;

        }

        return false;

    }




  

    public function getAllBandcolors()
    {
        $q = $this->db->get('pm_catholic_color_banding');

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }

            return $data;

        }

        return false;
    }

    


    

}

