<?php
/**
 * Created by PhpStorm.
 * User: jaidis
 * Date: 1/05/18
 * Time: 15:45
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Creditcardmodel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getCreditCardUserId($id_user){
        return $this->db->get_where('users_credit_card', array('id_user'=>$id_user))->result();
    }

    public function setNewCreditCard($array)
    {
        $this->db->insert('users_credit_card', $array);
        return $this->db->insert_id();
    }

    public function setUpdateCreditCard($id, $array)
    {
        $this->db->where('id', $id);
        return $this->db->update('users_credit_card', $array);
    }

    public function setDeleteCreditCard($id_credit_card)
    {
        return $this->db->delete('users_credit_card', array('id' => $id_credit_card));
    }

    public function setNewLog($array){
        return $this->db->insert('logs',$array);
    }
}