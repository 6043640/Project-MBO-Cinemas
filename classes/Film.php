<?php
class Film {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function zoekFilms($zoek = '') {
        $sql = "SELECT * FROM films";

        if ($zoek) {
            $zoek = "%$zoek%";
            $sql .= " WHERE titel LIKE :zoek OR genre LIKE :zoek OR locatie LIKE :zoek OR datum LIKE :zoek";
        }

        $stmt = $this->pdo->prepare($sql);
        if ($zoek) {
            $stmt->bindParam(':zoek', $zoek, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
