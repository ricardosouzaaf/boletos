<?php

    if ((isset($_GET["del"])) && ($_GET["del"] == "ext")) {
    $registroid = $_GET['id']; // pega id para exclusao caso exista
    $idr = $_GET['idr'];
    
    $assvalida = mysql_query("SELECT * FROM financeiro WHERE id = '$registroid' AND situacao = 'P'");
    $assvld = mysql_fetch_array($assvalida);
    $row = mysql_num_rows($assvalida);
    
    if($row > 0) {
    header("Location: index.php?cms=Faturas&id=$idr&reg=4");
    } else {
    
    $crud = new crud('financeiro'); // tabela como parametro
    $crud->excluir("id = $registroid"); // exclui o registro com o id que foi passado
    
    header("Location: index.php?cms=Faturas&id=$idr&reg=3");
    }
    }
    ?>
    
    
    	<?php if(@$_GET['reg'] == "1") { ?>
        <div class="status success">
        	<p class="closestatus"><a href="?cms=Cancelados" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_success.png" alt="" /><span>Atenção!</span> Faturas cadastradas com sucesso.</p>
        </div>
     	<?php } ?>
     	<?php if(@$_GET['reg'] == "2") { ?>
     	<div class="status info">
        	<p class="closestatus"><a href="?cms=Cancelados" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_info.png" alt="" /><span>Atenção:</span> Fatura alterada com sucesso.</p>
        </div>
     	<?php } ?>
     	<?php if(@$_GET['reg'] == "3") { ?>
        <div class="status error">
        	<p class="closestatus"><a href="?cms=Cancelados" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_error.png" alt="" /><span>Atenção!</span> Fatura excluída com sucesso.</p>
        </div>
      	<?php } ?>
      <?php if(@$_GET['reg'] == "4") { ?>
        <div class="status error">
        	<p class="closestatus"><a href="?cms=Cancelados" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_error.png" alt="" /><span>Atenção!</span> Fatura paga não é possível excluir.</p>
        </div>
      	<?php } ?>
	 
         <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Gerenciar Faturas Canceladas</h2>
            </div>
            <div class="contentbox">
    
 <table id="produtos" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Pedido</th>
            <th>Fatura</th>
            <th>Cliente</th>
            <th>Email</th>
            <th>Vencimento</th>
            <th>Valor</th>
            <th width="90">Ações</th>
        </tr>
    </thead>
   
    <tfoot>
        <tr>
            <th>Pedido</th>
            <th>Fatura</th>
            <th>Cliente</th>
            <th>Email</th>
            <th>Vencimento</th>
            <th>Valor</th>
            <th width="90">Ações</th>
        </tr>
    </tfoot>
 
    <tbody>
    <?php
    $configs = mysql_query("SELECT * FROM empresa WHERE id = '1'");
    $config = mysql_fetch_array($configs);
    
    $consultas = mysql_query("SELECT * FROM financeiro WHERE situacao = 'C' order by vencimento DESC");
    while($campo = mysql_fetch_array($consultas)){ 
    $idc = $campo['cliente'];
    $clientes = mysql_query("SELECT * FROM clientes WHERE id = '$idc'");
    $cliente = mysql_fetch_array($clientes);

    $data_inicial = date('Y-m-d');
    $data_final = $campo['vencimento'];
    $time_inicial = strtotime($data_inicial);
    $time_final = strtotime($data_final);
    $diferenca = $time_final - $time_inicial; 
    $dias = (int)floor( $diferenca / (60 * 60 * 24)); 
    ?>
        <tr>

            <td><?php echo $campo['pedido']; ?><br><small><?php echo $campo['obs']; ?></small></td>
            <td><?php echo $campo['boleto']; ?></td>
            <td><?php echo $cliente['nome']; ?></td>
            <td><?php echo $cliente['email']; ?></td>
            <td><?php if($dias < 10) { ?><span style="color:red;"><? } else { ?><?php } ?> <?php echo $campo['dia']; ?>/<?php echo $campo['mes']; ?>/<?php echo $campo['ano']; ?><br><small>
	    <b>Vence em: <?php echo $dias; ?> Dias</b></td>
            <td>R$ <?php echo number_format($campo['valor'],2,',','.'); ?></td>
            
            <td>
            <?php if($config['banco'] == "CEF") { ?>
            <a href="../config/carnephp/cn_caixa.php?cliente=<?php echo base64_encode($campo['cliente']); ?>&pedido=<?php echo base64_encode($campo['pedido']); ?>" title="Gerar Carnês" target=_blank><img src="assets/img/atualizar.png" alt="Gerar Carnês" /></a>&nbsp;&nbsp;<?php } ?>
            <?php if($config['banco'] == "BRADESCO") { ?>
            <a href="../config/carnephp/cn_bradesco.php?cliente=<?php echo base64_encode($campo['cliente']); ?>&pedido=<?php echo base64_encode($campo['pedido']); ?>" title="Gerar Carnês" target=_blank><img src="assets/img/atualizar.png" alt="Gerar Carnês" /></a>&nbsp;&nbsp;<?php } ?>
            <?php if($config['banco'] == "ITAU") { ?>
            <a href="../config/carnephp/cn_itau.php?cliente=<?php echo base64_encode($campo['cliente']); ?>&pedido=<?php echo base64_encode($campo['pedido']); ?>" title="Gerar Carnês" target=_blank><img src="assets/img/atualizar.png" alt="Gerar Carnês" /></a>&nbsp;&nbsp;<?php } ?>
            <?php if($config['banco'] == "SANTANDER") { ?>
            <a href="../config/carnephp/cn_santander.php?cliente=<?php echo base64_encode($campo['cliente']); ?>&pedido=<?php echo base64_encode($campo['pedido']); ?>" title="Gerar Carnês" target=_blank><img src="assets/img/atualizar.png" alt="Gerar Carnês" /></a>&nbsp;&nbsp;<?php } ?>
            <?php if($config['banco'] == "HSBC") { ?>
            <a href="../config/carnephp/cn_hsbc.php?cliente=<?php echo base64_encode($campo['cliente']); ?>&pedido=<?php echo base64_encode($campo['pedido']); ?>" title="Gerar Carnês" target=_blank><img src="assets/img/atualizar.png" alt="Gerar Carnês" /></a>&nbsp;&nbsp;<?php } ?>
            <?php if($config['banco'] == "REAL") { ?>
            <a href="../config/carnephp/cn_real.php?cliente=<?php echo base64_encode($campo['cliente']); ?>&pedido=<?php echo base64_encode($campo['pedido']); ?>" title="Gerar Carnês" target=_blank><img src="assets/img/atualizar.png" alt="Gerar Carnês" /></a>&nbsp;&nbsp;<?php } ?>
            <?php if($config['banco'] == "SICOOB") { ?>
            <a href="../config/carnephp/cn_sicoob.php?cliente=<?php echo base64_encode($campo['cliente']); ?>&pedido=<?php echo base64_encode($campo['pedido']); ?>" title="Gerar Carnês" target=_blank><img src="assets/img/atualizar.png" alt="Gerar Carnês" /></a>&nbsp;&nbsp;<?php } ?>
            <?php if($config['banco'] == "SICREDI") { ?>
            <a href="../config/carnephp/cn_sicredi.php?cliente=<?php echo base64_encode($campo['cliente']); ?>&pedido=<?php echo base64_encode($campo['pedido']); ?>" title="Gerar Carnês" target=_blank><img src="assets/img/atualizar.png" alt="Gerar Carnês" /></a>&nbsp;&nbsp;<?php } ?>
            <?php if($config['banco'] == "BB") { ?>
            <a href="../config/carnephp/cn_bb.php?cliente=<?php echo base64_encode($campo['cliente']); ?>&pedido=<?php echo base64_encode($campo['pedido']); ?>" title="Gerar Carnês" target=_blank><img src="assets/img/atualizar.png" alt="Gerar Carnês" /></a>&nbsp;&nbsp;<?php } ?>
            
            
            
            
	    <a href="index.php?cms=CadastroFatura&id=<?php echo base64_encode($campo['id']); ?>" title="Editar Registro"><img src="assets/img/editar.png" alt="Editar" /></a>&nbsp;&nbsp;
                          		                       
          <a href="javascript:void(0);" onclick="javascript: if (confirm('Deseja realmente excluir essa fatura ?')) { window.location.href='index.php?cms=Faturas&id=<?php echo @$campo['id']; ?>&del=ext' } else { void('') };"><img src="assets/img/excluir.png" alt="Excluir" /></a>
	    
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