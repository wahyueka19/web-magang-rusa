<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->model('artikelModel');
    $this->load->model('personModel');
    $this->load->model('userModel');
    $this->load->model('joinModel');
    $this->load->model('temaModel');
  }

  function account($username)
  {
    $user = str_replace("%20", " ", $username);
    if (isset($_SESSION['username']) && $_SESSION['username'] == $user) {

      $tipeAkun = $_SESSION['tipeAkun'];
      $idAkun = $_SESSION['idAkun'];

      $menuBaseFromUriSegment4 = $this->uri->segment(4);
      $dataHeader = array(
        'username' => $user,
        'idAkun' => $idAkun,
        'tipeAkun' => $tipeAkun,
        'aktif' => 'active',
        'url4' => $this->uri->segment(4),
        'url5' => $this->uri->segment(5),
        'url6' => $this->uri->segment(6),
      );

      $this->load->view('template/user/header.php', $dataHeader);
      switch ($tipeAkun) {
        case 'User':
          if ($menuBaseFromUriSegment4 == "") {
            $this->dashboard($dataHeader);
          } else if ($menuBaseFromUriSegment4) {
            $this->$menuBaseFromUriSegment4($dataHeader);
          }
          break;
        case 'Admin':
          if ($menuBaseFromUriSegment4 == "") {
            $this->artikel($dataHeader);
          } else if ($menuBaseFromUriSegment4) {
            $this->$menuBaseFromUriSegment4($dataHeader);
          }
          break;
        case 'Super Admin':
          if ($menuBaseFromUriSegment4 == "") {
            $this->tema($dataHeader);
          } else if ($menuBaseFromUriSegment4) {
            $this->$menuBaseFromUriSegment4($dataHeader);
          }
          break;
      };
    } else {
      if (!$username) {
        redirect("/");
      } else {
        redirect("cms/account/" . $_SESSION['username']);
      }
    }
    $this->load->view('template/user/footer.php');
  }

  function tema()
  {
    $data1 = $this->currentTheme(1);
    $data2 = array(
      'aktif' => 'active'
    );
    $this->load->view('content/menu/tema.php',  array_merge($data1, $data2));
  }

  function terapkanTema()
  {
    $idTema = $this->input->post('tema');
    $this->theme($idTema);
    redirect('home');
  }

  function dashboard($dataHeader)
  {
    $tinjau = "Ditinjau";
    $setuju = "Disetujui";
    $tolak = "Ditolak";
    $data = array(
      'ditinjau' => $this->artikelModel->getArtikelByStatus($tinjau, $dataHeader['idAkun'])->num_rows(),
      'disetujui' => $this->artikelModel->getArtikelByStatus($setuju, $dataHeader['idAkun'])->num_rows(),
      'ditolak' => $this->artikelModel->getArtikelByStatus($tolak, $dataHeader['idAkun'])->num_rows(),
      'grafikdtj' => $this->artikelModel->grafik($tinjau, $dataHeader['idAkun']),
      'grafikdst' => $this->artikelModel->grafik($setuju, $dataHeader['idAkun']),
      'grafikdtlk' => $this->artikelModel->grafik($tolak, $dataHeader['idAkun']),
      'judul' => 'Dashboard',
    );
    $this->load->view('content/menu/dashboard.php', array_merge($data, $dataHeader));
    return;
  }

  function artikel($dataHeader)
  {
    $target = "judul";
    $filterBy = "status";
    $search = "";
    $filter = "";

    if (isset($_POST['submit'])) {
      $search = $this->input->post('cari');
      $filter = $this->input->post('filter');
      $this->session->set_userdata(array("cari" => $search, "filter" => $filter));
    } else if ($this->session->userdata('cari') != NULL || $this->session->userdata('filter')) {
      $search = $this->session->userdata('cari');
      $filter = $this->session->userdata('filter');
    }

    $offset = $dataHeader['url5'];
    $per_page = 4;
    $baseUrl = base_url('index.php/cms/account/' . $dataHeader['username'] . '/artikel');

    switch ($dataHeader['tipeAkun']) {
      case 'User':
        $idUser = $dataHeader['idAkun'];
        $getData = $this->artikelModel->getAllArtikelByUser($idUser, $target, $filterBy, $search, $filter, $per_page, $offset);
        $totalRow = $this->artikelModel->getAllArtikelByUser($idUser, $target, $filterBy, $search, $filter)->num_rows();
        break;
      case 'Admin';
        $getData = $this->artikelModel->getAllArtikel($target, $filterBy, $search, $filter, $per_page, $offset);
        $totalRow = $this->artikelModel->getAllArtikel($target, $filterBy, $search, $filter)->num_rows();
        break;
    }

    $data = array(
      'start' => $offset,
      'cari' => $search,
      'filter' => $filter,
      'judul' => 'Artikel',
      'uri5' => $dataHeader['url5'],
      'uri6' => $dataHeader['url6'],
      'artikel' => $getData->result_array(),
    );

    $this->pagination($per_page, $baseUrl, $totalRow);
    if ($dataHeader['url5'] && !$dataHeader['url6']) {
      $this->tinjauOrNo($dataHeader['url5'], $data, $dataHeader);
    } else {
      $this->tinjauOrNo($dataHeader['url6'], $data, $dataHeader);
    }
    return;
  }

  function buatArtikel($dataHeader)
  {
    $data = array(
      'heading' => 'Buat Artikel',
      'uri4' => $dataHeader['url4'],
      'uri5' => $dataHeader['url5'],
      'uri6' => $dataHeader['url6'],
    );
    $this->load->view('content/menu/detailArtikel.php', $data);
  }

  function daftarAkun($dataHeader)
  {
    $target = "Nama";
    $filterBy = "RoleId";
    $search = "";
    $filter = "";

    if (isset($_POST['submit'])) {
      $search = $this->input->post('cari');
      $filter = $this->input->post('filter');
      $this->session->set_userdata(array("cariAkun" => $search, "filterAkun" => $filter));
    } else if ($this->session->userdata('cariAkun') != NULL || $this->session->userdata('filterAkun')) {
      $search = $this->session->userdata('cariAkun');
      $filter = $this->session->userdata('filterAkun');
    }

    $offset = $dataHeader['url5'];
    $per_page = 4;
    $baseUrl = base_url('index.php/cms/account/' . $dataHeader['username'] . '/daftarAkun');

    $getData = $this->joinModel->getAllJoinedUser($target, $filterBy, $search, $filter, $per_page, $offset);
    $totalRow = $this->joinModel->getAllJoinedUser($target, $filterBy, $search, $filter)->num_rows();

    $data = array(
      'start' => $offset,
      'cari' => $search,
      'filter' => $filter,
      'judul' => 'Artikel',
      'akun' => $getData->result_array(),
    );

    $this->pagination($per_page, $baseUrl, $totalRow);
    $this->load->view('content/menu/daftarAkun.php', array_merge($data, $dataHeader));
    return;
  }

  function save($dataHeader)
  {
    $statusMsg = 'ditambahkan';
    $url5 = $dataHeader['url5'];
    $userUrl = $dataHeader['username'];

    switch ($url5) {
      case 'artikel':
        $counter = $this->artikelModel->getAllArtikel()->num_rows();
        $code = 'A';
        break;
      case 'akun':
        $counter = $this->personModel->getAllPerson()->num_rows();
        $code = 'P';
        break;
    }

    $getId = $counter;
    $id = $this->idMaker($getId, $code);

    switch ($url5) {
      case 'artikel':
        $msg = 'Artikel';

        $fileName = $_FILES['sampul']['name'];
        $targetDir = "./images/" . $id;
        if (!is_dir($targetDir)) {
          mkdir($targetDir, 0777);
        }
        $config = $this->configFile($fileName, $targetDir);
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("sampul")) {
          $data['error'] = $this->upload->display_errors();
        }

        $rules = [
          [
            'field' => 'judul',
            'label' => 'Judul',
            'rules' => 'required'
          ],
          [
            'field' => 'sampul',
            'label' => 'Sampul',
          ],
          [
            'field' => 'tag',
            'label' => 'Tag',
          ],
          [
            'field' => 'link',
            'label' => 'Link',
          ],
          [
            'field' => 'artikel',
            'label' => 'Artikel',
            'rules' => 'required'
          ],
        ];

        if (empty($fileName)) {
          $this->form_validation->set_rules('sampul', 'Sampul', 'required');
        }
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
          $data = array(
            'uri4' => $dataHeader['url4'],
            'filename' => $fileName,
            'heading' => 'Buat Artikel',
          );
          $this->load->view('content/menu/detailArtikel.php', $data);
        } else {
          $idUser = $dataHeader['idAkun'];
          $judul = $this->input->post('judul');
          $isi_gambar = $this->upload->data('file_name');
          $tag = $this->input->post('tag');
          $link_video = $this->input->post('link_video');
          $isi_artikel = $this->input->post('artikel');
          $tgl_post = date('Y-m-d H:i:s');
          $status = 'Ditinjau';

          $savingArtikel = $this->artikelModel->addNewArtikel($id, $idUser, $judul, $isi_gambar, $tag, $link_video, $isi_artikel, $tgl_post, $status);

          $this->toastNotification($savingArtikel, "kosong", $msg, $statusMsg);
          redirect("cms/account/$userUrl/artikel");
        }
        break;
      case 'akun':
        $msg = 'Akun';

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $no_hp = $this->input->post('no_hp');
        $tipe_akun = $this->input->post('tipe_akun');

        $savingPerson = $this->personModel->addNewPerson($id, $username, $tgl_lahir, $no_hp);
        $savingUser = $this->userModel->addNewUser($email, $id, $password, $tipe_akun);

        $this->toastNotification($savingPerson, $savingUser, $msg, $statusMsg);
        redirect("cms/account/$userUrl/daftarAkun");
        break;
    }
  }

  function sunting($dataHeader)
  {
    $result = $this->artikelModel->getArtikelById($dataHeader['url5']);
    if ($result->num_rows() > 0) {
      $i = $result->row_array();
      $data = array(
        'id_artikel'  => $i['id_artikel'],
        'judul'       => $i['judul'],
        'sampul'      => $i['isi_gambar'],
        'tag'         => $i['tag'],
        'link'        => $i['link_video'],
        'artikel'     => $i['isi_artikel'],
        'tgl_post'    => $i['tgl_post'],
        'status'      => $i['status'],
        'heading' => 'Sunting Artikel',
        'uri4' => $dataHeader['url4'],
        'uri5' => $dataHeader['url5'],
        'uri6' => $dataHeader['url6'],
      );

      $this->load->view('content/menu/detailArtikel.php', $data);
    } else {
      echo "Data not Found";
    }
  }

  function update($dataHeader)
  {
    $statusMsg = 'disunting';
    $url5 = $dataHeader['url5'];
    $userUrl = $dataHeader['username'];
    $id = $dataHeader['url6'];
    switch ($url5) {
      case 'artikel':
        $msg = 'Artikel';

        $fileName = $_FILES['sampul']['name'];
        $oldname = $this->artikelModel->getSampulById($id);
        if ($oldname->num_rows() > 0) {
          $i = $oldname->row_array();
          $data = array(
            'sampul'      => $i['isi_gambar']
          );
          $oldname = $data['sampul'];
        };
        $targetDir = "./images/" . $id;
        $config = $this->configFile($fileName, $targetDir);

        $rules = [
          [
            'field' => 'judul',
            'label' => 'Judul',
            'rules' => 'required'
          ],
          [
            'field' => 'sampul',
            'label' => 'Sampul',
          ],
          [
            'field' => 'tag',
            'label' => 'Tag',
          ],
          [
            'field' => 'link',
            'label' => 'Link',
          ],
          [
            'field' => 'artikel',
            'label' => 'Artikel',
            'rules' => 'required'
          ],
        ];

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
          $data = array(
            'uri4' => $dataHeader['url4'],
            'filename' => $fileName,
            'heading' => 'Sunting Artikel',
            'id_artikel' => $id,
            'oldname' => $oldname,
          );
          $this->load->view('content/menu/detailArtikel.php', $data);
        } else {

          $judul = $this->input->post('judul');
          $isi_gambar = $oldname;
          $tag = $this->input->post('tag');
          $link_video = $this->input->post('link_video');
          $isi_artikel = $this->input->post('artikel');
          $tgl_post = date('Y-m-d H:i:s');
          $status = 'Ditinjau';

          if ($fileName != "") {

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('sampul')) {
              $error = array('error' => $this->upload->display_errors());
              $this->load->view('content/menu/suntingartikel.php', $error);
            } else {
              unlink($targetDir . "/" . $oldname);
              $update = $this->artikelModel->editArtikel($id, $judul, $isi_gambar, $tag, $link_video, $isi_artikel, $tgl_post, $status);
              $this->toastNotification($update, "kosong", $msg, $statusMsg);
              redirect("cms/account/$userUrl/artikel");
            }
          } else {
            $update = $this->artikelModel->editArtikel($id, $judul, $isi_gambar, $tag, $link_video, $isi_artikel, $tgl_post, $status);
            $this->toastNotification($update, "kosong", $msg, $statusMsg);
            redirect("cms/account/$userUrl/artikel");
          }
        }
        break;
      case 'akun':
        $msg = 'Akun';

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $no_hp = $this->input->post('no_hp');
        $tipe_akun = $this->input->post('tipe_akun');
        $savingPerson = $this->personModel->editPerson($id, $username, $tgl_lahir, $no_hp);
        $savingUser = $this->userModel->editUser($email, $id, $password, $tipe_akun);

        $this->toastNotification($savingPerson, $savingUser, $msg, $statusMsg);
        redirect("cms/account/$userUrl/daftarAkun");
        break;
    }
  }

  function delete($dataHeader)
  {
    $statusMsg = 'dihapus';
    $url5 = $dataHeader['url5'];
    $userUrl = $dataHeader['username'];
    $id = $dataHeader['url6'];
    switch ($url5) {
      case 'artikel':
        $msg = 'Artikel';
        $delete = $this->artikelModel->delete($id);
        $this->toastNotification($delete, "kosong", $msg, $statusMsg);
        redirect("cms/account/$userUrl/artikel");
        break;
      case 'akun':
        $msg = 'Akun';
        $delete = $this->personModel->delete($id);
        $this->toastNotification($delete, "kosong", $msg, $statusMsg);
        redirect("cms/account/$userUrl/daftarAkun");
        break;
    }
  }

  function statusChange($dataHeader)
  {
    $msg = 'Status';
    $statusMsg = 'diubah';
    $userUrl = $dataHeader['username'];
    $id = $dataHeader['url5'];
    $status = $dataHeader['url6'];

    $catatan = $this->input->post('catatan');

    $changeStatus = $this->artikelModel->changeStatus($id, $catatan, $status);
    $this->toastNotification($changeStatus, "kosong", $msg, $statusMsg);
    redirect("cms/account/$userUrl/artikel");
  }

  function tinjauOrNo($id, $data, $dataHeader)
  {
    $result = $this->joinModel->getJoinedArtikelById($id)->result_array();
    if ($result) {
      $data['artikel'] = $this->joinModel->getJoinedArtikelById($id)->result_array();
      $this->load->view('content/menu/tinjau.php', array_merge($data, $dataHeader));
    } else {
      $this->load->view('content/menu/artikel.php', array_merge($data, $dataHeader));
    }
    return;
  }

  function pagination($per_page, $baseUrl, $totalRow)
  {
    $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul></nav>';

    $config['first_link'] = 'Pertama';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';

    $config['last_link'] = 'Terakhir';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';

    $config['next_link'] = 'Selanjutnya';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = 'Kembali';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';

    $config['attributes'] = array('class' => 'page-link');

    // PAGINATION CONFIG
    $config['base_url'] = $baseUrl;
    $config['total_rows'] = $totalRow;
    $config['per_page'] = $per_page;

    // initialize
    $this->pagination->initialize($config);
  }

  function PDF()
  {
    $_REQUEST['hostname'] = $this->db->hostname;
    $_REQUEST['username'] = $this->db->username;
    $_REQUEST['password'] = $this->db->password;
    $_REQUEST['db'] = $this->db->database;

    $this->load->library('Pdf');
  }

  function autoComplete($link)
  {
    if ($link == 'artikel') {
      $tipeAkun = $_SESSION['tipeAkun'];
      $idAkun = $_SESSION['idAkun'];
      switch ($tipeAkun) {
        case 'User':
          $this->artikelModel->ajaxArtikel($this->input->get('query'), $idAkun);
          break;
        case 'Admin':
          $this->artikelModel->ajaxArtikel($this->input->get('query'));
          break;
      }
    } else if ($link == 'akun') {
      $this->personModel->ajaxAkun($this->input->get('query'));
    }
  }

  function idMaker($getId, $code)
  {
    $incId = $getId + 1;
    $preId = sprintf("%03d", $incId);
    $id = $code . date('ymd') . $preId;
    return $id;
  }

  function configFile($fileName, $targetDir)
  {
    $config = array(
      'upload_path' => $targetDir,
      'allowed_types' => 'jpg|jpeg|png',
      'file_name' => $fileName
    );
    return $config;
  }

  function toastNotification($for, $for2, $msg, $statusMsg)
  {
    if (empty($for) || empty($for2)) {
      $status = 'bg-danger';
      $this->session->set_flashdata('toast', $msg . ' gagal ' . $statusMsg);
      $this->session->set_flashdata('bg-color', $status);
    } else {
      $status = 'bg-success';
      $this->session->set_flashdata('toast', $msg . ' berhasil ' . $statusMsg);
      $this->session->set_flashdata('bg-color', $status);
    }
  }

  function summernoteDeleteImage()
  {
    $src = $this->input->post('src');
    $file_name = str_replace(base_url(), '', $src);
    if (unlink($file_name)) {
      echo 'File Delete Successfully';
    }
  }

  function summernoteUploadImage($idArtikel = null)
  {
    $code = 'A';
    $getId = $this->artikelModel->getAllArtikel()->num_rows();

    if ($idArtikel !== null) {
      $id = $idArtikel;
    } else {
      $id = $this->idMaker($getId, $code);
    }

    $fileName = $_FILES["image"]["name"];
    $targetDir = "./images/" . $id;
    if (!is_dir($targetDir)) {
      mkdir($targetDir, 0777);
    }
    if ($fileName) {
      $config = $this->configFile($fileName, $targetDir);
      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('image')) {
        $this->upload->display_errors();
        return FALSE;
      } else {
        $data = $this->upload->data();
        //Compress Image
        $config['image_library'] = 'gd2';
        $config['source_image'] = $targetDir . "/" . $data['file_name'];
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = '60%';
        $config['width'] = 800;
        $config['height'] = 800;
        $config['new_image'] = $targetDir . "/" . $data['file_name'];
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        echo base_url() . $targetDir . "/" . $data['file_name'];
      }
    }
  }

  function currentTheme($active)
  {
    $query = $this->temaModel->currentTheme($active);
    foreach ($query as $row) {
      $id = $row["id"];
      $header = "style = background-color:" . $row["header"] . ";";
      if ($row["color"] == 'white') {
        $color = "navbar-dark";
      } elseif ($row["color"] == 'black') {
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

  function theme($idTema)
  {
    if (!empty($idTema)) {
      $active = 1;
      $remove = 0;
      $query = $this->temaModel->getTema($idTema, $active, $remove)->result_array();
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
}
