<?php
class Member extends Model {
    public function findById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT * FROM member WHERE id_member = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}