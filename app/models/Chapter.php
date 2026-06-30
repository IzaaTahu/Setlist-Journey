<?php

class Chapter extends Model {

    public function getAllActive(): array {
        $stmt = $this->db->query(
            "SELECT * FROM chapters ORDER BY urutan ASC"
        );
        return $stmt->fetchAll();
    }

    public function findBySlug(string $slug): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM chapters WHERE slug = ? LIMIT 1"
        );
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function unlockNext(int $currentUrutan): void {
        $stmt = $this->db->prepare(
            "UPDATE chapters SET is_active = 1 WHERE urutan = ?"
        );
        $stmt->execute([$currentUrutan + 1]);
    }

    public function getGuestbook(int $chapterId): array {
        $stmt = $this->db->prepare(
            "SELECT g.*, u.nama AS nama_user
             FROM guestbook g
             LEFT JOIN users u ON g.id_user = u.id_user
             WHERE g.id_chapter = ?
             ORDER BY g.dibuat_pada DESC"
        );
        $stmt->execute([$chapterId]);
        return $stmt->fetchAll();
    }

    public function addGuestbook(int $chapterId, ?int $userId, string $nama, string $pesan): void {
        $stmt = $this->db->prepare(
            "INSERT INTO guestbook (id_chapter, id_user, nama, pesan) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$chapterId, $userId, $nama, $pesan]);
    }
}
