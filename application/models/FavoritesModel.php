<?php
/**
 * Created by PhpStorm.
 * User: jaidis
 * Date: 1/05/18
 * Time: 15:45
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Favoritesmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getFavoriteRestaurantUserId($id_user, $id_restaurant){
        return $this->db->get_where('users_favorites', array('id_user'=>$id_user, 'id_restaurant'=>$id_restaurant))->result();
    }

    public function getFavoritesUserId($id_user){
        return $this->db->get_where('users_favorites', array('id_user'=>$id_user))->result();
    }

    public function setNewFavorite($array)
    {
        $this->db->insert('users_favorites', $array);
        return $this->db->insert_id();
    }

    public function setUpdateFavorite($id, $array)
    {
        $this->db->where('id', $id);
        $this->db->update('users_favorites', $array);
    }

    public function setDeleteFavorite($id_favorite)
    {
        return $this->db->delete('users_favorites', array('id' => $id_favorite));
    }

    public function setNewLog($array){
        return $this->db->insert('logs',$array);
    }
}