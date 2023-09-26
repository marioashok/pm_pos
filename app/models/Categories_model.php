<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Categories_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_categories($data = [])
    {
        if ($this->db->insert_batch('categories', $data)) {
            return true;
        }
        return false;
    }

    public function addCategory($data)
    {
        if ($this->db->insert('categories', $data)) {
            return true;
        }
        return false;
    }

    public function deleteCategory($id)
    {
        if ($this->db->delete('categories', ['id' => $id])) {
            return true;
        }
        return false;
    }

    public function updateCategory($id, $data = null)
    {
        if ($this->db->update('categories', $data, ['id' => $id])) {
            return true;
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

    public function getCategoryByID($id)
    {
        $q = $this->db->get_where('categories', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getCustomerByID($id)
    {
        $q = $this->db->get_where('customers', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    public function retrieveLastID()
    {
        // Define the table name
        $table_name = 'categories';
    
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

    public function retrieveImageNameById($id)
    {
        // Define the table name
        $table_name = 'categories';
    
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

    public function updateImage($id, $newImage)
    {
        // Define the table name
        $table_name = 'categories';
    
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
    

}
