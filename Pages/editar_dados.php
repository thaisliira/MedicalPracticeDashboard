<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: perfil_utilizador.php");
    exit();}

    $user_id = $_SESSION['user_id'];
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "casopraticophp";
    
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("A conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT nome, apelido, user_name, password, email FROM usuarios WHERE user_id = $user_id";
$result = $conn->query($sql);

if (!$result) {
    die ("Erro na consulta SQL: " . $conn->error);
}
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nome = $row['nome'];
    $apelido = $row['apelido'];
    $user_name = $row['user_name'];
    $password = $row['password'];

} else {
    echo "Perfil de usuário não encontrado.";
}

$conn->close();
?>

<DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title> Editar Dados </title>
<link href="style/style.css" rel="stylesheet">
<style>
body{
	background: url(images/bgimagem.jpg);
}

.caixa1 {
    margin: 0 auto; 
}

.tabela-usuario {
    width: 100%;
    margin-top: 20px;
}

</style>
</head>
<body>

<div class="caixa1">
<h1> Editar meus dados:  </h1>

<?php

if(!isset($_SESSION['user_id'])) {
    header("Location:perfil_utilizador.php");
    exit();
}

$servername= "localhost";
$username = "root";
$password_db = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT nome, apelido, user_name, password, email FROM usuarios WHERE user_id = $user_id";
$result = $conn->query($sql);

if (!$result) {
die ("Erro na consulta SQL: " . $conn->error);
}
if ($result->num_rows == 1) {
$row = $result->fetch_assoc();
$nome = $row['nome'];
$apelido = $row['apelido'];
$username = $row['user_name'];
$password = $row['password'];

} else {
echo "Perfil de usuário não encontrado.";
}
$conn->close();
?>

<table class="tabela-usuario">
<form method="post" action="salvar_edicao.php">
        <tr>
            <th> Nome </th> <td> <input type="text" name="nome" id="nome" value="<?php echo $nome;?>" /><br> </td>
        </tr>
        <tr>
            <th> Apelido </th> <td><input type="text" name="apelido" id="apelido" value="<?php echo $apelido;?>" /><br></td>
</tr>
<tr>
            <th> Username </th><td><input type="text" name="user_name" id="user_name" value="<?php echo $username;?>" /><br></td>
</tr>
<tr>
            <th> Password </th><td><input type="password" name="password" id="password" value="<?php echo $password;?>" /><br></td>

</tr>
<tr class="centralizar-botao">
<td colspan="2"><input type="submit" name="Submit" value="Salvar Alterações" id="botao_form"></td>
</tr>
</table>
<p> Clique <a href="perfil_utilizador.php"><b>aqui</b></a> para voltar. </p></div>
 </form>
 </div>
 </body>
 </html>
