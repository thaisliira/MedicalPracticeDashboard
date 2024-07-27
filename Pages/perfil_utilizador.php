<?php
session_start();

if(!isset($_SESSION['user_id'])) {
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
    $email = $row['email'];

} else {
    echo "Perfil de usuário não encontrado.";
}

$conn->close();
?>

<DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title> Perfil do Usuário </title>
<link href="style/styleuser.css" rel="stylesheet">
<style>
body{
	background: url('images/bgimagem.jpg');
}

th, td {
    font-size: 13px;
}

.error-message {
	background: #ffffff;
	color: red;
    font-size:16px;
    font-weight: bold;
    text-align:left;
}

</style>
</head>
<body>

<div class="caixa1">
<img src="images/paciente.jpg" width="190" id="user_image">
<h1 style="text-align: left;"> Perfil do Usuário </h1>
<h4> Olá, <?php echo $nome; ?>! </h4>

<?php
    if (isset($_SESSION['error_message'])) {
        echo '<p class="error-message">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']); // Limpa a mensagem de erro da variável de sessão
    }
    ?>
   
<?php

if(!isset($_SESSION['user_id'])) {
    header("Location:login_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];
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
$user_name = $row['user_name'];
$password = $row['password'];
$email = $row['email'];

} else {
echo "Perfil de usuário não encontrado.";
}
$conn->close();
?>

<br>
<div class="tabela">
    <h2> Os teus dados: </h2>
     
    <table class="tabela-usuario">
        <tr>
            <th> Nome </th>
            <th> Apelido </th>
            <th> Username </th>
            <th> Email </th>
            <th> Password </th>
            <th> Ação </th>
        </tr>
        <tr>
            <td><?php echo $nome; ?></td>
            <td><?php echo $apelido; ?></td>
            <td><?php echo $user_name; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $password; ?></td>
            <td><?php echo "<a href='editar_dados.php?id=$user_id'> Editar dados </a>"; ?></td>
        </tr>
    </table>

    <h2> Marcar consulta </h2>
    <form method = "POST" action="agendar_consulta.php">
        <label for="data_consulta"> Data da consulta </label>
        <input type="date" id="data_consulta" name="data_consulta" required> <br><br>

        <label for="horario"> Hora da consulta </label>
        <input type="time" id ="horario" name="horario" required> <br> <br>

        <input type="submit" value="Marcar consulta" class="botao verde">
    </form>
    <table class="tabela-usuario">
        <thread>
            <tr>
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
    $sql = "SELECT id, DATE_FORMAT(data_consulta, '%d/%m/%Y') AS data_formatada, horario, status FROM consultas WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $consulta_id = $row['id'];
            $data_consulta = $row['data_formatada'];
            $horario = $row['horario'];
            $status = $row['status'];
                
        echo "<tr>";
        echo "<td>$data_consulta</td>";
        echo "<td>$horario</td>";
        echo "<td>$status</td>";
        echo "<td>";
        echo "<a href='editar_consulta.php?id=$consulta_id'> Editar </a>  | ";  
        echo "<a href='excluir_consulta.php?id=$consulta_id'> Excluir </a>"; 
        echo "</td>";
        echo "</tr>";
        }
    } else {
        echo "<tr> <td colspan='3'> Nenhuma consulta agendada. </td></tr>";
    }

    $conn->close(); 

    ?>
    </tbody>
</table>

<h2>Motivo da Consuta</h2>
    <form action="procedimentos.php" method="POST">
       
    <label for ="procedimento_solicitado">Tipos de procedimentos:</label>
    <select name="procedimento_solicitado"  id="procedimento_solicitado" required>
    <option value="Cirurgia">Cirurgia</option>
    <option value="Periodontia">Periodontia</option>
    <option value="Dentistica">Dentistica</option>
    <option value="Endodontia">Endodontia</option>
    </select>
          
    <input type="submit" class="botao" value="Confirmar">
    </form>

    <table class="procedimentos">
        <thread>
            <tr>
                <th> Procedimentos solicitados </th>
                <th> Procedimentos realizados (preenchido pelo Dentista) </th>
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
    $sql = "SELECT procedimento_solicitado, procedimento_realizado FROM procedimentos WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $procedimento_solicitado = $row['procedimento_solicitado'];
            $procedimento_realizado = $row['procedimento_realizado'];
        
        echo "<tr>";
        echo "<td>$procedimento_solicitado</td>";
        echo "<td>$procedimento_realizado</td>";
        echo "</tr>";
        }
    } else {
        echo "<tr> <td colspan='3'> Nenhum procedimento solicitado. </td></tr>";
    }

    $conn->close(); 

    ?>
    </table>   
    
    <br><a href="login_page.php" id="botao_sair"> Logout</a>
</div>
</div>
</body>
</html>

