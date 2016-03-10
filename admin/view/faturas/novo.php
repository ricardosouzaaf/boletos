<?php 
    /*
    Função CRUD
    */
    
    @$getId = base64_decode($_GET['id']); 
    if(@$getId){ 
    $alterar = mysql_query("SELECT * FROM financeiro WHERE id = + $getId");
    $campo = mysql_fetch_array($alterar);
    }

    if(isset ($_POST['cadastrar'])){
    
    $cliente = $_POST['cliente'];
    $pedido = rand(9,999999); 
    $valor = $_POST['valor'];
    $np = $_POST['parcelas']; 
    $vencimento = $_POST['vencimento'];
    $taxa = $_POST['taxa'];
    $banco = $_POST['banco']; 
    $obs = $_POST['obs']; 
    
    function calcularParcelas($cliente, $taxa, $pedido, $valor, $np, $obs, $vencimento = null){
    if($vencimento != null){
	$vencimento = explode( "/",$vencimento);
	$dia = $vencimento[0];
	$mes = $vencimento[1];
	$ano = $vencimento[2];
  	} else {
	$dia = date("d");
	$mes = date("m");
	$ano = date("Y");
  	}
 
 	for($x = 1; $x <= $np; $x++){
  	$parcela = date("Y-m-d",strtotime("+".$x." month",mktime(0, 0, 0,$mes,$dia,$ano)));

    	//INICIO 
    	$qr_numero = mysql_query("SELECT * FROM financeiro ORDER BY id DESC");
    	$row_numero = mysql_fetch_array($qr_numero);
    	$numero = str_pad($row_numero['id'], 9, 0, STR_PAD_LEFT);// tamanho 9
    	// FIM 

 	$prd = explode( "-",$parcela);
 	$diafn = $prd[2];
 	$mesfn = $prd[1];
 	$anofn = $prd[0];
        $nossonumero = $pedido."".$x."".$cliente;
 	
 	$cmm = ($mesfn - 01);
 	if($cmm == 0) {
 	$mescorre = '01';
 	} else { 
 	$mescorre = $cmm;
 	}
 	
 	$data_inicial = date('Y-m-d');
 	$data_final = $anofn."-".$mesfn."-".$diafn;
 	$diferenca = strtotime($data_final) - strtotime($data_inicial);
 	$dias = floor($diferenca / (60 * 60 * 24));
	  
 	$valorparcela = $valor / 30;
 	 
  	if(mysql_query("INSERT INTO financeiro (nfatura,cadastro,mesparcela,cliente,pedido,vencimento,parcelaum,valorparcela,dia,mes,ano,valor,taxa,boleto,obs,situacao,status) VALUES ('$x','$data_inicial','$mescorre','$cliente','$pedido','$parcela','$dias','$valorparcela','$diafn','$mesfn','$anofn','$valor','$taxa','$nossonumero','$obs','N','A')"))
  	{
  	} else {
	die("Erro ao inserir a parcela ".$x.": ".mysql_error());
  	}
	}// Fim For
	}// Fim Function

	calcularParcelas($cliente,$taxa,$pedido,$valor,$np,$obs,$vencimento);
   	
   	$idcliente = base64_encode($cliente);
   	$idpedido = base64_encode($pedido);
   	
    	if($banco == "CEF") { 	
	header("Location: ../config/carnephp/carne_caixa.php?pedido=$idpedido&cliente=$idcliente");
	}
	if($banco == "SANTANDER") { 	
	header("Location: ../config/carnephp/carne_santander.php?pedido=$idpedido&cliente=$idcliente");
	}
	if($banco == "BRADESCO") { 	
	header("Location: ../config/carnephp/carne_bradesco.php?pedido=$idpedido&cliente=$idcliente");
	}
	if($banco == "REAL") { 	
	header("Location: ../config/carnephp/carne_real.php?pedido=$idpedido&cliente=$idcliente");
	}
	if($banco == "BB") { 	
	header("Location: ../config/carnephp/carne_bb.php?pedido=$idpedido&cliente=$idcliente");
	}
	if($banco == "HSBC") { 	
	header("Location: ../config/carnephp/carne_hsbc.php?pedido=$idpedido&cliente=$idcliente");
	}
	if($banco == "ITAU") { 	
	header("Location: ../config/carnephp/carne_itau.php?pedido=$idpedido&cliente=$idcliente");
	}
	if($banco == "SICREDI") { 	
	header("Location: ../config/carnephp/carne_sicredi.php?pedido=$idpedido&cliente=$idcliente");
	}
	if($banco == "SICOOB") { 	
	header("Location: ../config/carnephp/carne_sicoob.php?pedido=$idpedido&cliente=$idcliente");
	}
	
    }
    $configs = mysql_query("SELECT * FROM empresa WHERE id = '1'");
    $config = mysql_fetch_array($configs);
?>

    
    
    <!-- C-HOME -->
        <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Criar Faturas</h2>
            </div>
            <div class="contentbox">
          <form method="post" action="index.php?cms=NovaFatura" class="block-content form" enctype="multipart/form-data">
            	
            
            <p>
            <label for="textfield"><strong>Sócio:</strong></label>
            <select id="cliente" name="cliente" class="inputbox" style="width:500px" required>
            <option value="">Selecione</option>
	    <?php
 	    $ccp = mysql_query("SELECT * FROM clientes order by turma ASC");
 	    while($clientes = mysql_fetch_array($ccp)){ 
	    ?>
	    <option value="<?php echo $clientes['id']; ?>"><?php echo $clientes['registro_aluno']; ?> - Aluno: <?php echo $clientes['aluno']; ?> - Turma <?php echo $clientes['turma']; ?></option>
	    <?php } ?> 
 	    </select><br>
 	    <span class="smltxt">(Selecione um Cliente)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Descrição:</strong></label>
            <input type="text" name="obs" id="textfield" value="<?php echo @$campo['obs']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">(Descrição dos Serviços Prestados)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Primeiro Vencimento:</strong></label>
            <input type="text" name="vencimento" id="textfield" value="<?php echo date('d/m/Y'); ?>" class="inputbox" style="width:200px" /> <br />
            <span class="smltxt">(Data Primeiro Vencimento)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Quantidade de Parcelas:</strong></label>
            <input type="text" name="parcelas" id="textfield" value="12" class="inputbox" style="width:200px" /> <br />
            <span class="smltxt">(Quantidade de Parcelas)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Valor da Fatura:</strong></label>
            <input type="text" name="valor" id="textfield" onKeyUp="moeda(this);" value="<?php echo @$campo['valor']; ?>" class="inputbox" style="width:120px" /> <br />
            <span class="smltxt">(Valor da Fatura)</span>
            </p>
            <p>
            <label for="textfield"><strong>Taxa da Fatura:</strong></label>
            <input type="text" name="taxa" id="textfield" onKeyUp="moeda(this);" value="<?php echo @$campo['taxa']; ?>" class="inputbox" style="width:120px" /> <br />
            <span class="smltxt">(Taxa da Fatura - Taxa do Carnê)</span>
            </p>
            
            
		  <input type="submit" name="cadastrar" class="btn btn-success" value="Cadastrar">
		 <?php if($config['banco'] == "CEF") { ?><input type="hidden" name="banco" value="CEF"><?php } ?>
            <?php if($config['banco'] == "BRADESCO") { ?><input type="hidden" name="banco" value="BRADESCO"><?php } ?>
            <?php if($config['banco'] == "ITAU") { ?><input type="hidden" name="banco" value="ITAU"><?php } ?>
            <?php if($config['banco'] == "SANTANDER") { ?><input type="hidden" name="banco" value="SANTANDER"><?php } ?>
            <?php if($config['banco'] == "HSBC") { ?><input type="hidden" name="banco" value="HSBC"><?php } ?>
            <?php if($config['banco'] == "REAL") { ?><input type="hidden" name="banco" value="REAL"><?php } ?>
            <?php if($config['banco'] == "SICOOB") { ?><input type="hidden" name="banco" value="SICOOB"><?php } ?>
            <?php if($config['banco'] == "SICREDI") { ?><input type="hidden" name="banco" value="SICREDI"><?php } ?>
            <?php if($config['banco'] == "BB") { ?><input type="hidden" name="banco" value="BB"><?php } ?>
		    
	<br>
	</form>
  
 </div>
        </div>
        <!-- FIM-CHome -->