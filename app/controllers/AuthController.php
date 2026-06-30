<?php

require_once BASE_PATH . '/app/models/User.php';

class AuthController extends Controller {

    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function loginForm(): void {
        if ($this->isLoggedIn()) {
            $this->redirect('/worldmap');
        }
        $this->view('auth/login', [
            'error' => Session::flash('error'),
        ]);
    }

    public function login(): void {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            Session::flash('error', 'Email dan password wajib diisi.');
            $this->redirect('/login');
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_pengguna'])) {
            Session::flash('error', 'Email atau password salah.');
            $this->redirect('/login');
            return;
        }

        Session::set('user_id',   $user['id_user']);
        Session::set('user_nama', $user['nama']);
        Session::set('user_role', $user['ROLE']);

        $redirect = Session::get('redirect_after_login', '/worldmap');
        Session::remove('redirect_after_login');
        $this->redirect($redirect);
    }

    public function registerForm(): void {
        if ($this->isLoggedIn()) {
            $this->redirect('/worldmap');
        }
        $this->view('auth/register', [
            'error' => Session::flash('error'),
        ]);
    }

    public function register(): void {
        $nama     = trim($_POST['nama'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if (empty($nama) || empty($email) || empty($password)) {
            Session::flash('error', 'Semua kolom wajib diisi.');
            $this->redirect('/register');
            return;
        }

        if ($password !== $confirm) {
            Session::flash('error', 'Password tidak cocok.');
            $this->redirect('/register');
            return;
        }

        if ($this->userModel->findByEmail($email)) {
            Session::flash('error', 'Email sudah terdaftar.');
            $this->redirect('/register');
            return;
        }

        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $this->userModel->create($nama, $email, $hashed);

        Session::flash('error', null);
        $this->redirect('/login');
    }

    public function logout(): void {
        Session::destroy();
        $this->redirect('/');
    }
}
