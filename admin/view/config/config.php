<?php 
    /*
    Função CRUD
    */

    $alterar = mysql_query("SELECT * FROM empresa WHERE id = '1'");
    $campo = mysql_fetch_array($alterar);
   					
    if(isset ($_POST['editar'])){
    
    $empresa = $_POST['empresa'];
    $cnpj = $_POST['cnpj'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $receberate = $_POST['receberate'];
    $instrucoes1 = $_POST['instrucoes1'];
    $instrucoes2 = $_POST['instrucoes2'];
    $carteira = $_POST['carteira'];
    $agencia = $_POST['agencia'];
    $digito_ag = $_POST['digito_ag'];
    $conta = $_POST['conta'];
    $digito_co = $_POST['digito_co'];
    $tipo_carteira = $_POST['tipo_carteira'];
    $convenio = $_POST['convenio'];
    $contrato = $_POST['contrato'];
    $email = $_POST['email'];
    $url = $_POST['url'];
    $banco = $_POST['banco'];
      
    $crud = new crud('empresa'); // instancia classe com as operações crud, passando o nome da tabela como parametro
    $crud->atualizar("empresa='$empresa',cnpj='$cnpj',endereco='$endereco',cidade='$cidade',estado='$estado',receberate='$receberate',instrucoes1='$instrucoes1',banco='$banco',instrucoes2='$instrucoes2',carteira='$carteira',agencia='$agencia',digito_ag='$digito_ag',conta='$conta',digito_co='$digito_co',tipo_carteira='$tipo_carteira',convenio='$convenio',contrato='$contrato',email='$email',url='$url'", "id='1'"); 
   
    header("Location: index.php?cms=Configuracoes&reg=2");
    }


?>

    <?php if(@$_GET['reg'] == "2") { ?>
     	<div class="status info">
        	<p class="closestatus"><a href="?cms=Configuracoes" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_info.png" alt="" /><span>Atenção:</span> Configurações alteradas com sucesso.</p>
        </div>
     	<?php } ?>
    
    <!-- C-HOME -->
        <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Configurações </h2>
            </div>
            <div class="contentbox">
          <form method="post" action="index.php?cms=Configuracoes" class="block-content form" enctype="multipart/form-data">
            	
            <p>
            <label for="textfield"><strong>Cedente / CNPJ:</strong></label>
            <input type="text" name="empresa" id="textfield" placeholder="Cedente" value="<?php echo @$campo['empresa']; ?>" class="inputbox" style="width:240px" />
	    <input type="text" name="cnpj" placeholder="CNPJ" id="textfield" value="<?php echo @$campo['cnpj']; ?>" class="inputbox" style="width:240px" /> <br />
            <span class="smltxt">(Razão Social / CNPJ Empresa)</span>
            </p>
	    
	    <p>
            <label for="textfield"><strong>E-mail:</strong></label>
            <input type="text" name="email" id="textfield" value="<?php echo @$campo['email']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">(Email do Cedente)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>URL:</strong></label>
            <input type="text" name="url" id="textfield" value="<?php echo @$campo['url']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">(URL do Sistema Ex: http://www.seusite.com.br/)</span>
            </p>
	    
	    <p>
            <label for="textfield"><strong>Endereço:</strong></label>
            <input type="text" name="endereco" id="textfield" value="<?php echo @$campo['endereco']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">Endereço Completo, Número, Complemento, Bairro</span>
            </p>
	    
	    <p>
            <label for="textfield"><strong>Cidade / Estado:</strong></label>
            <input type="text" name="cidade" id="textfield" placeholder="Cidade" value="<?php echo @$campo['cidade']; ?>" class="inputbox" style="width:240px" /> 
	    <input type="text" name="estado" placeholder="Estado" id="textfield" value="<?php echo @$campo['estado']; ?>" class="inputbox" style="width:240px" /><br />
            <span class="smltxt">(Cidade / Estado Cedente)</span>
            </p>
	    
	     <p>
            <label for="textfield"><strong>Banco:</strong></label>
	    <select name="banco" class="inputbox">
                      <option value="BB" <? if(@$campo[banco] == "BB"){ echo  "selected";}?>>Banco do Brasil</option>
                      <option value="BRADESCO" <? if(@$campo[banco] == "BRADESCO"){ echo  "selected";}?>>Bradesco</option>
                      <option value="CEF" <? if(@$campo[banco] == "CEF"){ echo  "selected";}?>>Caixa Ecônomica Federal</option>
                      <option value="ITAU" <? if(@$campo[banco] == "ITAU"){ echo  "selected";}?>>Itaú</option>
                      <option value="SANTANDER" <? if(@$campo[banco] == "SANTANDER"){ echo  "selected";}?>>Santander</option>
                      <option value="SICOOB" <? if(@$campo[banco] == "SICOOB"){ echo  "selected";}?>>Sicoob</option>
                      <option value="SICREDI" <? if(@$campo[banco] == "SICREDI"){ echo  "selected";}?>>Sicredi</option>
                      <option value="HSBC" <? if(@$campo[banco] == "HSBC"){ echo  "selected";}?>>HSBC</option>
                      <option value="REAL" <? if(@$campo[banco] == "REAL"){ echo  "selected";}?>>Banco Real</option>
                      </select><br />
            <span class="smltxt">(Banco Emissor)</span>
            </p>
	    
	    <p>
            <label for="textfield"><strong>Instruções 1:</strong></label>
            <input type="text" name="instrucoes1" id="textfield" value="<?php echo @$campo['instrucoes1']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">Instruções do Boleto</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Instruções 2:</strong></label>
            <input type="text" name="instrucoes2" id="textfield" value="<?php echo @$campo['instrucoes2']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">Instruções do Boleto</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Agência / Conta:</strong></label>
            <input type="text" name="agencia" id="textfield" placeholder="Agência" value="<?php echo @$campo['agencia']; ?>" class="inputbox" style="width:147px;" /> 
	    <input type="text" name="digito_ag" placeholder="Digito AG" id="textfield" value="<?php echo @$campo['digito_ag']; ?>" class="inputbox" style="width:60px" />
	    <input type="text" name="conta" id="textfield" placeholder="Conta" value="<?php echo @$campo['conta']; ?>" class="inputbox" style="width:147px;" /> 
	    <input type="text" name="digito_co" placeholder="Digito Conta" id="textfield" value="<?php echo @$campo['digito_co']; ?>" class="inputbox" style="width:60px" />
	    <br />
            <span class="smltxt">(Agência / Conta)</span>
            </p>
	    	
	    	
	    <p>
            <label for="textfield"><strong>Obs: Alguns bancos não utilizam os campos abaixo. <br>Caso o banco não utilize o campo, deixar em branco:</strong></label>
            <input type="text" name="carteira" id="textfield" placeholder="Carteira" value="<?php echo @$campo['carteira']; ?>" class="inputbox" style="width:100px;" /> 
	    <input type="text" name="tipo_carteira" placeholder="Tipo Carteira" id="textfield" value="<?php echo @$campo['tipo_carteira']; ?>" class="inputbox" style="width:100px" />
	    <input type="text" name="contrato" id="textfield" placeholder="Contrato" value="<?php echo @$campo['contrato']; ?>" class="inputbox" style="width:105px;" /> 
	    <input type="text" name="convenio" placeholder="Convênio" id="textfield" value="<?php echo @$campo['convenio']; ?>" class="inputbox" style="width:105px" />
	    <br />
            <span class="smltxt">(Carteira, Tipo de Carteira, Contrato, Convênio)</span>
            </p>	
            	
            
                    <?php if (@$campo['id'] <> '') { ?>
		  <input type="submit" name="editar" class="btn btn-info" value="Atualizar">
		  <? } else { ?>
		  <input type="submit" name="cadastrar" class="btn btn-success" value="Cadastrar">
		  <?php } ?>
		    
	<br>
	</form>
  
 </div>
        </div>
        <!-- FIM-CHome -->