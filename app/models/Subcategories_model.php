<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Subcategories_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_subcategories($data = [])
    {
        if ($this->db->insert_batch('subcategories', $data)) {
            return true;
        }
        return false;
    }

    public function addSubcategory($data)
    {
        if ($this->db->insert('subcategories', $data)) {
            return true;
        }
        return false;
    }

    public function deleteSubcategory($id)
    {
        if ($this->db->delete('subcategories', ['id' => $id])) {
            return true;
        }
        return false;
    }

    public function updateSubcategory($id, $data = null)
    {
        if ($this->db->update('subcategories', $data, ['id' => $id])) {
            return true;
        }
        return false;
    }


    public function getAllSubcategories($category_id)
    {

        $sql = "SELECT subcategories.*, categories.name AS category_name
        FROM subcategories
        INNER JOIN categories
        ON subcategories.category_id = categories.id
        WHERE subcategories.category_id = '$category_id'
        ORDER BY subcategories.type_indicator DESC;
        ";
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    

    public function getSubcategoryByID($id)
    {
        $q = $this->db->get_where('subcategories', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    public function retrieveLastID()
    {
        // Define the table name
        $table_name = 'subcategories';
    
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
        $table_name = 'subcategories';
    
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
        $table_name = 'subcategories';
    
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


    public function getSubcategoriesWithSearch($category_id, $searchTerm) {
        $this->db->select('*');
        $this->db->from('subcategories');
        $this->db->where('category_id', $category_id);
        $this->db->order_by('subcategories.type_indicator', 'DESC');

    
        // Check if a search term is provided and apply the filter
        if (!empty($searchTerm)) {
            $this->db->group_start();
            $this->db->like('name', $searchTerm);
            $this->db->or_like('code', $searchTerm);
            // You can add more columns to search in here using additional or_like calls
            $this->db->group_end();
        }
    
        $query = $this->db->get();
    
        return $query->result();
    }
    

public function getSubcategoriesWithSearchAndPagination($category_id, $limit, $offset, $searchTerm) {
    $this->db->select('*');
    $this->db->from('subcategories');
    $this->db->where('category_id', $category_id);
    $this->db->order_by('subcategories.type_indicator', 'DESC');

    // Check if a search term is provided and apply the filter
    if (!empty($searchTerm)) {
        $this->db->group_start();
        $this->db->like('name', $searchTerm);
        $this->db->or_like('code', $searchTerm);
        $this->db->group_end();
    }

    $this->db->limit($limit, $offset);
    $query = $this->db->get();

    return $query->result();
}



    
    

}
