    	<?php if(@$_GET['reg'] == "1") { ?>
        <div class="status success">
        	<p class="closestatus"><a href="?cms=Pagos" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_success.png" alt="" /><span>Atenção!</span> Arquivo de retorno processado com sucesso.</p>
        </div>
     	<?php } ?>
     	
         <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Gerenciar Faturas Pagas</h2>
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
        </tr>
    </tfoot>
 
    <tbody>
    <?php
    $configs = mysql_query("SELECT * FROM empresa WHERE id = '1'");
    $config = mysql_fetch_array($configs);
    
    $consultas = mysql_query("SELECT * FROM financeiro WHERE situacao = 'P' order by vencimento DESC");
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
            <td><?php echo $cliente['nome']; ?><br><small><?php echo $cliente['doc']; ?></small></td>
            <td><?php echo $cliente['email']; ?></td>
            <td><?php echo $campo['dia']; ?>/<?php echo $campo['mes']; ?>/<?php echo $campo['ano']; ?></td>
            <td>R$ <?php echo number_format($campo['valor'],2,',','.'); ?></td>
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