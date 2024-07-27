<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password, $dbname);

$nome = $_POST['nome'];
$apelido = $_POST['apelido'];
$username = $_POST['user_name'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO usuarios (nome, apelido, user_name, email, password, user_type) VALUES ('$nome', '$apelido', '$username', '$email', '$password', 'utilizador')";

if ($conn->query($sql) === TRUE) {
    header("Location: login_page.php");
    exit();
} else {
    if ($conn->erro === 1062) {
        echo "Erro: o endereço de email já se encontra em uso. Por favor, escolha outro.";
    } else {
        echo "Erro ao registrar: " . $conn->error;
    }
    }

    $conn->close();
    ?>