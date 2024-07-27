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

$sql = "SELECT user_id, nome, apelido, user_name, email, password FROM usuarios";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
    echo "<table border='1'>";
    echo "<tr><th>User_ID</th><th>Nome</th><th>Apelido</th><th>Username</th><th>Email</th><th>Password</th><th>Ação</th></tr>";

while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["user_id"] . "</td>";
        echo "<td>" . $row["nome"] . "</td>";
        echo "<td>" . $row["apelido"] . "</td>";
        echo "<td>" . $row["user_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "<td><a href='editar_dados.php?id=" . $row['user_id'] . "'>Editar dados</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Nenhum resultado encontrado.";
}

$conn->close();
?>
