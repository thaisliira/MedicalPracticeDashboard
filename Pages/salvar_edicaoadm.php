<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: perfil_administrador.php");
    exit();
}

$logInUserId = $_SESSION['user_id'];
$user_id = $_POST['user_id'];
$nome = $_POST['nome'];
$apelido = $_POST['apelido'];
$user_name = $_POST['user_name'];
$email = $_POST['email'];
$password = $_POST['password'];

$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

$sqlUpdate = "UPDATE usuarios SET nome = ?, apelido = ?, user_name = ?, password = ?, email = ? WHERE user_id = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bind_param("sssssi", $nome, $apelido, $user_name, $password, $email, $user_id);
$stmtUpdate->execute();

$stmtUpdate->close();
$conn->close();

header("Location: perfil_administrador.php");
exit();
?>
