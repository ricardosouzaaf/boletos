<?php 
    /*
    Fun��o CRUD
    */
    
    @$getId = base64_decode($_GET['id']); 
    if(@$getId){ 
    $alterar = mysql_query("SELECT * FROM clientes WHERE id = + $getId");
    $campo = mysql_fetch_array($alterar);
    }
					
    if(isset ($_POST['cadastrar'])){ 

    $nome = $_POST['nome'];
    $doc = $_POST['doc'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $aluno = $_POST['aluno'];
    $registro_aluno = $_POST['registro_aluno'];
    $turma = $_POST['turma'];
    if(isset($_POST['situacao'])) $situacao = 1; else $situacao = 0;
    

    
    $crud = new crud('clientes');  // tabela como parametro
    $crud->inserir("nome,doc,email,endereco,aluno,turma,registro_aluno,situacao", "'$nome','$doc','$email','$endereco','$aluno','$turma','$registro_aluno','$turma'");
    
    header("Location: index.php?cms=Clientes&reg=1");					
    }
    
    if(isset ($_POST['editar'])){
    
    $nome = $_POST['nome'];
    $doc = $_POST['doc'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $aluno = $_POST['aluno'];
    $turma = $_POST['turma'];
    $registro_aluno = $_POST['registro_aluno'];
    if(isset($_POST['situacao'])) $situacao = 1; else $situacao = 0;
    $clienteid = $_POST['clienteid'];

    
    $crud = new crud('clientes'); // instancia classe com as opera��es crud, passando o nome da tabela como parametro
    $crud->atualizar("nome='$nome',doc='$doc',email='$email',endereco='$endereco',aluno='$aluno',turma='$turma',registro_aluno='$registro_aluno',situacao='$situacao'", "id='$clienteid'"); 
   
    header("Location: index.php?cms=Clientes&reg=2");
    }
    ?>

    
    
    <!-- C-HOME -->
        <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Cadastro de S�cio</h2>
            </div>
            <div class="contentbox">
          <form method="post" action="index.php?cms=CadastroCliente" class="block-content form" enctype="multipart/form-data">
            	
            <p>
            <label for="textfield"><strong>Situa��o do Aluno:</strong></label>
            <input type="checkbox" name="situacao" id="textfield" value=""  <?php if ($campo['situacao'] == 1) echo "checked='checked'"; ?> /> 
            </p>    
            <p>
            <label for="textfield"><strong>Nome Completo:</strong></label>
            <input type="text" name="nome" id="textfield" value="<?php echo @$campo['nome']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">(Nome do S�cio)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>CPF:</strong></label>
            <input type="text" name="doc" id="cpf" value="<?php echo @$campo['doc']; ?>" class="inputbox" style="width:200px" /> <br />
            <span class="smltxt">(CPF do S�cio)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>E-mail:</strong></label>
            <input type="text" name="email" id="textfield" value="<?php echo @$campo['email']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">(E-mail do S�cio)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Endere�o:</strong></label>
            <input type="text" name="endereco" id="textfield" value="<?php echo @$campo['endereco']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">(Endere�o, N�mero, Complemento, Bairro)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Aluno:</strong></label>
            <input type="text" name="aluno" id="textfield" value="<?php echo @$campo['aluno']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">(Nome de Guerra)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>N�mero do Aluno:</strong></label>
            <input type="text" name="registro_aluno" id="textfield" value="<?php echo @$campo['registro_aluno']; ?>" placeholder="N�mero do Aluno" class="inputbox" style="width:380px" /> 
            <span class="smltxt">(N�mero do Aluno)</span>
            </p>

             <p>
            <label for="textfield"><strong>Turma do Aluno:</strong></label>
            <input type="text" name="turma" id="textfield" value="<?php echo @$campo['turma']; ?>" placeholder="Turma do Aluno" class="inputbox" style="width:380px" /> 
            <span class="smltxt">(Turma do Aluno)</span>
            </p>
            
                    <?php if (@$campo['id'] <> '') { ?>
		  <input type="submit" name="editar" class="btn btn-info" value="Atualizar">
		  <input type="hidden" name="clienteid" value="<?php echo @$campo['id']; ?>"> 
		  <? } else { ?>
		  <input type="submit" name="cadastrar" class="btn btn-success" value="Cadastrar">
		  <?php } ?>
		    
	<br>
	</form>
  
 </div>
        </div>
        <!-- FIM-CHome -->