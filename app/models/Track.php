<?php

class Track extends Model {

    public function getByChapter(int $chapterId): array {
        $stmt = $this->db->prepare(
            "SELECT t.*, c.slug AS chapter_slug
             FROM tracks t
             JOIN chapters c ON t.id_chapter = c.id_chapter
             WHERE t.id_chapter = ?
             ORDER BY t.urutan ASC"
        );
        $stmt->execute([$chapterId]);
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT t.*,
                    c.slug       AS chapter_slug,
                    c.judul      AS chapter_judul,
                    c.urutan     AS chapter_urutan,
                    c.tema_warna AS chapter_tema,
                    c.dekorasi   AS chapter_dekorasi
             FROM tracks t
             JOIN chapters c ON t.id_chapter = c.id_chapter
             WHERE t.id_track = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getNext(int $chapterId, int $currentUrutan): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM tracks
             WHERE id_chapter = ? AND urutan = ?
             LIMIT 1"
        );
        $stmt->execute([$chapterId, $currentUrutan + 1]);
        return $stmt->fetch();
    }

    public function countByChapter(int $chapterId): int {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM tracks WHERE id_chapter = ?"
        );
        $stmt->execute([$chapterId]);
        return (int)$stmt->fetchColumn();
    }

    public function getStatsByChapter(int $chapterId): array {
        $stmt = $this->db->prepare(
            "SELECT COUNT(DISTINCT t.id_track) AS total_lagu
             FROM tracks t
             WHERE t.id_chapter = ?"
        );
        $stmt->execute([$chapterId]);
        return $stmt->fetch();
    }
}