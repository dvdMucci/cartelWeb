<?php
$servername = "lamp-mysql8";
$username = "PANTALLA";
$password = "sELECT1334!";
$dbname = "pantalla";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $boxId = $_POST['boxId'];
    $action = $_POST['action'];

    $stmt = $conn->prepare("INSERT INTO comandos (box_id, action) VALUES (?, ?)");
    $stmt->bind_param("ss", $boxId, $action);
    $stmt->execute();
    $stmt->close();

    echo "Command saved";
}

$conn->close();
?>
