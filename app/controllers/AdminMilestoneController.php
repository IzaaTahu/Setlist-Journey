<?php
class AdminMilestoneController extends Controller {

    private PDO $db;
    public function __construct() { $this->db = Database::getInstance()->getConnection(); }

    public function index(array $params): void {
        $this->requireAdmin();
        $chapterId = (int)($params['id'] ?? 0);
        $chapter   = $this->findChapter($chapterId);
        if (!$chapter) { $this->redirect('admin/chapters'); return; }

        $stmt = $this->db->prepare("SELECT * FROM milestones WHERE id_chapter = ? ORDER BY setelah_track ASC");
        $stmt->execute([$chapterId]);
        $milestones = $stmt->fetchAll();

        // Total tracks untuk dropdown setelah_track
        $stmtT = $this->db->prepare("SELECT id_track, urutan, judul_lagu FROM tracks WHERE id_chapter = ? ORDER BY urutan ASC");
        $stmtT->execute([$chapterId]);
        $tracks = $stmtT->fetchAll();

        $this->view('admin/milestones/index', [
            'pageTitle'  => 'Milestones — ' . $chapter['judul'],
            'activeNav'  => 'chapters',
            'chapter'    => $chapter,
            'milestones' => $milestones,
            'tracks'     => $tracks,
            'breadcrumb' => [
                ['label' => 'Chapters', 'url' => url('admin/chapters')],
                ['label' => htmlspecialchars($chapter['judul']), 'url' => url('admin/chapters/' . $chapterId . '/tracks')],
                ['label' => 'Milestones'],
            ],
        ]);
    }

    public function store(array $params): void {
        $this->requireAdmin();
        $chapterId   = (int)($params['id'] ?? 0);
        $setelah     = (int)($_POST['setelah_track'] ?? 0);
        $judul       = trim($_POST['judul'] ?? '');
        $pesan       = trim($_POST['pesan'] ?? '');
        $foto        = trim($_POST['foto'] ?? '') ?: null;

        $stmt = $this->db->prepare(
            "INSERT INTO milestones (id_chapter, setelah_track, judul, pesan, foto) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$chapterId, $setelah, $judul, $pesan, $foto]);

        Session::flash('admin_success', 'Milestone berhasil ditambahkan.');
        $this->redirect("admin/chapters/$chapterId/milestones");
    }

    public function update(array $params): void {
        $this->requireAdmin();
        $id      = (int)($params['id'] ?? 0);
        $row     = $this->db->prepare("SELECT id_chapter FROM milestones WHERE id_milestone = ?")->execute([$id]);
        $ms      = $this->db->query("SELECT id_chapter FROM milestones WHERE id_milestone = $id")->fetch();

        $stmt = $this->db->prepare(
            "UPDATE milestones SET setelah_track=?, judul=?, pesan=?, foto=? WHERE id_milestone=?"
        );
        $stmt->execute([
            (int)($_POST['setelah_track'] ?? 0),
            trim($_POST['judul'] ?? ''),
            trim($_POST['pesan'] ?? ''),
            trim($_POST['foto'] ?? '') ?: null,
            $id,
        ]);

        Session::flash('admin_success', 'Milestone berhasil diperbarui.');
        $this->redirect("admin/chapters/{$ms['id_chapter']}/milestones");
    }

    public function delete(array $params): void {
        $this->requireAdmin();
        $id  = (int)($params['id'] ?? 0);
        $ms  = $this->db->query("SELECT id_chapter FROM milestones WHERE id_milestone = $id")->fetch();

        $this->db->prepare("DELETE FROM milestones WHERE id_milestone = ?")->execute([$id]);
        Session::flash('admin_success', 'Milestone berhasil dihapus.');
        $this->redirect("admin/chapters/{$ms['id_chapter']}/milestones");
    }

    private function findChapter(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM chapters WHERE id_chapter = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}