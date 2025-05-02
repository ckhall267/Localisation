<?php
header('Content-Type: application/json'); // Important pour forcer le JSON
error_reporting(0); // Évite d'afficher les erreurs PHP en HTML

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once 'service/PositionService.php';
    create();
} else {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
}

function create() {
    if (isset($_POST['latitude'], $_POST['longitude'], $_POST['date'], $_POST['imei'])) {
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $date = $_POST['date'];
        $imei = $_POST['imei'];

        $ss = new PositionService();
        $ss->create(new Position(1, $latitude, $longitude, $date, $imei));

        echo json_encode(["status" => "success", "message" => "Position enregistrée"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Champs manquants"]);
    }
}
