<?php

class Quest extends Model {

    public function getByTrack(int $trackId): array|false {
    // Query 1: ambil quest
    $stmt = $this->db->prepare(
        "SELECT q.*
         FROM quests q
         WHERE q.id_track = ?
         LIMIT 1"
    );
    $stmt->execute([$trackId]);
    $row = $stmt->fetch();

    if (!$row) return false;

    // Query 2: ambil options kalau ada
    $stmt2 = $this->db->prepare(
        "SELECT id_option AS id, teks_opsi AS teks, is_correct AS correct
         FROM quest_options
         WHERE id_quest = ?"
    );
    $stmt2->execute([$row['id_quest']]);
    $row['options'] = $stmt2->fetchAll();

    return $row;
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM quests WHERE id_quest = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function checkAnswer(int $questId, string $jawaban): bool {
        // Untuk tipe trivia → cek di quest_options
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM quest_options
             WHERE id_quest = ? AND teks_opsi = ? AND is_correct = 1"
        );
        $stmt->execute([$questId, $jawaban]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function log(int $userId, int $questId, string $jawaban, ?bool $isCorrect): void {
        $stmt = $this->db->prepare(
            "INSERT INTO quest_log (id_user, id_quest, jawaban, is_correct)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$userId, $questId, $jawaban, $isCorrect]);
    }
}
