<?php

   
    if ((isset($_GET["del"])) && ($_GET["del"] == "ext")) {
    $registroid = $_GET['id']; // pega id para exclusao caso exista
    $idr = $_GET['idr'];
        
    $assvalida = mysql_query("SELECT * FROM financeiro WHERE cliente = '$registroid' AND situacao = 'N'");
    $assvld = mysql_fetch_array($assvalida);
    $row = mysql_num_rows($assvalida);
    
    if($row > 0) {
    header("Location: index.php?cms=Clientes&id=$idr&reg=4");
    } else {
    
    $crud = new crud('clientes'); // tabela como parametro
    $crud->excluir("id = $registroid"); // exclui o registro com o id que foi passado
    
    header("Location: index.php?cms=Clientes&id=$idr&reg=3");
    }
    }
    ?>
    
    
    	<?php if(@$_GET['reg'] == "1") { ?>
        <div class="status success">
        	<p class="closestatus"><a href="?cms=Clientes" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_success.png" alt="" /><span>Atenção!</span> Sócio cadastrado com sucesso.</p>
        </div>
     	<?php } ?>
     	<?php if(@$_GET['reg'] == "2") { ?>
     	<div class="status info">
        	<p class="closestatus"><a href="?cms=Clientes" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_info.png" alt="" /><span>Atenção:</span> Sócio alterado com sucesso.</p>
        </div>
     	<?php } ?>
     	<?php if(@$_GET['reg'] == "3") { ?>
        <div class="status error">
        	<p class="closestatus"><a href="?cms=Clientes" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_error.png" alt="" /><span>Atenção!</span> Sócio excluído com sucesso.</p>
        </div>
      	<?php } ?>
      <?php if(@$_GET['reg'] == "4") { ?>
        <div class="status error">
        	<p class="closestatus"><a href="?cms=Clientes" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_error.png" alt="" /><span>Atenção!</span> Sócio possui faturas abertas não é possível excluir.</p>
        </div>
      	<?php } ?>
	 
         <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Gerenciar Cadastros de Sócio</h2>
            </div>
            <div class="contentbox">
      
 <table id="produtos" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Sócio</th>
            <th>Situação</th>
            <th>Email</th>
            <th>Aluno</th>
            <th>Número / Turma</th>
            <th>Abertas</th>
            <th>Pagas</th>
            <th width="90">Ações</th>
        </tr>
    </thead>
   
    <tfoot>
        <tr>
            <th>Sócio</th>
            <th>Situação</th>
            <th>Email</th>
            <th>Aluno</th>
            <th>Número / Turma</th>
            <th>Abertas</th>
            <th>Pagas</th>
            <th width="90">Ações</th>
        </tr>
    </tfoot>
 
    <tbody>
    <?php
    $consultas = mysql_query("SELECT * FROM clientes order by nome ASC");
    while($campo = mysql_fetch_array($consultas)){ 

    $idc = $campo['id'];
    $abertas = mysql_query("SELECT * FROM financeiro WHERE cliente = '$idc' AND situacao = 'N'");
    $abertas = mysql_num_rows($abertas);
    
    $pagas = mysql_query("SELECT * FROM financeiro WHERE cliente = '$idc' AND situacao = 'S'");
    $pagas = mysql_num_rows($pagas);
    ?>
        <tr>

            <td><?php echo $campo['nome']; ?></td>

                <?php 
                    if($campo['situacao'] == 1){
                        ?>
                        <td><span style="color:green;">Ativo</span></td>
                        <?php } else { ?>
                        <td><span style="color:red;">Inativo</span></td>
                        <?php
                    }
                ?>
           
            <td><?php echo $campo['email']; ?></td>
            <td><?php echo $campo['aluno']; ?></td>
            <td><?php echo $campo['registro_aluno']; ?>/ <?php echo $campo['turma']; ?></td>
            <td><?php echo $abertas; ?> Faturas</td>
 	    <td><?php echo $abertas; ?> Faturas</td>
            <td>
          
	    <a href="index.php?cms=CadastroCliente&id=<?php echo base64_encode($campo['id']); ?>" title="Editar Registro"><img src="assets/img/editar.png" alt="Editar" /></a>&nbsp;&nbsp;
                          		                       
          <a href="javascript:void(0);" onclick="javascript: if (confirm('Deseja realmente excluir esse cliente ?')) { window.location.href='index.php?cms=Clientes&id=<?php echo @$campo['id']; ?>&del=ext' } else { void('') };"><img src="assets/img/excluir.png" alt="Excluir" /></a>
	    
	    
	    
	    
	    </td>
        </tr>
      <?php } ?> 
    </tbody>
</table>
            
        </div> </div> 
<script>
$(document).ready(function() {
    $('#produtos').DataTable();
} );
</script>