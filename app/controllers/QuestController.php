<?php

require_once BASE_PATH . '/app/models/Quest.php';
require_once BASE_PATH . '/app/models/Track.php';
require_once BASE_PATH . '/app/models/Progress.php';

class QuestController extends Controller {

    private Quest    $questModel;
    private Track    $trackModel;
    private Progress $progressModel;

    public function __construct() {
        $this->questModel    = new Quest();
        $this->trackModel    = new Track();
        $this->progressModel = new Progress();
    }

    // POST /quest/submit
    public function submit(): void {
        try {
            $questId = (int)($_POST['quest_id'] ?? 0);
            $jawaban = $_POST['jawaban'] ?? '';
            $trackId = (int)($_POST['track_id'] ?? 0);

            $quest = $this->questModel->findById($questId);
            $track = $this->trackModel->findById($trackId);

            if (!$quest || !$track) {
                $this->json(['success' => false, 'message' => 'Data tidak valid.'], 400);
                return;
            }

            $isCorrect = null;
            $tipe      = $quest['tipe'];

            // Evaluasi jawaban
            if (in_array($tipe, ['trivia', 'tebak_lirik', 'tebak_siluet', 'decode_cipher'])) {
                $isCorrect = $this->questModel->checkAnswer($questId, $jawaban);
            }
            // Non-graded: baca_lore, tulis_kesan, easter_egg, susun_lirik → langsung lulus

            // Catat & advance progress kalau login
            if ($this->isLoggedIn()) {
                $userId = Session::get('user_id');
                $this->questModel->log($userId, $questId, $jawaban, $isCorrect);

                if ($isCorrect !== false) {
                    $this->progressModel->advance($userId, $track['id_chapter'], $track['urutan']);
                }
            }

            // Kalau jawaban salah, jangan hitung/kirim next_url sama sekali —
            // frontend cukup tahu is_correct === false dan tetap di halaman ini
            if ($isCorrect === false) {
                $this->json([
                    'success'    => true,
                    'is_correct' => false,
                ]);
                return;
            }

            // Tentukan next URL — pakai url() agar prefix subfolder ikut
            $nextTrack = $this->trackModel->getNext($track['id_chapter'], $track['urutan']);

            $nextUrl = $nextTrack
                ? url('track/' . $nextTrack['id_track'])
                : url('final/' . $track['chapter_slug']);

            $this->json([
                'success'    => true,
                'is_correct' => $isCorrect,
                'next_url'   => $nextUrl,
            ]);
        } catch (\Throwable $e) {
            error_log('QuestController::submit error: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Terjadi kendala di server. Coba lagi.'], 500);
        }
    }

    // GET /quest/next/:id — untuk guest / skip
    public function next(array $params): void {
        $trackId = (int)($params['id'] ?? 0);
        $track   = $this->trackModel->findById($trackId);

        if (!$track) {
            $this->redirect('worldmap');
            return;
        }

        $nextTrack = $this->trackModel->getNext($track['id_chapter'], $track['urutan']);

        $this->redirect(
            $nextTrack
                ? url('track/' . $nextTrack['id_track'])
                : url('final/' . $track['chapter_slug'])
        );
    }
}