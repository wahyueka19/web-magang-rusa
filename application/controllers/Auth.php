<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('userModel');
        $this->load->model('personModel');
    }

    function redirectByUsername()
    {
        $username = $_SESSION['username'];
        redirect('/cms/account/' . $username);
    }

    function signup()
    {
        $rules = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|is_unique[user.Username]',
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|is_unique[user.Email]',
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
            ],
            [
                'field' => 'confpassword',
                'label' => 'Password confirmation',
                'rules' => 'required|matches[password]',
            ],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'judul' => 'SignUp'
            );
            $this->load->view('template/authview.php', $data);
            $this->load->view('content/signup.php');
        } else {
            $getid = $this->personModel->getAllPerson()->num_rows();
            $incid = $getid + 1;
            $preid = sprintf("%03d", $incid);

            $id = 'P' . date('ymd') . $preid;
            $username = $this->input->post('username', true);
            $password = $this->input->post('confpassword', true);
            $email = $this->input->post('email', true);
            $tgl_lahir = $this->input->post('tgl_lahir', true);
            $no_hp = $this->input->post('no_hp', true);
            $tipe_akun = "User";

            $savingPerson = $this->personModel->addNewPerson($id, $username, $tgl_lahir, $no_hp);
            $savingUser = $this->userModel->addNewUser($email, $id, $password, $tipe_akun);

            if (empty($savingPerson) || empty($savingUser)) {
                $status = 'bg-danger';
                $this->session->set_flashdata('toast', 'Akun gagal ditambahkan');
                $this->session->set_flashdata('bg-color', $status);
                redirect("/signup");
            } else {
                $status = 'bg-success';
                $this->session->set_flashdata('toast', 'Akun berhasil ditambahkan');
                $this->session->set_flashdata('bg-color', $status);
                redirect("/login");
            }
        };
    }

    function valLogin($idArtikel = null)
    {
        $username = $this->input->post('email', true);
        $password = $this->input->post('password', true);

        $val = $this->userModel->getUserByEmailPass($username, $password)->result_array();

        if (empty($val)) {
            $status = "<div class='alert alert-danger text-center mt-n3' role='alert'>Username / password salah</div>";
            $this->session->set_flashdata('invalid', $status);
            redirect('/login');
        } else {
            foreach ($val as $row) {
                $data = array(
                    'username'      => $this->personModel->getUsernameByPersonKey($row['PersonKey'])->row()->Nama,
                    'password'      => $row['Password'],
                    'idAkun'       => $row['Email'],
                    'tipeAkun'     => $row['RoleId']
                );
                $this->session->set_userdata($data);
            }
            if ($idArtikel != null) {
                redirect("home/detailartikel/$idArtikel");
            } else {
                $this->redirectByUsername();
            }
        }
    }

    function logout()
    {
        $session = array('username', 'password', 'idAkun', 'tipeAkun');
        $req = array('hostname', 'username', 'password', 'db');
        unset($_REQUEST[$req]);
        $this->session->unset_userdata($session);
        $this->session->sess_destroy();
        redirect('/');
    }
}
