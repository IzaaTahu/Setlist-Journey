<?php

require_once BASE_PATH . '/app/models/Chapter.php';
require_once BASE_PATH . '/app/models/Progress.php';

class WorldMapController extends Controller {

    private Chapter  $chapterModel;
    private Progress $progressModel;

    public function __construct() {
        $this->chapterModel  = new Chapter();
        $this->progressModel = new Progress();
    }

    public function index(): void {
        $chapters = $this->chapterModel->getAllActive();
        $progress = [];

        if ($this->isLoggedIn()) {
            $userId   = Session::get('user_id');
            $progress = $this->progressModel->getByUser($userId);
        }

        // Tentukan status locked per chapter berdasarkan progress user
        // bukan berdasarkan is_active global
        foreach ($chapters as &$ch) {
            $urutan = (int)$ch['urutan'];

            // Chapter 1 selalu terbuka (kalau is_active)
            if ($urutan === 1) {
                $ch['locked'] = false;
                continue;
            }

            // Chapter N terbuka kalau chapter N-1 sudah selesai oleh user ini
            if ($this->isLoggedIn()) {
                // Cari chapter sebelumnya
                $prevChapter = null;
                foreach ($chapters as $c) {
                    if ((int)$c['urutan'] === $urutan - 1) {
                        $prevChapter = $c;
                        break;
                    }
                }
                $prevProgress = $progress[$prevChapter['id_chapter']] ?? null;
                $ch['locked'] = !($prevProgress['selesai'] ?? false);
            } else {
                // Guest — hanya chapter 1 yang terbuka
                $ch['locked'] = true;
            }
        }
        unset($ch);

        $this->view('worldmap/index', [
            'chapters'   => $chapters,
            'progress'   => $progress,
            'isLoggedIn' => $this->isLoggedIn(),
        ]);
    }
}