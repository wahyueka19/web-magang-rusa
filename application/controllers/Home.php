<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('web_model');
		$this->load->model('joinModel');
		$this->load->model('artikelModel');
		$this->load->model('commentModel');
		$this->load->model('chatbotModel');
		$this->load->model('temaModel');
		$this->currentTheme(1);
	}

	public function index()
	{
		$data1 = $this->currentTheme(1);
		$data2 = array(
			'judul' => 'Home',
			'aktif' => 'active',
		);
		$data = array_merge($data1, $data2);
		$this->load->view('template/header.php', $data);
		$this->load->view('content/home.php');
		$this->load->view('template/footer.php', $data);
	}

	public function tentang()
	{
		$data1 = $this->currentTheme(1);
		$data2 = array(
			'judul' => 'Tentang',
			'aktif' => 'active',
		);
		$data = array_merge($data1, $data2);
		$this->load->view('template/header.php', $data);
		$this->load->view('content/tentang.php');
		$this->load->view('template/footer.php', $data);
	}

	public function artikel()
	{
		$target = "judul";
		$filterBy = "status";
		$search = "";
		$filter = "Disetujui";

		if (isset($_POST['submit'])) {
			$search = $this->input->post('cari');
			$this->session->set_userdata(array("homeCari" => $search, "homeFilter" => $filter));
		} else if ($this->session->userdata('homeCari') != NULL || $this->session->userdata('homeFilter')) {
			$search = $this->session->userdata('homeCari');
			$filter = $this->session->userdata('homeFilter');
		}

		$offset = $this->uri->segment(3);
		$per_page = 2;
		$baseUrl = base_url('index.php/home/artikel');
		$totalRow = $this->joinModel->getAllJoinedArtikel($target, $filterBy, $search, $filter)->num_rows();

		$this->pagination($per_page, $baseUrl, $totalRow);

		$data1 = $this->currentTheme(1);
		$data2 = array(
			'judul' => 'Artikel',
			'aktif' => 'active',
			'start' => $offset,
			'artikel' => $this->joinModel->getAllJoinedArtikel($target, $filterBy, $search, $filter, $per_page, $offset)->result_array(),
			'count' => $this->joinModel->getAllJoinedArtikel('judul', 'status', '', 'Disetujui')->num_rows(),
			'suggest' => $this->artikelModel->getAllArtikel($target, $filterBy, '', $filter, 3, 0, 'asc')->result_array(),
			'filter' => $filter,
			'cari' => $search
		);

		$data = array_merge($data1, $data2);

		$this->load->view('template/header.php', $data);
		$this->load->view('content/artikel.php', $data);
		$this->load->view('template/footer.php', $data);
	}

	public function detailartikel($id)
	{
		$data1 = $this->currentTheme(1);
		$data2 = array(
			'judul' => 'Artikel',
			'aktif' => 'active',
			'artikel' => $this->joinModel->getJoinedArtikelById($id)->result_array(),
			'count' => $this->joinModel->getAllJoinedArtikel('judul', 'status', '', 'Disetujui')->num_rows(),
			'suggest' => $this->artikelModel->getAllArtikel('judul', 'status', '', 'Disetujui', 3, 0, 'asc')->result_array(),
			'komen' => $this->commentModel->getCommentById($id)->result_array(),
		);
		$data = array_merge($data1, $data2);

		$this->load->view('template/header.php', $data);
		$this->load->view('content/artikelbyid.php', $data);
		$this->load->view('template/footer.php');
	}

	public function kontak()
	{
		$data1 = $this->currentTheme(1);
		$data2 = array(
			'judul' => 'Hubungi Kami',
			'aktif' => 'active'
		);
		$data = array_merge($data1, $data2);
		$this->load->view('template/header.php', $data);
		$this->load->view('content/kontak.php');
		$this->load->view('template/footerkon.php');
	}

	public function login($idArtikel = null)
	{
		if (!isset($_SESSION['username'])) {
			$data = array(
				'judul' => 'Login'
			);
			if($idArtikel != null){
					$data['idArtikel'] = $idArtikel;
			}
			$this->load->view('template/authview.php', $data);
			$this->load->view('content/login.php', $data);
		} else {
			$tipe_akun = strtolower(strval($_SESSION['tipe_akun']));
			redirect("/" . $tipe_akun);
		}
	}

	public function signup()
	{
		$data = array(
			'judul' => 'SignUp'
		);
		$this->load->view('template/authview.php', $data);
		$this->load->view('content/signup.php');
	}

	public function komen($idAr)
	{
		$getid = $this->commentModel->getCommentById($idAr)->num_rows();
		$incid = $getid + 1;
		$preid = sprintf("%03d", $incid);

		$id = 'K' . $idAr . $preid;
		$akun = $_SESSION['idAkun'];
		$artikel = $idAr;
		$komentar = $this->input->post('komentar');
		$this->commentModel->addComment($id, $artikel, $akun, $komentar);
		$this->detailartikel($artikel);
	}

	function deleteKomen($artikel, $idkomen)
	{
		$this->commentModel->deleteComment($idkomen);
		$this->detailartikel($artikel);
	}

	function autoArtikel()
	{
		$this->artikelModel->ajaxArtikel($this->input->get('query'));
	}

	function form()
	{
		$nama = $this->input->post('name');
		$email = $this->input->post('email');
		$subjek = $this->input->post('subject');
		$pesan = $this->input->post('message');
		$no = 6285225014202;
		$formater = "Pengirim%20:%20$nama%0D%0AEmail%20:%20$email%0D%0APerihal%20:%20$subjek%0D%0A------------------------%0D%0A$pesan";

		redirect('https://wa.me/' . $no . '/?text=' . $formater);
	}

	function chat()
	{
		$getid =  $this->chatbotModel->getAllChat()->num_rows();
		$id = $getid + 1;
		$chat = $this->input->post('text');
		$this->chatbotReply($id, $chat);
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

	function chatbotReply($id, $chat)
	{
		$tempChat = 'Untuk info lebih lanjut silahkan hubungi nomor berikut <a href="https://wa.me/6285225014202" target="_blank" class="clear">085225014202</a>. Terimakasih';
		$query = $this->chatbotModel->getReply($chat);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$replay = $row->jawab;
			}
			if (!$replay) {
				print $tempChat;
			} else {
				echo $replay;
			}
		} else {
			$this->chatbotModel->addChat($id, $chat);
			print $tempChat;
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
}
