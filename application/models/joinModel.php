<?php

class joinModel extends CI_model
{
  function getJoinedArtikelById($id)
  {
    $this->db->join('user b', 'b.Email=a.id_user', 'left');
    $this->db->join('person c', 'b.PersonKey=c.PersonKey', 'left');
    return $this->db->get_where('artikel a', ['id_artikel' => $id]);
  }

  function searchLike($target, $filterBy, $search, $filter)
  {
    if ($search && $filter !== NULL) {
      $array = array($target => $search, $filterBy => $filter);
      $this->db->like($array);
    } else if ($search || $filter !== NULL) {
      $array = array($target => $search, $filterBy => $filter);
      $this->db->like($array);
    }
  }

  function getAllJoinedUser($target, $filterBy, $search, $filter, $limit = 0, $start = 0)
  {
    $this->searchLike($target, $filterBy, $search, $filter);
    $this->db->where_not_in($target, 'Super Admin');
    $this->db->order_by('a.PersonKey', 'DESC');
    $this->db->join('user b', 'b.PersonKey=a.PersonKey', 'left');
    return $this->db->get('person a', $limit, $start);
  }

  function getAllJoinedArtikel($target, $filterBy, $search, $filter, $limit = 0, $start = 0, $where = false)
  {
    $this->searchLike($target, $filterBy, $search, $filter);
    $this->db->join('user b', 'b.Email=a.id_user', 'left');
    $this->db->join('person c', 'b.PersonKey=c.PersonKey', 'left');
    $this->db->order_by('tgl_post', 'DESC');
    return $this->db->get('artikel a',  $limit, $start);
  }
}
