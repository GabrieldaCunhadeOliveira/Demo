<?php
  $id     = $_GET['id'];
  $msg    = "";
  $status = "danger";

  include "../../../database/conexao_bd.php";
  $sql_del  = "DELETE FROM `colaboradores` WHERE id='$id'";
  $result = mysqli_query($con, $sql_del);
  if ($result) {
    $msg  = "Usuário excluído com sucesso";
    $status ="success";
  }  else{
    $msg = "Erro ao excluír";
  }
  header("Location: ../navbar.php?folder=users_cad&file=tela_editar_usuario.php&status=".$status."&mensagem=".$msg."");
?>
