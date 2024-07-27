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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_consulta = $_POST["data_consulta"];
    $horario = $_POST["horario"];

    $user_id = $_SESSION['user_id'];

    $sql_insert = "INSERT INTO consultas (user_id, data_consulta, horario, status)
                   VALUES ('$user_id', '$data_consulta', '$horario', 'Agendada')";

    if ($conn->query($sql_insert) === TRUE) {
        header("Location: perfil_utilizador.php");
    exit();
} else {
        echo "Erro ao agendar consulta: " . $conn->error;
    }}

$conn->close();
?>
