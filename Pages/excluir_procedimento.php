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
    $procedimento_id = mysqli_real_escape_string($conn, $_GET['id']); 

    $sql = "DELETE FROM procedimentos WHERE procedimento_id = $procedimento_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: perfil_administrador.php");
        exit();
    } else {
        echo "Erro ao excluir o procedimento: " . $conn->error;
    }
}

$conn->close();
?>

