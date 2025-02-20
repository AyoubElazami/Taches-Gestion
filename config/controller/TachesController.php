

<?php
require_once (dirname(__DIR__).'/init.php');


class TachesController {
    private $pdo;

    public function __construct() {
        $this->pdo = PDOUtils::getSharedInstance();
    }

    public function ajouterTache(Taches $tache) {
        $sql = "INSERT INTO taches (titre, description, status, date_creation) VALUES (:titre, :description, :status, NOW())";
        return $this->pdo->execSQL($sql, [
            ':titre' => $tache->getTitre(),
            ':description' => $tache->getDescription(),
            ':status' => $tache->getStatus()
        ]);
    }

    public function getTaches() {
        $sql = "SELECT * FROM taches ORDER BY date_creation DESC";
        $result = $this->pdo->requestSQL($sql);

        $taches = [];
        foreach ($result as $row) {
            $taches[] = new Taches($row['id'], $row['titre'], $row['description'], $row['status'], $row['date_creation']);
        }
        return $taches;
    }

    public function changerStatut($id, $status) {
        $sql = "UPDATE taches SET status = :status WHERE id = :id";
        return $this->pdo->execSQL($sql, [
            ':id' => $id,
            ':status' => $status
        ]);
    }

    public function supprimerTache($id) {
        $sql = "DELETE FROM taches WHERE id = :id";
        return $this->pdo->execSQL($sql, [':id' => $id]);
    }
}
?>
