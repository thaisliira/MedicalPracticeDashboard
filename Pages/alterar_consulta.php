<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$user_id = $_SESSION['user_id'];    
$data_consulta = $_POST['data_consulta'];
$horario = $_POST['horario'];
$status = $_POST['status'];
$sql = "UPDATE consultas SET data_consulta='$data_consulta', horario='$horario', status='$status' WHERE user_id=$user_id";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
    header("Location: perfil_administrador.php");
    exit();
}

    $conn->close();
}
    ?>