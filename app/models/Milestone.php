<?php

class Milestone extends Model {

    public function getAfterTrack(int $chapterId, int $trackUrutan): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM milestones
             WHERE id_chapter = ? AND setelah_track = ?
             LIMIT 1"
        );
        $stmt->execute([$chapterId, $trackUrutan]);
        return $stmt->fetch();
    }
}
