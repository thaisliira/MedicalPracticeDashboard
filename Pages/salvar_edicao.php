<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$user_id = $_SESSION['user_id'];    
$nome = $_POST['nome'];
$apelido = $_POST['apelido'];
$username = $_POST['user_name'];
$password = $_POST['password'];

$sql = "UPDATE usuarios SET nome='$nome', apelido='$apelido', user_name='$username' WHERE user_id=$user_id";
$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
    header("Location: perfil_utilizador.php");
    exit();
}

    $conn->close();
}
    ?>
