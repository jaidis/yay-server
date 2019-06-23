<?php
/**
 * Created by PhpStorm.
 * User: jaidis
 * Date: 1/05/18
 * Time: 15:45
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Bookingsmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllBookings()
    {
        return $this->db->get('restaurants_bookings')->result();
    }

    public function getBookingUserId($id_user)
    {
        $this->db->order_by('date_creation', 'desc');
        return $this->db->get_where('restaurants_bookings', array('id_user' => $id_user))->result();
    }

    public function getBookingId($id_restaurant)
    {
        return $this->db->get_where('restaurants_bookings', array('id_auto' => $id_restaurant))->result();
    }

    public function setNewBooking($array)
    {
        $this->db->insert('restaurants_bookings', $array);
        return $this->db->insert_id();
    }

    public function setUpdateBooking($id, $array)
    {
        $this->db->where('id_auto', $id);
        $this->db->update('restaurants_bookings', $array);
    }

    public function setDeleteBooking($id_restaurant)
    {
        return $this->db->delete('restaurants_bookings', array('id_auto' => $id_restaurant));
    }

    public function setNewLog($array)
    {
        return $this->db->insert('logs', $array);
    }
}
