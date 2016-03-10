<?php
session_start();
ob_start();
header("Content-Type: text/html; charset=ISO-8859-1", true);
include("../config/conexao.php");

$db = mysql_connect ($host, $usuario, $senha); //conecta ao mysql
$basedados = mysql_select_db($banco); 

if (@$_POST['operacao'] == 'login') { 
$login = $_POST['login'];
$senha = md5($_POST['senha']);

$confirmacao = mysql_query("SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'", $db); 
$contagem = mysql_num_rows($confirmacao); 
$linha = mysql_fetch_array($confirmacao);

if (@$contagem == 1 ) {
$_SESSION['login'] = $linha['login']; // Login do Usuário
$_SESSION['id'] = $linha['id']; // ID do Usuário
$_SESSION['nivel'] = $linha['nivel']; // Nível de Permissão
echo "<script>location.href='index.php'</script>"; //Acessa o Painel
} else {
echo '<script>
        alert ("LOGIN OU SENHA ESTÃO INVALIDOS!");
        document.location.href = ("login.php");
</script>'; 
}
} // Função POST OK
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>APM - CMCG | Administração</title>
<link href="assets/styles/layout.css" rel="stylesheet" type="text/css" />
<link href="assets/styles/login.css" rel="stylesheet" type="text/css" />

<link href="assets/themes/blue/styles.css" rel="stylesheet" type="text/css" />


</head>
<body>
	<div id="logincontainer">
    	<div id="loginbox">
        	<div id="loginheader">
            	<h2 style="color:#2196F3;">APM - CMCG | Administração</h2>
            </div>
            <div id="innerlogin">
            	<form action="login.php" method="POST">
                	
                	<input type="text" name="login" placeholder="Login" class="logininput" />
                    
                	<input type="password" name="senha" placeholder="Senha" class="logininput" />
                   	<input type="hidden" name="operacao" value="login">
                   	<input type="submit" class="loginbtn" value="Acessar" /><br />
                </form>
            </div>
        </div>
      
    </div></body>
</html>