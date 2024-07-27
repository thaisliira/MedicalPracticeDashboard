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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $user_id = $_SESSION['user_id'];
    $delete_id = $_GET["id"];

    $data_atual = strtotime(date("Y-m-d H:i:s"));

    $sql = "SELECT id, data_consulta FROM consultas WHERE id = $delete_id AND user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $consulta_id = $row['id'];
        $data_consulta = strtotime($row['data_consulta']);

        
        $diferenca_horas = ($data_consulta - $data_atual) / (60 * 60);

        if ($diferenca_horas >= 72) {
            
            $sql_delete = "DELETE FROM consultas WHERE id = $consulta_id";
            if ($conn->query($sql_delete) === TRUE) {
                header("Location: perfil_utilizador.php");
                exit();
            } else {
                echo "Erro ao excluir consulta: " . $conn->error;
            }
        } else {
            $_SESSION['error_message'] = "ATENÇÃO!<BR>
            A exclusão e a edição só são permitidas até 72 horas antes da consulta!";
            header("Location: perfil_utilizador.php");
            exit();
        }
    }}

$conn->close();
?>
