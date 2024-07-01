<?php
class userModel extends CI_Model
{
  function getAllUser()
  {
    return $this->db->get('user');
  }

  function getUserBy($where)
  {
    return $this->db->get_where('user', $where);
  }

  function getUserByEmailPass($username, $password)
  {
    $where = "Email='$username' AND Password='" . $this->db->escape_str($password) . "'";
    return $this->getUserBy($where);
  }

  function getUserStatus($username, $password)
  {
    $this->db->select('RoleId');
    return $this->getUserByEmailPass($username, $password);
  }

  function addNewUser($email, $id, $password, $tipe_akun)
  {
    $data = array('Email' => $email, 'PersonKey' => $id, 'Password' => $password, 'RoleId' => $tipe_akun);
    return $this->db->insert('user', $data);
  }

  function editUser($email, $id, $password, $tipe_akun)
  {
    $data = array('Email' => $email, 'PersonKey' => $id, 'Password' => $password, 'RoleId' => $tipe_akun);
    return $this->db->update('user', $data, array('PersonKey' => $id));
  }
}
