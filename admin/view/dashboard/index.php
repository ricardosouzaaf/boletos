<?php

$mss1 = mysql_query("SELECT * FROM financeiro WHERE situacao = 'P'");
$pagos = mysql_num_rows($mss1); 

$mss2 = mysql_query("SELECT * FROM financeiro WHERE situacao = 'C'");
$cancelados = mysql_num_rows($mss2); 

$mss3 = mysql_query("SELECT * FROM financeiro WHERE situacao = 'N'");
$abertas = mysql_num_rows($mss3); 

$mss4 = mysql_query("SELECT * FROM clientes");
$clientes = mysql_num_rows($mss4); 

$erts = mysql_query("SELECT SUM(valor) as valor FROM financeiro WHERE situacao = 'P'");
$xv = mysql_fetch_array($erts);
$totalpago = $xv['valor'];

$ertd = mysql_query("SELECT SUM(valor) as valor FROM financeiro WHERE situacao = 'C'");
$xe = mysql_fetch_array($ertd);
$totalcancelado = $xe['valor'];

$ertw = mysql_query("SELECT SUM(valor) as valor FROM financeiro WHERE situacao = 'N'");
$xz = mysql_fetch_array($ertw);
$totalaberto = $xz['valor'];

?>
         <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Gestor de Faturas</h2>
            </div>
            <div class="contentbox">
            
            <br>
            <b>TOTAL DE CLIENTES: <?php echo $clientes; ?></b><hr size="1">
            
            <b>FATURAS PAGAS: <?php echo $pagos; ?></b><hr size="1">
            <b>FATURAS CANCELADAS: <?php echo $cancelados; ?></b><hr size="1">
            <b>FATURAS EM ABERTO: <?php echo $abertas; ?></b><hr size="1">
            
            <b>TOTAL PAGO: R$ <?php echo number_format($totalpago,2,',','.'); ?></b><hr size="1">
            <b>TOTAL CANCELADO: R$ <?php echo number_format($totalcancelado,2,',','.'); ?></b><hr size="1">
            <b>TOTAL EM ABERTO: R$ <?php echo number_format($totalaberto,2,',','.'); ?></b><hr size="1">
            </div> </div> 
