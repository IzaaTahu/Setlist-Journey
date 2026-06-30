<?php

class User extends Model {

    public function findByEmail(string $email): array|false {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id_user = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $nama, string $email, string $hashedPassword): int {
        $stmt = $this->db->prepare(
            "INSERT INTO users (nama, email, password_pengguna, role) VALUES (?, ?, ?, 'user')"
        );
        $stmt->execute([$nama, $email, $hashedPassword]);
        return (int)$this->db->lastInsertId();
    }
}
