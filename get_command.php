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

// Obtener el último comando no procesado
$sql = "SELECT id, box_id, action FROM comandos WHERE processed = 0 ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

$command = null;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $command = $row['action'] . ":" . $row['box_id'];

    // Marcar el comando como procesado
    $updateSql = "UPDATE comandos SET processed = 1 WHERE id = " . $row['id'];
    $conn->query($updateSql);
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['command' => $command]);
?>
