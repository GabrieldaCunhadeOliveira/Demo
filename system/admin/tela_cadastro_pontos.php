
<html>
<head>
  <meta charset="utf-8">
  <title>Cadastro de pontos</title>
  <link rel="stylesheet" href="../../css/style_adm_points.css">
</head>
<script>
$(document).ready(function(){

  $(".botao").click(function(){
    var idColaborador =this.parentElement.parentElement.id;
    var valor = $('#valor_'+idColaborador).val();
    var quantidade = $('#quantidade_'+idColaborador).val();
    debugger;
    $.ajax({
          url : "back_tela_cadastro_pontos.php",
          type : 'post',
          data : {
                 valor : valor,
                 quantidade : quantidade,
                 idColaborador : idColaborador
            },
        })
        .done(function(msg){
          debugger;
          if(msg != "erro") {
            $("#" + idColaborador).css("background-color", "#ccffcc");
          }
        })
        .fail(function(jqXHR, textStatus, msg){
            alert(msg);
            debugger;
        });
  });
})
</script>
<body>
  <?php
  include "../../database/conexao_bd.php";
  ?>
  <div class="borda" style=" margin-top:3%;">
          <h4 style="text-align:center;">Colaboradores com metas</h4>
          <hr>
          <table class="table table-hover overflow-y">
            <thead  class="thead-dark">
              <tr>
                <th scope="col">CPF</th>
                <th scope="col">Nome</th>
                <th scope="col">Tipo</th>
                <th scope="col">Valor</th>
                <th scope="col">Quantidade</th>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody id="tabela">
              <?php
              if(isset($_POST)){
                // $sql = "SELECT * FROM colaboradores INNER JOIN metas_has_colaboradores where colaboradores.status = 0 AND colaboradores.tipo != 1";
                // $colaboradores  = mysqli_query($con, $sql);

                $arrayColaboradoresMetasGrupo = array();
                $colaboradores = array();

                $colaboradoresMetasGrupo = mysqli_query($con, "SELECT colaboradores.id, colaboradores.cpf, colaboradores.nome, colaboradores.tipo, colaboradores.status FROM colaboradores INNER JOIN colaboradores_has_grupos ON colaboradores_has_grupos.colaboradores_id=colaboradores.id INNER JOIN metas_has_colaboradores_has_grupos ON metas_has_colaboradores_has_grupos.colaboradores_has_grupos_id=colaboradores_has_grupos.id WHERE colaboradores.status = 0 AND colaboradores.tipo != 1 AND metas_has_colaboradores_has_grupos.status = 0");

                while($linha = mysqli_fetch_array($colaboradoresMetasGrupo, MYSQLI_ASSOC)) {
                   array_push($arrayColaboradoresMetasGrupo, $linha);
                }

                $colaboradoresMetasIndividuais = mysqli_query($con, "SELECT DISTINCT colaboradores.id, colaboradores.cpf, colaboradores.nome, colaboradores.tipo, colaboradores.status FROM colaboradores INNER JOIN metas_has_colaboradores ON metas_has_colaboradores.colaboradores_id=colaboradores.id WHERE colaboradores.status = 0 AND colaboradores.tipo != 1 AND metas_has_colaboradores.status = 0");
                
                while($linha2 = mysqli_fetch_array($colaboradoresMetasIndividuais, MYSQLI_ASSOC)) {
                   array_push($colaboradores, $linha2);
                }

                for($i = 0; $i < sizeof($colaboradores); $i++){
                  if (!in_array($colaboradores[$i], $arrayColaboradoresMetasGrupo)) { 
                      array_push($arrayColaboradoresMetasGrupo, $colaboradores[$i]);
                  }
                }

                foreach($arrayColaboradoresMetasGrupo AS $colaborador):
                  $idColaborador = $colaborador['id'];
              ?>
              <!-- <form action="back_tela_cadastro_pontos.php" method="POST"> -->
                <tr id="<?php echo $idColaborador ?>">
                  <td><?php echo $colaborador['cpf'];?></td>
                  <td><?php echo $colaborador['nome'];?></td>
                  <?php if ($colaborador['tipo'] == 2){ ?>
                    <td><?php echo "Líder"; ?></td>
                  <?php }else if($colaborador['tipo'] == 3) { ?>
                    <td><?php echo "Usuário comum"; ?></td>
                  <?php } ?>
                  <td><input type="number" class="form-control" name="valor" id="valor_<?php echo $idColaborador ?>" aria-describedby="Valor" placeholder="Digite o valor" required></td>
                  <td><input type="number" class="form-control" id="quantidade_<?php echo $idColaborador ?>" name="quantidade" aria-describedby="Quantidade" placeholder="Digite a quantidade" required></td>
                  <td><input type="hidden" class="form-control" id="idColaborador_<?php echo $idColaborador ?>" name="idColaborador" value="<?php echo $idColaborador ?>"></td>
                  <td><button type="submit" class="btn btn-success botao" name="editar">Enviar</button></td>
                </tr>
              <!-- </form> -->
              <?php
                endforeach;
              }
              ?>
            </tbody>
          </table>
      </div>
    </div>
</body>
</html>
