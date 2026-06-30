<?php

require_once BASE_PATH . '/app/models/Chapter.php';
require_once BASE_PATH . '/app/models/Track.php';
require_once BASE_PATH . '/app/models/Progress.php';

class GuestbookController extends Controller {

    private Chapter  $chapterModel;
    private Track    $trackModel;
    private Progress $progressModel;

    public function __construct() {
        $this->chapterModel  = new Chapter();
        $this->trackModel    = new Track();
        $this->progressModel = new Progress();
    }

    // GET /final/:slug
    public function show(array $params): void {
        $slug    = $params['slug'] ?? '';
        $chapter = $this->chapterModel->findBySlug($slug);

        if (!$chapter) {
            http_response_code(404);
            echo "Chapter tidak ditemukan.";
            return;
        }

        $total = $this->trackModel->countByChapter($chapter['id_chapter']);

        if ($this->isLoggedIn()) {
            $userId   = Session::get('user_id');
            $progress = $this->progressModel->get($userId, $chapter['id_chapter']);

            if (!$progress || ($progress['track_terbuka'] - 1) < $total) {
                $this->redirect('chapter/' . $slug);
                return;
            }
        }

        $tracks    = $this->trackModel->getByChapter($chapter['id_chapter']);
        $stats     = $this->trackModel->getStatsByChapter($chapter['id_chapter']);
        $guestbook = $this->chapterModel->getGuestbook($chapter['id_chapter']);

        $this->view('final/memory_box', [
            'chapter'    => $chapter,
            'tracks'     => $tracks,
            'stats'      => $stats,
            'guestbook'  => $guestbook,
            'isLoggedIn' => $this->isLoggedIn(),
            'success'    => Session::flash('success'),
        ]);
    }

    // POST /final/:slug
    public function store(array $params): void {
        $slug    = $params['slug'] ?? '';
        $chapter = $this->chapterModel->findBySlug($slug);

        if (!$chapter) {
            $this->redirect('worldmap');
            return;
        }

        $nama  = trim($_POST['nama'] ?? Session::get('user_nama', 'Tamu'));
        $pesan = trim($_POST['pesan'] ?? '');

        if (empty($pesan)) {
            $this->redirect('final/' . $slug);
            return;
        }

        $userId = $this->isLoggedIn() ? Session::get('user_id') : null;
        $this->chapterModel->addGuestbook($chapter['id_chapter'], $userId, $nama, $pesan);

        // Tandai selesai untuk user ini saja
        // Chapter berikutnya terbuka otomatis di WorldMap
        // berdasarkan progress — tidak perlu unlockNext global
        if ($this->isLoggedIn()) {
            $this->progressModel->markDone($userId, $chapter['id_chapter']);
        }

        Session::flash('success', 'Pesanmu sudah tersimpan!');
        $this->redirect('final/' . $slug);
    }
}