<?php

class artikelModel extends CI_model
{
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

  function getAllArtikel($target = false, $filterBy = false, $search = false, $filter = false, $limit = 0, $start = 0, $sort = 'desc')
  {
    if ($target !== false && $filterBy !== false && $search !== false && $filter !== false) {
      $this->searchLike($target, $filterBy, $search, $filter);
    }
    $this->db->order_by('tgl_post', $sort);
    return $this->db->get('artikel',  $limit, $start);
  }

  function getArtikelBy($where, $limit = 0, $start = 0)
  {
    return $this->db->get_where('artikel', $where, $limit, $start);
  }

  function getArtikelByStatus($status, $id_akun = null)
  {
    if ($id_akun != null) {
      $where = "status = '$status' AND id_user = '$id_akun'";
    } else {
      $where = "status = '$status'";
    }
    return $this->getArtikelBy($where);
  }

  function getArtikelById($id_artikel)
  {
    $where = "id_artikel = '$id_artikel'";
    return $this->getArtikelBy($where);
  }

  function getAllArtikelByUser($id_user, $target, $filterBy, $search, $filter, $limit = 0, $start = 0)
  {
    $where = "id_user = '" . $id_user . "'";
    $this->searchLike($target, $filterBy, $search, $filter);
    $this->db->order_by('tgl_post', 'DESC');
    return $this->getArtikelBy($where, $limit, $start);
  }

  function getSampulById($id_artikel)
  {
    $this->db->select('isi_gambar');
    return $this->getArtikelById($id_artikel);
  }

  function grafik($status, $id_akun)
  {
    $count = $this->getArtikelByStatus($status, $id_akun)->num_rows();
    $query = $this->db->query("SELECT status as stat, COUNT(status) as count, MONTHNAME(tgl_post) as month_name FROM artikel WHERE status = '$status' AND id_user = '$id_akun' GROUP BY YEAR(tgl_post),MONTH(tgl_post), status");
    return $query->result();
  }

  function ajaxArtikel($keyword, $id = null)
  {
    $this->db->select('judul');
    $this->db->from('artikel');
    $this->db->like('judul', $keyword);
    if ($id !== null) {
      $this->db->where('id_user', $id);
    }

    $data = $this->db->get()->result_array();

    $output = array();

    if ($data) {
      foreach ($data as $d) {
        array_push($output, ['label' => $d['judul']]);
      }
    }

    echo json_encode($output);
  }

  function addNewArtikel($id, $idUser, $judul, $isi_gambar, $tag, $link_video, $isi_artikel, $tgl_post, $status)
  {
    $data = array('id_artikel' => $id, 'id_user' => $idUser, 'judul' => $judul, 'isi_gambar' => $isi_gambar, 'tag' => $tag, 'link_video' => $link_video, 'isi_artikel' => $isi_artikel, 'tgl_post' => $tgl_post, 'status' => $status);
    return $this->db->insert('artikel', $data);
  }

  function editArtikel($id, $judul, $isi_gambar, $tag, $link_video, $isi_artikel, $tgl_post, $status)
  {
    $data = array('id_artikel' => $id, 'judul' => $judul, 'isi_gambar' => $isi_gambar, 'tag' => $tag, 'link_video' => $link_video, 'isi_artikel' => $isi_artikel, 'tgl_post' => $tgl_post, 'status' => $status);
    return $this->db->update('artikel', $data, array('id_artikel' => $id));
  }

  function changeStatus($id, $catatan, $status)
  {
    $data = array('catatan' => $catatan, 'status' => $status);
    return $this->db->update('artikel', $data, array('id_artikel' => $id));
  }

  function delete($id)
  {
    $path = "./images/" . $id;
    $result = $this->db->delete('artikel', array('id_artikel' => $id));
    delete_files($path, TRUE);
    rmdir($path);
    return $result;
  }
}
