<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password, $dbname);

$user_id = $_SESSION['user_id'];
$user_id = $_POST['user_id'];
$consulta_id = $_POST['id'];
$data_consulta = $_POST['data_consulta'];
$horario = $_POST['horario'];
$sql_consulta = "INSERT INTO consultas (user_id, id, data_consulta, horario, status ) VALUES ('$user_id','$consulta_id', '$data_consulta', '$horario', 'Agendada')"; 

if ($conn->query($sql_consulta) === TRUE) {
    header("Location: perfil_administrador.php");
    exit();
} else {
        echo "Erro ao agendar consulta: " . $conn->error;
    }

$conn->close();
?>