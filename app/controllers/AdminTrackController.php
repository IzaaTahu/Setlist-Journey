<?php

class AdminTrackController extends Controller {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index(array $params): void {
        $this->requireAdmin();
        $chapterId = (int)($params['id'] ?? 0);
        $chapter   = $this->findChapter($chapterId);
        if (!$chapter) { $this->redirect('admin/chapters'); return; }

        $tracks = $this->db->prepare(
            "SELECT * FROM tracks WHERE id_chapter = ? ORDER BY urutan ASC"
        );
        $tracks->execute([$chapterId]);
        $tracks = $tracks->fetchAll();

        $this->view('admin/tracks/index', [
            'pageTitle'  => 'Tracks — ' . $chapter['judul'],
            'activeNav'  => 'chapters',
            'chapter'    => $chapter,
            'tracks'     => $tracks,
            'breadcrumb' => [
                ['label' => 'Chapters', 'url' => url('admin/chapters')],
                ['label' => htmlspecialchars($chapter['judul'])],
                ['label' => 'Tracks'],
            ],
        ]);
    }

    public function create(array $params): void {
        $this->requireAdmin();
        $chapterId = (int)($params['id'] ?? 0);
        $chapter   = $this->findChapter($chapterId);
        if (!$chapter) { $this->redirect('admin/chapters'); return; }

        // Urutan berikutnya
        $stmt = $this->db->prepare("SELECT MAX(urutan) FROM tracks WHERE id_chapter = ?");
        $stmt->execute([$chapterId]);
        $nextUrutan = ((int)$stmt->fetchColumn()) + 1;

        $this->view('admin/tracks/form', [
            'pageTitle'   => 'Tambah Track',
            'activeNav'   => 'chapters',
            'chapter'     => $chapter,
            'track'       => null,
            'nextUrutan'  => $nextUrutan,
            'breadcrumb'  => [
                ['label' => 'Chapters', 'url' => url('admin/chapters')],
                ['label' => htmlspecialchars($chapter['judul']), 'url' => url('admin/chapters/' . $chapterId . '/tracks')],
                ['label' => 'Tambah Track'],
            ],
        ]);
    }

    public function store(array $params): void {
        $this->requireAdmin();
        $chapterId = (int)($params['id'] ?? 0);

        $judul       = trim($_POST['judul_lagu'] ?? '');
        $urutan      = (int)($_POST['urutan'] ?? 1);
        $mood        = trim($_POST['mood'] ?? '');
        $deskripsi   = trim($_POST['deskripsi'] ?? '');
        $trivia      = trim($_POST['trivia'] ?? '');
        $lirik       = trim($_POST['lirik_petikan'] ?? '');
        $audio       = trim($_POST['audio_preview'] ?? '');
        $bgImage     = trim($_POST['bg_image'] ?? '');

        if (empty($judul)) {
            Session::flash('admin_error', 'Judul lagu wajib diisi.');
            $this->redirect("admin/chapters/$chapterId/tracks/create");
            return;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO tracks (id_chapter, judul_lagu, urutan, mood, deskripsi, trivia, lirik_petikan, audio_preview, bg_image)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$chapterId, $judul, $urutan, $mood, $deskripsi, $trivia, $lirik, $audio, $bgImage]);

        Session::flash('admin_success', "Track \"$judul\" berhasil ditambahkan.");
        $this->redirect("admin/chapters/$chapterId/tracks");
    }

    public function edit(array $params): void {
        $this->requireAdmin();
        $trackId = (int)($params['id'] ?? 0);
        $track   = $this->findTrack($trackId);
        if (!$track) { $this->redirect('admin/chapters'); return; }

        $chapter = $this->findChapter($track['id_chapter']);

        $this->view('admin/tracks/form', [
            'pageTitle'  => 'Edit Track',
            'activeNav'  => 'chapters',
            'chapter'    => $chapter,
            'track'      => $track,
            'breadcrumb' => [
                ['label' => 'Chapters', 'url' => url('admin/chapters')],
                ['label' => htmlspecialchars($chapter['judul']), 'url' => url('admin/chapters/' . $chapter['id_chapter'] . '/tracks')],
                ['label' => htmlspecialchars($track['judul_lagu'])],
            ],
        ]);
    }

    public function update(array $params): void {
        $this->requireAdmin();
        $trackId = (int)($params['id'] ?? 0);
        $track   = $this->findTrack($trackId);
        if (!$track) { $this->redirect('admin/chapters'); return; }

        $stmt = $this->db->prepare(
            "UPDATE tracks SET judul_lagu=?, urutan=?, mood=?, deskripsi=?, trivia=?,
             lirik_petikan=?, audio_preview=?, bg_image=? WHERE id_track=?"
        );
        $stmt->execute([
            trim($_POST['judul_lagu'] ?? ''),
            (int)($_POST['urutan'] ?? 1),
            trim($_POST['mood'] ?? ''),
            trim($_POST['deskripsi'] ?? ''),
            trim($_POST['trivia'] ?? ''),
            trim($_POST['lirik_petikan'] ?? ''),
            trim($_POST['audio_preview'] ?? ''),
            trim($_POST['bg_image'] ?? ''),
            $trackId,
        ]);

        Session::flash('admin_success', 'Track berhasil diperbarui.');
        $this->redirect("admin/chapters/{$track['id_chapter']}/tracks");
    }

    public function delete(array $params): void {
        $this->requireAdmin();
        $trackId = (int)($params['id'] ?? 0);
        $track   = $this->findTrack($trackId);
        if (!$track) { $this->redirect('admin/chapters'); return; }

        $chapterId = $track['id_chapter'];
        $stmt = $this->db->prepare("DELETE FROM tracks WHERE id_track = ?");
        $stmt->execute([$trackId]);

        Session::flash('admin_success', 'Track berhasil dihapus.');
        $this->redirect("admin/chapters/$chapterId/tracks");
    }

    private function findChapter(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM chapters WHERE id_chapter = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    private function findTrack(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM tracks WHERE id_track = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}