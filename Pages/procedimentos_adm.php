<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password, $dbname);

$user_id = $_POST['user_id'];
$procedimento_id = $_POST['procedimento_id'];
$procedimento_solicitado = $_POST['procedimento_solicitado'];
$procedimento_realizado = $_POST['procedimento_realizado'];

$sql = "INSERT INTO procedimentos (user_id, procedimento_id, procedimento_solicitado, procedimento_realizado) VALUES ('$user_id', '$procedimento_id','$procedimento_solicitado', '$procedimento_realizado')";

if ($conn->query($sql) === TRUE) {
    header("Location: perfil_administrador.php");
    exit();
}

$conn->close();
?>