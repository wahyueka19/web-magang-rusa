<?php
class web_model extends CI_Model
{
  function get_artikel($limit, $start, $filter, $search)
  {
    if ($search && $filter !== NULL) {
      $array = array('status' => $filter, 'judul' => $search);
      $this->db->like($array);
    } else if ($search || $filter !== NULL) {
      $array = array('status' => $filter, 'judul' => $search);
      $this->db->like($array);
    }
    $this->db->join('user b', 'b.Email=a.id_user', 'left');
    $this->db->join('person c', 'b.PersonKey=c.PersonKey', 'left');
    $this->db->order_by('tgl_post', 'DESC');
    return $this->db->get('artikel a',  $limit, $start)->result_array();
  }

  function countAllArtikel($filter, $search)
  {
    if ($search && $filter !== NULL) {
      $array = array('status' => $filter, 'judul' => $search);
      $this->db->like($array);
    } else if ($search || $filter !== NULL) {
      $array = array('status' => $filter, 'judul' => $search);
      $this->db->like($array);
    }
    return $this->db->get('artikel')->num_rows();
  }

  function suggestArtikel()
  {
    $this->db->like('status', 'Disetujui');
    $this->db->order_by('id_artikel', 'asc');
    return $this->db->get('artikel', 3)->result_array();
  }

  function get_artikelById($id)
  {
    $this->db->join('user b', 'b.Email=a.id_user', 'left');
    $this->db->join('person c', 'b.PersonKey=c.PersonKey', 'left');
    return $this->db->get_where('artikel a', ['id_artikel' => $id])->result_array();
  }

  function countAllKomen($idAr)
  {
    return $this->db->get_where('komentar', ['id_post' => $idAr])->num_rows();
  }

  function komen($id, $artikel, $akun, $komen)
  {
    $data = array('id_komen' => $id, 'id_post' => $artikel, 'id_user' => $akun, 'isi_komen' => $komen);
    $result = $this->db->insert('komentar', $data);
    if ($result) {
      redirect('home/artikelbyid/' . $artikel);
    }
  }

  function getKomen($id)
  {
    $this->db->join('artikel d', 'd.id_artikel=a.id_post', 'left');
    $this->db->join('user b', 'b.Email=a.id_user', 'left');
    $this->db->join('person c', 'b.PersonKey=c.PersonKey', 'left');
    return $this->db->get_where('komentar a', ['id_post' => $id])->result_array();
  }

  function delKomen($artikel, $idkomen)
  {
    $result = $this->db->delete('komentar', array('id_komen' => $idkomen));
    if ($result) {
      redirect('home/artikelbyid/' . $artikel);
    }
  }

  function ajaxArtikel($keyword)
  {
    $this->db->select('judul');
    $this->db->from('artikel');
    $this->db->like('judul', $keyword);
    $this->db->where('status', 'Disetujui');

    $data = $this->db->get()->result_array();

    $output = array();

    if ($data) {
      foreach ($data as $d) {
        array_push($output, ['label' => $d['judul']]);
      }
    }

    echo json_encode($output);
  }

  public function tema($tema){
    if(!empty($tema)){
      $active = 1;
      $remove = 0;

      $this->db->set('active', $active);
      $this->db->where('id', $tema);
      $this->db->update('tema');

      $this->db->set('active', $remove);
      $this->db->where('id !=', $tema);
      $this->db->update('tema');

      $query = $this->db->get_where('tema', ['id' => $tema])->result_array();
      foreach ($query as $row) {
              $header = "style = background-color:" . $row["header"] . ";color:" . $row["color"] . ";";
              $footer = "style = background-color:" . $row["footer"] . ";color:" . $row["color"] . ";";
          };
      $data = array(
          'header' => $header,
          'footer' => $footer
        );
    } else {
      $data = array(
          'header' => 'style = background-color:#b2a4ff;color:white;',
          'footer' => 'style = background-color:#9d92df;color:white;'
        );
    };
      return $data;
    }

  public function curTema($active){
      $query = $this->db->get_where('tema', ['active' => $active])->result_array();
      foreach ($query as $row) {
              $id = $row["id"];
              $header = "style = background-color:" . $row["header"] . ";";
              if($row["color"] == 'white'){
                $color = "navbar-dark";
              } elseif ($row["color"] == 'black'){
                $color = "navbar-light";
              }
              $footer = "style = background-color:" . $row["footer"] . ";";
          };
      $data = array(
          'tema' => $id,
          'header' => $header,
          'color' => $color,
          'footer' => $footer
        );
      return $data;
  } 

  function countAllChat()
  {
    return $this->db->get('chatbot')->num_rows();
  }

  function chatbot($id, $chat){
    $tanya = $this->db->escape_str($chat);
    $tempChat = 'Untuk info lebih lanjut silahkan hubungi nomor berikut <a href="https://wa.me/6285225014202" target="_blank" class="clear">085225014202</a>. Terimakasih';
    $this->db->select('jawab');
    $this->db->like('tanya',$tanya);
    $query = $this->db->get('chatbot');
    if($query->num_rows() > 0){
        foreach ($query->result() as $row) {
          $replay = $row->jawab;
        }
        if(!$replay){
          print $tempChat ;
        } else{
          echo $replay;
        }
    } else {
      $this->db->insert('chatbot', ['id'=> $id, 'tanya' => $chat]);
      print $tempChat;
    }
  }
}
