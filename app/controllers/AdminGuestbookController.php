<?php
class AdminGuestbookController extends Controller {

    private PDO $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }

    public function index(): void {
        $this->requireAdmin();

        $entries = $this->db->query(
            "SELECT g.*, c.judul AS chapter_judul, c.slug AS chapter_slug,
                    u.nama AS nama_user
             FROM guestbook g
             JOIN chapters c ON g.id_chapter = c.id_chapter
             LEFT JOIN users u ON g.id_user = u.id_user
             ORDER BY g.dibuat_pada DESC"
        )->fetchAll();

        $this->view('admin/guestbook/index', [
            'pageTitle'  => 'Guestbook',
            'activeNav'  => 'guestbook',
            'entries'    => $entries,
            'breadcrumb' => [['label' => 'Guestbook']],
        ]);
    }

    public function delete(array $params): void {
        $this->requireAdmin();
        $id = (int)($params['id'] ?? 0);

        $this->db->prepare("DELETE FROM guestbook WHERE id_pesan = ?")->execute([$id]);
        Session::flash('admin_success', 'Pesan berhasil dihapus.');
        $this->redirect('admin/guestbook');
    }
}