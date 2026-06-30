<?php

require_once BASE_PATH . '/app/models/Chapter.php';
require_once BASE_PATH . '/app/models/Track.php';
require_once BASE_PATH . '/app/models/Progress.php';

class ChapterController extends Controller {

    private Chapter  $chapterModel;
    private Track    $trackModel;
    private Progress $progressModel;

    public function __construct() {
        $this->chapterModel  = new Chapter();
        $this->trackModel    = new Track();
        $this->progressModel = new Progress();
    }

    public function show(array $params): void {
        $slug    = $params['slug'] ?? '';
        $chapter = $this->chapterModel->findBySlug($slug);

        if (!$chapter) {
            http_response_code(404);
            echo "Chapter tidak ditemukan.";
            return;
        }

        // Jika chapter bernilai 0 (locked secara global), cek progres chapter sebelumnya
if (!$chapter['is_active']) {
    if ($this->isLoggedIn()) {
        $userId = Session::get('user_id');
        // Mengambil progres chapter sebelumnya (id_chapter - 1)
        $chapterSebelumnyaId = $chapter['id_chapter'] - 1;
        $progressSebelumnya = $this->progressModel->get($userId, $chapterSebelumnyaId);
        
        // Jika chapter sebelumnya belum selesai (atau tidak ada data progresnya)
        if (!$progressSebelumnya || !$progressSebelumnya['selesai']) {
            $this->redirect('worldmap');
            return;
        }
    } else {
        // Jika belum login dan chapter is_active = 0, langsung usir ke worldmap
        $this->redirect('worldmap');
        return;
    }
}

        $tracks       = $this->trackModel->getByChapter($chapter['id_chapter']);
        $trackTerbuka = 1;

        if ($this->isLoggedIn()) {
            $userId   = Session::get('user_id');
            $progress = $this->progressModel->get($userId, $chapter['id_chapter']);
            $trackTerbuka = $progress['track_terbuka'] ?? 1;

            if (!$progress) {
                $this->progressModel->init($userId, $chapter['id_chapter']);
            }
        }

        $this->view('chapter/map', [
            'chapter'      => $chapter,   // sudah include tema_warna & dekorasi
            'tracks'       => $tracks,
            'trackTerbuka' => $trackTerbuka,
            'isLoggedIn'   => $this->isLoggedIn(),
        ]);
    }
}