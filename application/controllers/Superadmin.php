<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->load->model('web_model');
    $data1 = $this->web_model->curTema(1);
    $data2 = array(
      // 'judul' => 'Ditinjau',
      'aktif' => 'active'
    );
    $data = array_merge($data1, $data2);
    $this->load->view('template/superadmin/header.php', $data);
    $this->load->view('content/superadmin/index.php');
    $this->load->view('template/superadmin/footer.php');
  }
}


/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */