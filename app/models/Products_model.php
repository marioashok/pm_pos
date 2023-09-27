<?php



if (!defined('BASEPATH')) {

    exit('No direct script access allowed');

}


class Products_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

    }

    public function addProduct($data)

    {

        if ($this->db->insert('pm_product_list', $data)) {

            return true;

        }

        return false;

    }

   public function getProductByID($purchased_id)

    {   
         

        $q = $this->db->get_where('pm_product_list', ['purchased_id' => $purchased_id], 1);
        if ($q->num_rows() > 0) {

            return $q->row();

        }
        return false;

    }

    public function updateProduct($purchased_id, $data = [])

    {
        if ($this->db->update('pm_product_list', $data, ['purchased_id' => $purchased_id])) {
            return true;
        }
        return false;
    }

    public function deleteProduct($purchased_id)
    {

        if ($this->db->delete('pm_product_list', ['purchased_id' => $purchased_id])) {

            return true;

        }

        return false;

    }

    public function getProductsWithSearchAndPagination($subcategory_id, $category_id, $limit, $offset)
{
    // Build the SQL query with pagination and search
    $sql = "SELECT * FROM pm_product_list
            INNER JOIN subcategories ON subcategories.id = pm_product_list.sub_cat
            INNER JOIN categories ON categories.id = subcategories.category_id
            WHERE subcategories.id = '$subcategory_id'
            AND categories.id = '$category_id'";

    // Add search condition
    if (!empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $sql .= " AND (gen_product_code LIKE '%$searchTerm%' OR design_code LIKE '%$searchTerm%')";
    }

    $sql .= " LIMIT $limit OFFSET $offset";

    // Execute the SQL query
    $query = $this->db->query($sql);

    if ($query && $query->num_rows() > 0) {
        return $query->result();
    }

    return false;
}

public function getTotalProductCount($subcategory_id, $category_id)
{
    // Build the SQL query for total record count
    $sql = "SELECT COUNT(*) AS total_count FROM pm_product_list
            INNER JOIN subcategories ON subcategories.id = pm_product_list.sub_cat
            INNER JOIN categories ON categories.id = subcategories.category_id
            WHERE subcategories.id = '$subcategory_id'
            AND categories.id = '$category_id'";

    // Add search condition
    if (!empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $sql .= " AND (gen_product_code LIKE '%$searchTerm%' OR design_code LIKE '%$searchTerm%')";
    }

    // Execute the SQL query
    $query = $this->db->query($sql);

    if ($query && $query->num_rows() > 0) {
        $result = $query->row();
        return $result->total_count;
    }

    return 0;
}


    
    
    
}

