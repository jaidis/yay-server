<?php
/**
 * Created by PhpStorm.
 * User: jaidis
 * Date: 1/05/18
 * Time: 15:45
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Categoriesmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllCategories()
    {
        return $this->db->get('categories')->result();
    }

    public function getCategoriesRestaurant($id_category)
    {   $this->db->join('restaurants', 'restaurants_categories.id_restaurant = restaurants.id', 'inner');
        return $this->db->get_where('restaurants_categories', array('id_category' => $id_category))->result();
    }

    public function getCategoryId($id_category)
    {
        return $this->db->get_where('categories', array('id' => $id_category))->result();
    }

    public function setNewCategory($array)
    {
        $this->db->insert('categories', $array);
        return $this->db->insert_id();
    }

    public function setUpdateCategory($id, $array)
    {
        $this->db->where('id', $id);
        $this->db->update('categories', $array);
    }

    public function setDeleteCategory($id_restaurant)
    {
        return $this->db->delete('categories', array('id' => $id_restaurant));
    }

    public function setNewLog($array)
    {
        return $this->db->insert('logs', $array);
    }
}
