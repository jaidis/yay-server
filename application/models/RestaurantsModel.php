<?php
/**
 * Created by PhpStorm.
 * User: jaidis
 * Date: 1/05/18
 * Time: 15:45
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Restaurantsmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllRestaurants()
    {
        return $this->db->get('restaurants')->result();
    }

    public function getRestaurantsProvince($province)
    {
        return $this->db->get_where('restaurants', array('province' => $province))->result();
    }

    public function getRestaurantCategories($id_restaurant)
    {   $this->db->join('categories', 'restaurants_categories.id_category = categories.id', 'inner');
        return $this->db->get_where('restaurants_categories', array('id_restaurant' => $id_restaurant))->result();
    }

    public function getRestaurantId($id_restaurant)
    {
        return $this->db->get_where('restaurants', array('id' => $id_restaurant))->result();
    }

    public function setNewRestaurant($array)
    {
        $this->db->insert('restaurants', $array);
        return $this->db->insert_id();
    }

    public function setUpdateRestaurant($id, $array)
    {
        $this->db->where('id', $id);
        $this->db->update('restaurants', $array);
    }

    public function setDeleteRestaurant($id_restaurant)
    {
        return $this->db->delete('restaurants', array('id' => $id_restaurant));
    }

    public function getRestaurantsEntrees($id_restaurant)
    {
        return $this->db->get_where('restaurants_entrees', array('id_restaurant' => $id_restaurant))->result();
    }

    public function getRestaurantsSalads($id_restaurant)
    {
        return $this->db->get_where('restaurants_salads', array('id_restaurant' => $id_restaurant))->result();
    }

    public function getRestaurantsSoups($id_restaurant)
    {
        return $this->db->get_where('restaurants_soups', array('id_restaurant' => $id_restaurant))->result();
    }

    public function getRestaurantsMeats($id_restaurant)
    {
        return $this->db->get_where('restaurants_meats', array('id_restaurant' => $id_restaurant))->result();
    }

    public function getRestaurantsFishes($id_restaurant)
    {
        return $this->db->get_where('restaurants_fishes', array('id_restaurant' => $id_restaurant))->result();
    }

    public function getRestaurantsSpecialties($id_restaurant)
    {
        return $this->db->get_where('restaurants_specialties', array('id_restaurant' => $id_restaurant))->result();
    }

    public function getRestaurantsSchedule($id_restaurant)
    {
        return $this->db->get_where('restaurants_schedule', array('id_restaurant' => $id_restaurant))->result();
    }

    public function setNewLog($array)
    {
        return $this->db->insert('logs', $array);
    }
}
