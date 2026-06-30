<?php

class AdminChapterController extends Controller {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index(): void {
        $this->requireAdmin();

        $chapters = $this->db->query(
            "SELECT c.*,
                    (SELECT COUNT(*) FROM tracks WHERE id_chapter = c.id_chapter) AS total_tracks,
                    (SELECT COUNT(*) FROM milestones WHERE id_chapter = c.id_chapter) AS total_milestones
             FROM chapters c ORDER BY urutan ASC"
        )->fetchAll();

        $this->view('admin/chapters/index', [
            'pageTitle' => 'Chapters',
            'activeNav' => 'chapters',
            'chapters'  => $chapters,
            'breadcrumb'=> [['label' => 'Chapters']],
        ]);
    }

    public function create(): void {
        $this->requireAdmin();
        $this->view('admin/chapters/form', [
            'pageTitle'  => 'Tambah Chapter',
            'activeNav'  => 'chapters',
            'chapter'    => null,
            'breadcrumb' => [
                ['label' => 'Chapters', 'url' => url('admin/chapters')],
                ['label' => 'Tambah'],
            ],
        ]);
    }

    public function store(): void {
        $this->requireAdmin();

        $judul      = trim($_POST['judul'] ?? '');
        $slug       = trim($_POST['slug'] ?? '');
        $deskripsi  = trim($_POST['deskripsi'] ?? '');
        $temaWarna  = trim($_POST['tema_warna'] ?? '#4A90B8');
        $dekorasi   = trim($_POST['dekorasi'] ?? 'none');
        $urutan     = (int)($_POST['urutan'] ?? 1);
        $isActive   = isset($_POST['is_active']) ? 1 : 0;

        if (empty($judul) || empty($slug)) {
            Session::flash('admin_error', 'Judul dan slug wajib diisi.');
            $this->redirect('admin/chapters/create');
            return;
        }

        // Auto-generate slug dari judul kalau kosong
        if (empty($slug)) {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $judul));
        }

        $stmt = $this->db->prepare(
            "INSERT INTO chapters (judul, slug, deskripsi, tema_warna, dekorasi, urutan, is_active)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$judul, $slug, $deskripsi, $temaWarna, $dekorasi, $urutan, $isActive]);

        Session::flash('admin_success', "Chapter \"$judul\" berhasil ditambahkan.");
        $this->redirect('admin/chapters');
    }

    public function edit(array $params): void {
        $this->requireAdmin();
        $id      = (int)($params['id'] ?? 0);
        $chapter = $this->findChapter($id);
        if (!$chapter) { $this->redirect('admin/chapters'); return; }

        $this->view('admin/chapters/form', [
            'pageTitle'  => 'Edit Chapter',
            'activeNav'  => 'chapters',
            'chapter'    => $chapter,
            'breadcrumb' => [
                ['label' => 'Chapters', 'url' => url('admin/chapters')],
                ['label' => htmlspecialchars($chapter['judul'])],
            ],
        ]);
    }

    public function update(array $params): void {
        $this->requireAdmin();
        $id      = (int)($params['id'] ?? 0);
        $chapter = $this->findChapter($id);
        if (!$chapter) { $this->redirect('admin/chapters'); return; }

        $judul     = trim($_POST['judul'] ?? '');
        $slug      = trim($_POST['slug'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $temaWarna = trim($_POST['tema_warna'] ?? '#4A90B8');
        $dekorasi  = trim($_POST['dekorasi'] ?? 'none');
        $urutan    = (int)($_POST['urutan'] ?? 1);
        $isActive  = isset($_POST['is_active']) ? 1 : 0;

        $stmt = $this->db->prepare(
            "UPDATE chapters SET judul=?, slug=?, deskripsi=?, tema_warna=?, dekorasi=?, urutan=?, is_active=?
             WHERE id_chapter=?"
        );
        $stmt->execute([$judul, $slug, $deskripsi, $temaWarna, $dekorasi, $urutan, $isActive, $id]);

        Session::flash('admin_success', "Chapter berhasil diperbarui.");
        $this->redirect('admin/chapters');
    }

    public function delete(array $params): void {
        $this->requireAdmin();
        $id = (int)($params['id'] ?? 0);

        $stmt = $this->db->prepare("DELETE FROM chapters WHERE id_chapter = ?");
        $stmt->execute([$id]);

        Session::flash('admin_success', 'Chapter berhasil dihapus.');
        $this->redirect('admin/chapters');
    }

    public function toggle(array $params): void {
        $this->requireAdmin();
        $id      = (int)($params['id'] ?? 0);
        $chapter = $this->findChapter($id);
        if (!$chapter) { $this->redirect('admin/chapters'); return; }

        $stmt = $this->db->prepare("UPDATE chapters SET is_active = ? WHERE id_chapter = ?");
        $stmt->execute([$chapter['is_active'] ? 0 : 1, $id]);

        $status = $chapter['is_active'] ? 'dinonaktifkan' : 'diaktifkan';
        Session::flash('admin_success', "Chapter berhasil $status.");
        $this->redirect('admin/chapters');
    }

    private function findChapter(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM chapters WHERE id_chapter = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}