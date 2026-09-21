<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

// Récupération du numéro de licence dans les données de la requête
$license = $_GET['license'] ?? '';

// Vérifie si le numéro de licence existe (requête préparée)
$req = getConnection()->prepare('SELECT 1 FROM joueur WHERE licence = :licence');
$req->execute(['licence' => $license]);

// Retourne la réponse sous forme d'objet JSON
echo json_encode(['licenseExists' => (bool) $req->fetchColumn()]);
