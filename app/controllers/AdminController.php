<?php

class AdminController extends Controller {

    public function dashboard(): void {
        $this->requireAdmin();

        $db = Database::getInstance()->getConnection();

        $stats = [
            'chapters'  => $db->query("SELECT COUNT(*) FROM chapters")->fetchColumn(),
            'tracks'    => $db->query("SELECT COUNT(*) FROM tracks")->fetchColumn(),
            'users'     => $db->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn(),
            'guestbook' => $db->query("SELECT COUNT(*) FROM guestbook")->fetchColumn(),
        ];

        // Chapter terbaru
        $chapters = $db->query(
            "SELECT id_chapter, judul, urutan, is_active, tema_warna,
                    (SELECT COUNT(*) FROM tracks WHERE id_chapter = c.id_chapter) AS total_tracks
             FROM chapters c ORDER BY urutan ASC"
        )->fetchAll();

        // User terbaru
        $recentUsers = $db->query(
            "SELECT nama, email, role, dibuat_pada FROM users ORDER BY dibuat_pada DESC LIMIT 5"
        )->fetchAll();

        $this->view('admin/dashboard', [
            'pageTitle'   => 'Dashboard',
            'activeNav'   => 'dashboard',
            'stats'       => $stats,
            'chapters'    => $chapters,
            'recentUsers' => $recentUsers,
        ]);
    }
}