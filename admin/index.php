<?php
session_start();
ob_start();

header("Content-Type: text/html; charset=ISO-8859-1", true);
require_once '../config/conexao.class.php';
require_once '../config/crud.class.php';
$con = new conexao(); // instancia classe de conxao
$con->connect(); // abre conexao com o banco

if(@$debug == 1) {
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 0);
error_reporting(0);
ini_set("track_errors","0"); 
} else {
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
}
if ( !isset($_SESSION['login']) ){ // Verifica Login do Usuário
echo "
<script>
window.location = 'login.php';
</script>
";
} else { 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>APM do Colégio Militar de Campo Grande</title>
<link href="assets/styles/layout.css" rel="stylesheet" type="text/css" />
<link href="assets/styles/wysiwyg.css" rel="stylesheet" type="text/css" />

<link href="assets/themes/blue/styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="assets/media/css/jquery.dataTables.css">
<script type='text/javascript' SRC="assets/media/js/jquery.js"></script>
<script type='text/javascript' SRC="assets/jquery-ui.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/media/js/jquery.dataTables.js"></script>
<script type='text/javascript' SRC="assets/scripts/jquery.wysiwyg.js"></script>
<script type='text/javascript' SRC="assets/scripts/visualize.jQuery.js"></script>
<script type="text/javascript" SRC="assets/scripts/functions.js"></script>
</head>
<body id="homepage">
	<div id="header">
    	<a href="index.php" title="" style="text-decoration:none; "><h1 style="color:white; padding:20px; text-decoration:none;">APM - CMCG</h1></a>
    </div>
  

    <div id="rightside">

              	    <?php
		    $cms = (isset ( $_GET ['cms'] ) ? $_GET ['cms'] : 'cms');
		    switch ($cms) {
		    
		    case 'Clientes' :
		    include_once ('view/clientes/index.php');
		    break;
		    case 'CadastroCliente' :
		    include_once ('view/clientes/cadastro.php');
		    break;
		    
		    case 'Faturas' :
		    include_once ('view/faturas/index.php');
		    break;
		    case 'CadastroFatura' :
		    include_once ('view/faturas/cadastro.php');
		    break;
		    case 'NovaFatura' :
		    include_once ('view/faturas/novo.php');
		    break;
		    case 'Retorno' :
		    include_once ('view/faturas/retorno.php');
		    break;
		    case 'Pagos' :
		    include_once ('view/faturas/pagos.php');
		    break;
		    case 'Cancelados' :
		    include_once ('view/faturas/cancelados.php');
		    break;
		    
      		    case 'Senha' :
		    include_once ('view/config/senha.php');
		    break;
		    case 'Configuracoes' :
		    include_once ('view/config/config.php');
		    break;
      		    
		    case 'home' :
		    default :
		    include_once ('view/dashboard/index.php');
		    break;
		    }
                    ?>
        
        
        <div id="footer">
        	&copy; Copyright <?php echo date('Y'); ?> <a href="http://www.digisoftms.com.br">DigiSoft</a>
        </div> 
          
    </div>
    
    <div id="leftside">
    <?php include("menu.php"); ?>
    </div>
    <script src="assets/scripts/jquery.maskedinput.min.js"></script>
    <script language="javascript">
    function moeda(z){  
		v = z.value;
		v=v.replace(/\D/g,"")  //permite digitar apenas números
	v=v.replace(/[0-9]{12}/,"inválido")   //limita pra máximo 999.999.999,99
	v=v.replace(/(\d{1})(\d{8})$/,"$1$2")  //coloca ponto antes dos últimos 8 digitos
	v=v.replace(/(\d{1})(\d{5})$/,"$1$2")  //coloca ponto antes dos últimos 5 digitos
	v=v.replace(/(\d{1})(\d{1,2})$/,"$1.$2")	//coloca virgula antes dos últimos 2 digitos
		z.value = v;
	}
	$(function(){
        $('#edit').editable({inlineMode: false})

        $('form').submit(function () {
          console.log($(this).find('textarea').val());

        })
      });
	
   jQuery(function($){
   $("#cel").mask("(999) 99999-9999");
   $("#tel").mask("(999) 9999-9999");
   $("#cep").mask("99999-999");
   $("#cpf").mask("999.999.999-99");
   $("#cnpj").mask("99.999.999/9999-99");
   $("#data").mask("99/99/9999");
   $("#hora").mask("99:99");
   });
   </script>
    <!--[if IE 6]>
    <script type='text/javascript' src='assets/scripts/png_fix.js'></script>
    <script type='text/javascript'>
      DD_belatedPNG.fix('img, .notifycount, .selected');
    </script>
    <![endif]--> 
</body>
</html>
<?php } ?>
