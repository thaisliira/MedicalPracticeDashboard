<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $consulta_id = $_GET['id'];

    $sql = "DELETE FROM consultas WHERE id = $consulta_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: perfil_administrador.php");
        exit();
        echo "Erro ao excluir a consulta: " . $conn->error;
    }
} 

$conn->close();
?>
