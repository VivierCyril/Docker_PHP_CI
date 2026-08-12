<?php

namespace AFPA\Entity;

use PDO;

class Personne
{

    public function __construct(
        public int $id,
        public string $firstname,
        public string $lastname,
        public string $email,
        public string $gender
    ) {}

    // Méthodes statiques pour CRUD
    public static function all()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM personne");
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function find(int $id): self
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM personne WHERE id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function create(string $firstname, string $lastname, string $email, string $gender): int
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO personne (firstname, lastname, email, gender) VALUES (?,?,?,?)");
        $stmt->execute([$firstname, $lastname, $email, $gender]);
        return $pdo->lastInsertId();
    }

    public static function update(int $id, string $nom): void
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE personne SET lastname = ? WHERE id = ?");
        $stmt->execute([$nom, $id]);
    }

    public static function delete(int $id): void
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM personne WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function majuscule()
    {
        return strtoupper($this->firstname . " " . $this->lastname);
    }
}
