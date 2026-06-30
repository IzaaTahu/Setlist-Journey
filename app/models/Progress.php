<?php

class Progress extends Model {

    public function get(int $userId, int $chapterId): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM user_progress
             WHERE id_user = ? AND id_chapter = ? LIMIT 1"
        );
        $stmt->execute([$userId, $chapterId]);
        return $stmt->fetch();
    }

    public function getByUser(int $userId): array {
        $stmt = $this->db->prepare(
            "SELECT * FROM user_progress WHERE id_user = ?"
        );
        $stmt->execute([$userId]);
        // Ubah jadi array dengan id_chapter sebagai key
        $rows = $stmt->fetchAll();
        $map  = [];
        foreach ($rows as $row) {
            $map[$row['id_chapter']] = $row;
        }
        return $map;
    }

    public function init(int $userId, int $chapterId): void {
        $stmt = $this->db->prepare(
            "INSERT IGNORE INTO user_progress (id_user, id_chapter, track_terbuka)
             VALUES (?, ?, 1)"
        );
        $stmt->execute([$userId, $chapterId]);
    }

    // Advance ke track berikutnya jika belum lebih jauh
    public function advance(int $userId, int $chapterId, int $currentUrutan): void {
        $stmt = $this->db->prepare(
            "INSERT INTO user_progress (id_user, id_chapter, track_terbuka)
             VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE
               track_terbuka = GREATEST(track_terbuka, VALUES(track_terbuka))"
        );
        $stmt->execute([$userId, $chapterId, $currentUrutan + 1]);
    }

    public function markDone(int $userId, int $chapterId): void {
        $stmt = $this->db->prepare(
            "UPDATE user_progress SET selesai = 1
             WHERE id_user = ? AND id_chapter = ?"
        );
        $stmt->execute([$userId, $chapterId]);
    }
}
