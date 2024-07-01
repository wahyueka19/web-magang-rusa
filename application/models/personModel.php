<?php

class personModel extends CI_model
{
  function searchLike($target, $filterby, $search, $filter)
  {
    if ($search && $filter !== NULL) {
      $array = array($target => $search, $filterby => $filter);
      $this->db->like($array);
    } else if ($search || $filter !== NULL) {
      $array = array($target => $search, $filterby => $filter);
      $this->db->like($array);
    }
  }

  function getAllPerson()
  {
    return $this->db->get('person');
  }

  function getPersonBy($where)
  {
    return $this->db->get_where('person', $where);
  }

  function getUsernameByPersonKey($personKey)
  {
    $this->db->select('Nama');
    $where = "PersonKey = '$personKey'";
    return $this->getPersonBy($where);
  }

  function addNewPerson($id, $username, $tgl_lahir, $no_hp)
  {
    $data = array('PersonKey' => $id, 'Nama' => $username, 'DateofBirth' => $tgl_lahir, 'NoHp' => $no_hp);
    return $this->db->insert('person', $data);
  }

  function editPerson($id, $username, $tgl_lahir, $no_hp)
  {
    $data = array('PersonKey' => $id, 'Nama' => $username, 'DateofBirth' => $tgl_lahir, 'NoHp' => $no_hp);
    return $this->db->update('person', $data, array('PersonKey' => $id));
  }

  function delete($id)
  {
    return $this->db->delete('person', array('PersonKey' => $id));
  }

  function ajaxAkun($keyword)
  {
    $this->db->select('Nama');
    $this->db->from('person');
    $this->db->where('Nama!=', 'Super Admin');
    $this->db->like('Nama', $keyword);

    $data = $this->db->get()->result_array();

    $output = array();

    if ($data) {
      foreach ($data as $d) {
        array_push($output, ['label' => $d['Nama']]);
      }
    }

    echo json_encode($output);
  }
}
