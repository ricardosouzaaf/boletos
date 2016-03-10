<?php 
    /*
    Função CRUD
    */

    $alterar = mysql_query("SELECT * FROM usuarios WHERE id = '1'");
    $campo = mysql_fetch_array($alterar);
   					
   
    if(isset ($_POST['editar'])){
    
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    $salt = base64_encode($_POST['senha']);
    $login = $_POST['login'];
    
    $crud = new crud('usuarios'); // instancia classe com as operações crud, passando o nome da tabela como parametro
    $crud->atualizar("nome='$nome',email='$email',senha='$senha',salt='$salt',login='$login'", "id='1'"); 
   
    header("Location: sair.php");
    }


?>

    <?php if(@$_GET['reg'] == "2") { ?>
     	<div class="status info">
        	<p class="closestatus"><a href="?cms=Categorias" title="Fechar">x</a></p>
        	<p><img SRC="assets/img/icons/icon_info.png" alt="" /><span>Atenção:</span> Registro alterado com sucesso.</p>
        </div>
     	<?php } ?>
    
    <!-- C-HOME -->
        <div class="contentcontainer">
            <div class="headings altheading">
                <h2>Alterar Senha Administrador</h2>
            </div>
            <div class="contentbox">
          <form method="post" action="index.php?cms=Senha" class="block-content form" enctype="multipart/form-data">
            	
            <p>
            <label for="textfield"><strong>Nome do Administrador:</strong></label>
            <input type="text" name="nome" id="textfield" value="<?php echo @$campo['nome']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">(Nome do Administrador Responsável)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Email do Administrador:</strong></label>
            <input type="text" name="email" id="textfield" value="<?php echo @$campo['email']; ?>" class="inputbox" style="width:500px" /> <br />
            <span class="smltxt">(Email)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Login do Administrador:</strong></label>
            <input type="text" name="login" id="textfield" value="<?php echo @$campo['login']; ?>" class="inputbox" style="width:200px" /> <br />
            <span class="smltxt">(Nome de Usuário Login)</span>
            </p>
            
            <p>
            <label for="textfield"><strong>Senha do Administrador:</strong></label>
            <input type="password" name="senha" id="textfield" value="<?php echo base64_decode($campo['salt']); ?>" class="inputbox" style="width:200px" /> <br />
            <span class="smltxt">(Senha de Acesso)</span>
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