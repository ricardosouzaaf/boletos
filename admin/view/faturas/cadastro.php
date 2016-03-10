<?php 
    /*
    Função CRUD
    */
    
    @$getId = base64_decode($_GET['id']); 
    if(@$getId){ 
    $alterar = mysql_query("SELECT * FROM financeiro WHERE id = + $getId");
    $campo = mysql_fetch_array($alterar);
    }

    if(isset ($_POST['editar'])){
    
    $valor = $_POST['valor'];
    $taxa = $_POST['taxa'];
    $situacao = $_POST['situacao'];
    $faturaid = $_POST['faturaid'];
    
    $crud = new crud('financeiro'); // instancia classe com as operações crud, passando o nome da tabela como parametro
    $crud->atualizar("valor='$valor',taxa='$taxa',situacao='$situacao'", "id='$faturaid'"); 
   
    header("Location: index.php?cms=Faturas&id=$idcurso&reg=2");
    }
?>

    
    
    <!-- C-HOME -->
        <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Alterar Fatura #<?php echo $campo['boleto']; ?></h2>
            </div>
            <div class="contentbox">
          <form method="post" action="index.php?cms=CadastroFatura" class="block-content form" enctype="multipart/form-data">
            	
            <p>
            <label for="textfield"><strong>Valor da Fatura:</strong></label>
            <input type="text" name="valor" id="textfield" onKeyUp="moeda(this);" value="<?php echo @$campo['valor']; ?>" class="inputbox" style="width:120px" required/> <br />
            <span class="smltxt">(Valor da Fatura)</span>
            </p>
            <p>
            <label for="textfield"><strong>Taxa da Fatura:</strong></label>
            <input type="text" name="taxa" id="textfield" onKeyUp="moeda(this);" value="<?php echo @$campo['taxa']; ?>" class="inputbox" style="width:120px" /> <br />
            <span class="smltxt">(Taxa da Fatura)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Vencimento:</strong></label>
            <input type="text" name="dia" placeholder="Dia" id="textfield" value="<?php echo @$campo['dia']; ?>" class="inputbox" style="width:60px" required/>
	    <input type="text" name="mes" placeholder="Mês" id="textfield" value="<?php echo @$campo['mes']; ?>" class="inputbox" style="width:60px" required/>
	    <input type="text" name="ano" placeholder="Ano" id="textfield" value="<?php echo @$campo['ano']; ?>" class="inputbox" style="width:60px" required/> <br />
            <span class="smltxt">(Dia/Mês/Ano)</span>
            </p>
            
            <p><label for="textfield"><strong>Situação da Fatura</strong></label>
	    <input type="radio" name="situacao" value="P" <? if(@$campo[situacao] == "P"){ echo  "checked";}?> required>  Fatura Paga
            <input type="radio" name="situacao" value="N" <? if(@$campo[situacao] == "N"){ echo  "checked";}?>>  Em Aberto 
            <input type="radio" name="situacao" value="C" <? if(@$campo[situacao] == "C"){ echo  "checked";}?>>  Cancelado
	    </p>
         
                    <?php if (@$campo['id'] <> '') { ?>
		  <input type="submit" name="editar" class="btn btn-info" value="Atualizar">
		  <input type="hidden" name="faturaid" value="<?php echo @$campo['id']; ?>"> 
		  <? } else { ?>
		  <input type="submit" name="cadastrar" class="btn btn-success" value="Cadastrar">
		  <?php } ?>
		    
	<br>
	</form>
  
 </div>
        </div>
        <!-- FIM-CHome -->