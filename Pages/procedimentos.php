<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$procedimento_solicitado = $_POST['procedimento_solicitado'];

$sql = "INSERT INTO procedimentos (user_id, procedimento_solicitado) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

$stmt->bind_param("is", $user_id, $procedimento_solicitado);

if ($stmt->execute()) {
    
    header("Location: perfil_utilizador.php");
    exit();
}

$stmt->close();
$conn->close();
?>

