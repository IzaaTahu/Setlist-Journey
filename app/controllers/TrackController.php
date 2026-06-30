<?php

require_once BASE_PATH . '/app/models/Track.php';
require_once BASE_PATH . '/app/models/Quest.php';
require_once BASE_PATH . '/app/models/Progress.php';
require_once BASE_PATH . '/app/models/Milestone.php';

class TrackController extends Controller {

    private Track     $trackModel;
    private Quest     $questModel;
    private Progress  $progressModel;
    private Milestone $milestoneModel;

    public function __construct() {
        $this->trackModel     = new Track();
        $this->questModel     = new Quest();
        $this->progressModel  = new Progress();
        $this->milestoneModel = new Milestone();
    }

    public function show(array $params): void {
        $trackId = (int)($params['id'] ?? 0);
        $track   = $this->trackModel->findById($trackId);

        if (!$track) {
            http_response_code(404);
            echo "Lagu tidak ditemukan.";
            return;
        }

        if ($this->isLoggedIn()) {
            $userId   = Session::get('user_id');
            $progress = $this->progressModel->get($userId, $track['id_chapter']);

            if ($track['urutan'] > ($progress['track_terbuka'] ?? 1)) {
                $this->redirect('chapter/' . $track['chapter_slug']);
                return;
            }
        }

        $quest     = $this->questModel->getByTrack($trackId);
        $milestone = null;

        if ($this->isLoggedIn()) {
            $milestone = $this->milestoneModel->getAfterTrack(
                $track['id_chapter'],
                $track['urutan']
            );
        }

        $this->view('track/sanctuary', [
            'track'      => $track,
            'quest'      => $quest,
            'milestone'  => $milestone,
            'isLoggedIn' => $this->isLoggedIn(),
        ]);
    }
}