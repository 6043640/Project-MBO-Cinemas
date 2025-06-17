<?php
class Reservering {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    
    public function getByKlant($klant_id) {
        $stmt = $this->db->prepare("SELECT * FROM reserveringen WHERE klant_id = :klant_id AND status != 'geannuleerd'");
        $stmt->execute([':klant_id' => $klant_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function updateAantal($res_id, $nieuw_aantal, $klant_id) {
        $stmt = $this->db->prepare("UPDATE reserveringen SET aantal_kaartjes = :aantal WHERE id = :id AND klant_id = :klant_id");
        return $stmt->execute([':aantal' => $nieuw_aantal, ':id' => $res_id, ':klant_id' => $klant_id]);
    }

    
    public function annuleer($res_id, $klant_id) {
        $stmt = $this->db->prepare("UPDATE reserveringen SET status = 'geannuleerd' WHERE id = :id AND klant_id = :klant_id");
        return $stmt->execute([':id' => $res_id, ':klant_id' => $klant_id]);
    }
}