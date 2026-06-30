<?php

class AdminQuestController extends Controller {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // GET /admin/tracks/:id/quest
    public function show(array $params): void {
        $this->requireAdmin();
        $trackId = (int)($params['id'] ?? 0);
        $track   = $this->findTrack($trackId);
        if (!$track) { $this->redirect('admin/chapters'); return; }

        $chapter = $this->findChapter($track['id_chapter']);

        // Ambil quest + options
        $stmt = $this->db->prepare("SELECT * FROM quests WHERE id_track = ? LIMIT 1");
        $stmt->execute([$trackId]);
        $quest = $stmt->fetch();

        $options = [];
        if ($quest) {
            $stmt2 = $this->db->prepare("SELECT * FROM quest_options WHERE id_quest = ? ORDER BY id_option ASC");
            $stmt2->execute([$quest['id_quest']]);
            $options = $stmt2->fetchAll();
        }

        $this->view('admin/quests/form', [
            'pageTitle'  => 'Quest — ' . $track['judul_lagu'],
            'activeNav'  => 'chapters',
            'chapter'    => $chapter,
            'track'      => $track,
            'quest'      => $quest,
            'options'    => $options,
            'breadcrumb' => [
                ['label' => 'Chapters', 'url' => url('admin/chapters')],
                ['label' => htmlspecialchars($chapter['judul']), 'url' => url('admin/chapters/' . $chapter['id_chapter'] . '/tracks')],
                ['label' => htmlspecialchars($track['judul_lagu'])],
                ['label' => 'Quest'],
            ],
        ]);
    }

    // POST /admin/tracks/:id/quest/store
    public function store(array $params): void {
        $this->requireAdmin();
        $trackId = (int)($params['id'] ?? 0);
        $track   = $this->findTrack($trackId);
        if (!$track) { $this->redirect('admin/chapters'); return; }

        $tipe       = $_POST['tipe'] ?? 'trivia';
        $pertanyaan = trim($_POST['pertanyaan'] ?? '');
        $durasi     = (int)($_POST['durasi_baca'] ?? 0);

        // Hapus quest lama kalau ada
        $this->db->prepare("DELETE FROM quests WHERE id_track = ?")->execute([$trackId]);

        $stmt = $this->db->prepare(
            "INSERT INTO quests (id_track, tipe, pertanyaan, durasi_baca) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$trackId, $tipe, $pertanyaan, $durasi ?: null]);
        $questId = (int)$this->db->lastInsertId();

        // Simpan options kalau trivia
        if ($tipe === 'trivia' && !empty($_POST['options'])) {
            $stmtOpt = $this->db->prepare(
                "INSERT INTO quest_options (id_quest, teks_opsi, is_correct) VALUES (?, ?, ?)"
            );
            foreach ($_POST['options'] as $i => $teks) {
                $teks = trim($teks);
                if (empty($teks)) continue;
                $isCorrect = isset($_POST['correct']) && (int)$_POST['correct'] === $i ? 1 : 0;
                $stmtOpt->execute([$questId, $teks, $isCorrect]);
            }
        }

        // Simpan answer kalau tebak_lirik / decode_cipher
        if (in_array($tipe, ['tebak_lirik', 'decode_cipher']) && !empty($_POST['jawaban_benar'])) {
            $stmtOpt = $this->db->prepare(
                "INSERT INTO quest_options (id_quest, teks_opsi, is_correct) VALUES (?, ?, 1)"
            );
            $stmtOpt->execute([$questId, trim($_POST['jawaban_benar'])]);
        }

        Session::flash('admin_success', 'Quest berhasil disimpan.');
        $this->redirect("admin/tracks/$trackId/quest");
    }

    // POST /admin/quests/:id/delete
    public function delete(array $params): void {
        $this->requireAdmin();
        $questId = (int)($params['id'] ?? 0);

        $stmt = $this->db->prepare("SELECT id_track FROM quests WHERE id_quest = ?");
        $stmt->execute([$questId]);
        $row = $stmt->fetch();

        $this->db->prepare("DELETE FROM quests WHERE id_quest = ?")->execute([$questId]);

        Session::flash('admin_success', 'Quest berhasil dihapus.');
        $trackId = $row['id_track'] ?? 0;
        $this->redirect("admin/tracks/$trackId/quest");
    }

    // POST /admin/quests/:id/update — alias store
    public function update(array $params): void {
        $this->store($params);
    }

    private function findTrack(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM tracks WHERE id_track = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    private function findChapter(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM chapters WHERE id_chapter = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}