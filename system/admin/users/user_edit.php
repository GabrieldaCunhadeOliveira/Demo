<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bd_fito";

session_start();

if ($_SESSION['id_sessao']  == session_id())
{
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
    mysqli_set_charset($conn, "utf8");

    $status = "error";

    $sx = $_POST['sex'] == 'Masculino' ? 1 : 2;
    $cpf = $_POST['cpf'];

    if ($_POST['cpf'] != $_SESSION['cpf']) 
    {
        $st = $_POST['status'] == 'Ativo' ? 0 : 1;
        $ty = $_POST['usertype'] == 'Administrador' ? '1' : ($_POST['usertype'] == 'Líder' ? '2' : '3');
        $q = "UPDATE colaboradores SET email = '{$_POST['email']}', nome = '{$_POST['name']}', sexo = {$sx}, tipo = {$ty}, status = $st WHERE cpf='{$cpf}'";
    }
    else $q = "UPDATE colaboradores SET email = '{$_POST['email']}', nome = '{$_POST['name']}', sexo = {$sx} WHERE cpf='{$cpf}'";

    if ($conn->query($q) === TRUE) $status = "ok";

    echo "status:{$status}";
}
else die;
?>
