<?php
/**
 * Created by PhpStorm.
 * User: jaidis
 * Date: 1/05/18
 * Time: 15:45
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Usersmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUserId($id_user){
        return $this->db->get_where('users', array('id'=>$id_user))->result();
    }

    public function getUserEmail($email_user){
        return $this->db->get_where('users', array('email'=>$email_user))->result();
    }

    public function getUserToken($token){
        return $this->db->get_where('users', array('token'=>$token))->result();
    }

    public function setNewUser($array)
    {
        $this->db->insert('users', $array);
        return $this->db->insert_id();
    }

    public function setUpdateUser($id, $array)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $array);
    }

    public function setDeleteUser($id_user)
    {
        return $this->db->delete('users', array(
            'id' => $id_user
        ));
    }

    public function setNewLog($array){
        return $this->db->insert('logs',$array);
    }
}