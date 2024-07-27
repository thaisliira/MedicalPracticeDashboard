<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("A conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT user_id, nome, apelido, user_name, password, email FROM usuarios WHERE user_id = $user_id";
$result = $conn->query($sql);

if (!$result) {
die ("Erro na consulta SQL: " . $conn->error);
}
if ($result->num_rows == 1) {
$row = $result->fetch_assoc();
$user_id = $row['user_id'];
$nome = $row['nome'];
$apelido = $row['apelido'];
$user_name = $row['user_name'];
$email = $row['email'];

} else {
echo "Perfil de usuário não encontrado.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title> Perfil do Dentista </title>
<link href="style/styleuser.css" rel="stylesheet">
<style>
body{
	background: url(images/bgimagem.jpg);
}

.caixa1 {
    width: 630px;
    margin: auto;
}

th, td {
    font-size: 13px;
}

</style>
</head>
<body>

<div class="caixa1">
<img src="images/dentista.jpg" width="150" id="user_image">
<h1 text-align="left"> Perfil do Dentista </h1>
<h4> Olá, <?php echo $nome; ?>! </h4>
   

<?php

if(!isset($_SESSION['user_id'])) {
    header("Location:login_page.php");
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
function obterDadosUsuarios($conn) {
$sql = "SELECT user_id, nome, apelido, user_name, email, password FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    return $result->fetch_all(MYSQLI_ASSOC);
}

return [];
}
 
$dadosUsuarios = obterDadosUsuarios($conn);

$conn->close();
?>

<br>
<div class="tabela">
    <h2> Dados dos usuários</h2>
     
    <?php if (!empty($dadosUsuarios)): ?>
    <table class="tabela-usuarios">
        <tr>
            <th>User_ID</th>
            <th> Nome </th>
            <th> Apelido </th>
            <th> Username </th>
            <th> Email </th>
            <th> Password </th>
            <th> Ação </th>
        </tr>
        <?php foreach ($dadosUsuarios as $row): ?>
        <tr>
        <td><?php echo $row["user_id"]; ?></td>
            <td><?php echo $row["nome"]; ?></td>
            <td><?php echo $row["apelido"]; ?></td>
            <td><?php echo $row["user_name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["password"]; ?></td>
            <td><a href='editar_dadosadm.php?id=<?php echo $row["user_id"]; ?>'>Editar dados</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p>Nenhum resultado encontrado.</p>
    <?php endif; ?>

    <h2> Marcar consulta </h2>
    <form method = "POST" action="agendar_consultaadm.php">

        <label for="user_id"> User ID </label>
        <input class="textbox" name="user_id" maxlength="4" id="user_id"><br><br>

        <label for="data_consulta"> Data da consulta </label>
        <input type="date" id="data_consulta" name="data_consulta" required> <br> </br>

        <label for="horario"> Hora da consulta </label>
        <input type="time" id ="horario" name="horario" required> <br> <br>

        <input type="submit" value="Marcar consulta" class="botao verde">
    </form>
    <table class="tabela-usuario">
        <thread>
            <tr>
                <th> User_ID </th>
                <th> Consulta ID </th>
                <th> Data </th>
                <th> Hora </th>
                <th> Status </th>
                <th> Ações </th>
            </tr>
        </thread>
    
<?php

$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "casopraticophp";

$conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("A conexão falhou: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $dadosConsultas = obterDadosConsultas($conn, $user_id);

    foreach ($dadosConsultas as $consulta) {
        $consulta_id = $consulta['id'];
        $user_id = $consulta['user_id'];
        $data_formatada = date('d/m/Y', strtotime($consulta['data_consulta']));
        $horario = $consulta['horario'];
        $status = $consulta['status'];
           
        echo "<tr>";
        echo "<td>$user_id</td>";
        echo "<td>$consulta_id</td>";
        echo "<td>$data_formatada</td>";
        echo "<td>$horario</td>";
        echo "<td>$status</td>";
        echo "<td>";
        echo "<a href='editar_consultaadm.php?id=$consulta_id'> Editar </a>  | ";  
        echo "<a href='excluir_consultaadm.php?id=$consulta_id'> Excluir </a>";
        echo "</td>";
        echo "</tr>";
    }
    
    function obterDadosConsultas($conn, $user_id)
        {
            $sql = "SELECT user_id, id, data_consulta, horario, status FROM consultas";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }

            return [];
        }

    ?>
    
</table>

<h2>Procedimentos</h2>
    <form action="procedimentos_adm.php" method="POST">
       
    <label for ="procedimento_solicitado">Tipos de procedimentos:</label>
    <select name="procedimento_solicitado"  id="procedimento_solicitado" required>
    <option value="Cirurgia">Cirurgia</option>
    <option value="Periodontia">Periodontia</option>
    <option value="Dentistica">Dentistica</option>
    <option value="Endodontia">Endodontia</option>
    </select>
    <label for="user_id"> User_ID </label>
        <input class="text" name="user_id" maxlength="4" id="user_id"><br>
    <label for="procedimento_realizado">Procedimento Realizado:</label>
   <input type="text" name="procedimento_realizado" id="procedimento_realizado" required>
          
    <input type="submit" class="botao" value="Confirmar">
    </form>

    <table class="procedimentos">
        <thread>
            <tr>
                <th> User_ID </th>
                <th> Procedimentos solicitados </th>
                <th> Procedimentos realizados </th>
                <th> Ações </th>
            </tr>
        </thread>
    <tbody>
<?php

        $sql_procedimentos = "SELECT user_id, procedimento_id, procedimento_solicitado, procedimento_realizado FROM procedimentos";
        $result_procedimentos = $conn->query($sql_procedimentos);

        if ($result_procedimentos->num_rows > 0) {
            while ($row_procedimentos = $result_procedimentos->fetch_assoc()) {
                $user_id = $row_procedimentos['user_id'];
                $procedimento_id = $row_procedimentos['procedimento_id'];
                $procedimento_solicitado = $row_procedimentos['procedimento_solicitado'];
                $procedimento_realizado = $row_procedimentos['procedimento_realizado'];

                echo "<tr>";
                echo "<td>$user_id</td>";
                echo "<td>$procedimento_solicitado</td>";
                echo "<td>$procedimento_realizado</td>";
                echo "<td>";
                echo "<a href='editar_procedimento.php?id=$procedimento_id'> Editar </a>  | ";  
                echo "<a href='excluir_procedimento.php?id=$procedimento_id'> Excluir </a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum procedimento cadastrado.</td></tr>";
        }
       
    $conn->close(); 

    ?>
    </tdbody>
    </table>   
    
    <br><a href="login_page.php" id="botao_sair"> Logout</a>
</div>
</div>
</body>
</html>

