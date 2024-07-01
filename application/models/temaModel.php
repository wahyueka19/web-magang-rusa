<?php

class temaModel extends CI_model
{
  function currentTheme($active)
  {
    return $this->db->get_where('tema', ['active' => $active])->result_array();
  }

  function getTema($idTema, $active, $remove)
  {
    $this->db->set('active', $active);
    $this->db->where('id', $idTema);
    $this->db->update('tema');

    $this->db->set('active', $remove);
    $this->db->where('id !=', $idTema);
    $this->db->update('tema');

    return  $this->db->get_where('tema', ['id' => $idTema]);
  }
}
