<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}



class Homepageslider_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

    }


    public function addHomepageslider($data)

    {

        if ($this->db->insert('pm_all_images', $data)) {

            return true;

        }

        return false;

    }

    public function updateHomepageslider($id, $data = [])
    {
        if ($this->db->update('pm_all_images', $data, ['id' => $id])) {
            return true;
        }
        return false;
    }

    public function deleteHomepageslider($id)

    {

        if ($this->db->delete('pm_all_images', ['id' => $id])) {

            return true;

        }

        return false;

    }


    public function getHomepagesliderByID($id)

    {   
         

        $q = $this->db->get_where('pm_all_images', ['id' => $id], 1);
        if ($q->num_rows() > 0) {

            return $q->row();

        }
        return false;

    }
    public function updateImage($id, $newImage)
{
    // Define the table name
    $table_name = 'pm_all_images';

    // Create data array with the new image value
    $data = array(
        'image' => $newImage
    );

    // Set the WHERE condition to match the provided ID
    $this->db->where('id', $id);

    // Execute the update query
    $this->db->update($table_name, $data);

    // Check if the update was successful
    if ($this->db->affected_rows() > 0) {
        return true; // Update successful
    } else {
        return false; // No matching record found or update failed
    }
}

    public function retrieveImageNameById($id)
    {
        // Define the table name
        $table_name = 'pm_all_images';
    
        // Select the 'image' column from the specified table where id matches
        $this->db->select('image');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get($table_name);
    
        // Check if a row was found
        if ($query->num_rows() > 0) {
            // Fetch the row and return the 'image' column value
            $row = $query->row();
            return $row->image;
        } else {
            // No matching record found
            return false;
        }
    }

    public function retrieveLastID()
    {
        // Define the table name
        $table_name = 'pm_all_images';
    
        // Add the order by clause
        $this->db->order_by('id', 'desc');
    
        $this->db->limit(1);
        $query = $this->db->get($table_name);
    
        // Check if a row was found
        if ($query->num_rows() > 0) {
            // Fetch the row and return the 'id' column value
            $row = $query->row();
            return $row->id;
        } else {
            // No matching record found
            return false;
        }
    }
    



    public function getAllHomepagesliders()
    {
        $q = $this->db->get('pm_all_images');

        if ($q->num_rows() > 0) {

            foreach (($q->result()) as $row) {

                $data[] = $row;

            }

            return $data;

        }

        return false;
    }

    


    

}

