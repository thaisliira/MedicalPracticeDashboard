<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "casopraticophp";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);}

$sql = "SELECT user_id, user_type FROM usuarios WHERE user_name = '$user_name' AND password = '$password'";
$result = $conn->query($sql);

if (!$result) {
    die ("Erro na consulta SQL: " . $conn->error);
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['user_id'];

    if ($row['user_type'] === 'utilizador') {
        header("Location: perfil_utilizador.php");
    } elseif ($row['user_type'] === 'administrador' && $user_name === 'admin' && $password === 'admin1234') {
        header("Location: perfil_administrador.php"); 
    } else {
        $login_error = "Usuário desconhecido."; 
    }

    exit();
} else {
    $login_error = "Nome de utilizador ou senha incorretos.";
}

$conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Caso Prático PHP</title>
<link href="style/style.css" rel="stylesheet">
<style>
    body{
	background: url(images/bgimagem.jpg);}
</style>
</head>
<body> 
<div class="caixa1">
<div class="logo">
<img src="images/logodentista.jpg" width="230">
<h1>Bem-vindo!</h1>
<h2> Faça aqui o seu login<h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<input type="text" id="user_name" placeholder="Nome do usuário" name="user_name"><br>
<input type="password" id="password" placeholder="Senha" name="password"><br>
<button type="submit" class="botao">Enviar</button>
<p>Ainda não tem uma conta? <a id="registro" href="paginaderegistro.html"> Registre-se</a></p>
</form>
</div>
</div>
</body>
</html>