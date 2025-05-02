<?php
include_once 'dao/IDao.php';
include_once 'classe/Position.php';
include_once 'connexion/Connexion.php';

class PositionService implements IDao {
    private $connexion;

    public function __construct() {
        $this->connexion = new Connexion();
    }

    // Création d'une position
    public function create($position) {
        $query = "INSERT INTO position (latitude, longitude, date, imei) VALUES (:latitude, :longitude, :date, :imei)";
        $stmt = $this->connexion->getConnextion()->prepare($query);

        // Liaison des paramètres pour éviter l'injection SQL
        $stmt->bindParam(':latitude', $position->getLatitude());
        $stmt->bindParam(':longitude', $position->getLongitude());
        $stmt->bindParam(':date', $position->getDate());
        $stmt->bindParam(':imei', $position->getImei());

        // Exécution de la requête avec gestion des erreurs
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de l'insertion : " . $e->getMessage();
        }
    }

    // Suppression d'une position (par ID)
    public function delete($position) {
        $query = "DELETE FROM position WHERE id = :id";
        $stmt = $this->connexion->getConnextion()->prepare($query);

        // Liaison de l'ID pour la suppression
        $stmt->bindParam(':id', $position->getId());

        // Exécution de la requête
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression : " . $e->getMessage();
        }
    }

    // Récupération de toutes les positions
    public function getAll() {
        $query = "SELECT * FROM position";
        $stmt = $this->connexion->getConnextion()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer une position par son ID
    public function getById($id) {
        $query = "SELECT * FROM position WHERE id = :id";
        $stmt = $this->connexion->getConnextion()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mise à jour d'une position
    public function update($position) {
        $query = "UPDATE position SET latitude = :latitude, longitude = :longitude, date = :date, imei = :imei WHERE id = :id";
        $stmt = $this->connexion->getConnextion()->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':latitude', $position->getLatitude());
        $stmt->bindParam(':longitude', $position->getLongitude());
        $stmt->bindParam(':date', $position->getDate());
        $stmt->bindParam(':imei', $position->getImei());
        $stmt->bindParam(':id', $position->getId());

        // Exécution de la requête
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}
