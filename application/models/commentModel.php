<?php
class commentModel extends CI_Model
{
  function getAllComment()
  {
    return $this->db->get('komentar');
  }

  function getCommentById($id)
  {
    $this->db->join('artikel d', 'd.id_artikel=a.id_post', 'left');
    $this->db->join('user b', 'b.Email=a.id_user', 'left');
    $this->db->join('person c', 'b.PersonKey=c.PersonKey', 'left');
    return $this->db->get_where('komentar a', ['id_post' => $id]);
  }

  function addComment($id, $artikel, $akun, $komen)
  {
    $data = array('id_komen' => $id, 'id_post' => $artikel, 'id_user' => $akun, 'isi_komen' => $komen);
    return $this->db->insert('komentar', $data);
  }

  function deleteComment($idkomen)
  {
    return $this->db->delete('komentar', array('id_komen' => $idkomen));
  }
}
