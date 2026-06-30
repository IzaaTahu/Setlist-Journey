<?php
class AdminUserController extends Controller {

    private PDO $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }

    public function index(): void {
        $this->requireAdmin();

        $this->view('admin/users/index', [
            'pageTitle'  => 'Users',
            'activeNav'  => 'users',
            'users'      => $users,
            'breadcrumb' => [['label' => 'Users']],
        ]);
    }

    public function updateRole(array $params): void {
        $this->requireAdmin();
        $id   = (int)($params['id'] ?? 0);
        $role = $_POST['role'] ?? 'user';

        if (!in_array($role, ['admin', 'user'])) {
            $this->redirect('admin/users');
            return;
        }

        // Jangan ubah role diri sendiri
        if ($id === (int)Session::get('user_id')) {
            Session::flash('admin_error', 'Tidak bisa mengubah role diri sendiri.');
            $this->redirect('admin/users');
            return;
        }

        $stmt = $this->db->prepare("UPDATE users SET role = ? WHERE id_user = ?");
        $stmt->execute([$role, $id]);

        Session::flash('admin_success', 'Role user berhasil diperbarui.');
        $this->redirect('admin/users');
    }

    public function delete(array $params): void {
        $this->requireAdmin();
        $id = (int)($params['id'] ?? 0);

        if ($id === (int)Session::get('user_id')) {
            Session::flash('admin_error', 'Tidak bisa menghapus akun diri sendiri.');
            $this->redirect('admin/users');
            return;
        }

        $this->db->prepare("DELETE FROM users WHERE id_user = ?")->execute([$id]);
        Session::flash('admin_success', 'User berhasil dihapus.');
        $this->redirect('admin/users');
    }
}