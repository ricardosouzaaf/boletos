<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="AUTOR" content="MEGACOMSISTEMAS" />
<title>Carnê Bancário</title>
<link href="css/tabless.css" rel="stylesheet" type="text/css"  />
<?php
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 0);
error_reporting(0);
ini_set("track_errors","0"); 

require_once("../conexao.class.php");
$con = new conexao(); // instancia classe de conxao
$con->connect(); // abre conexao com o banco

$idcliente = base64_decode($_GET['cliente']);
$idpedido = base64_decode($_GET['pedido']);
$banco = $_GET['banco'];

$ver = mysql_query("SELECT * FROM carnes WHERE id_cliente = '$idcliente' AND fatura = '$idpedido' AND situacao = 'N' AND banco = 'HSBC' order by data_vencimento ASC") or print (mysql_error());
$ve = mysql_num_rows($ver);

for ($x;$x < $ve; $x++){
$dadosboleto = mysql_fetch_array($ver);

$codigo = $dadosboleto["codigo"];
$linha_digitavel = $dadosboleto["linha_digitavel"];
$data_vencimento = $dadosboleto["data_vencimento"];  
$cedente = $dadosboleto["cedente"];
$agencia_codigo = $dadosboleto["agencia_codigo"];
$data_documento = $dadosboleto["data_documento"];
$numero_documento = $dadosboleto["numero_documento"];
$especie_doc = $dadosboleto["especie_doc"];
$aceite = $dadosboleto["aceite"];
$data_processamento = $dadosboleto["data_processamento"];
$nosso_numero = $dadosboleto["nosso_numero"];
$carteira = $dadosboleto["carteira"];
$especie = $dadosboleto["especie"];
$quantidade = $dadosboleto["quantidade"];
$valor_unitario = $dadosboleto["valor_unitario"];
$valor_boleto = $dadosboleto["valor_boleto"];
$instrucoes1 = $dadosboleto["instrucoes1"];
$instrucoes2 = $dadosboleto["instrucoes2"];
$sacado = $dadosboleto["sacado"];
$endereco1 = $dadosboleto["endereco1"];
$endereco2 = $dadosboleto["endereco2"];
$codigo_barras = $dadosboleto["codigo_barras"];

?>
<body>
<table>
  <tr><td valign="top">
  RECIBO DO SACADO:
  <table class="tabelas" style="width:195px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td style="width:150px;"><img src="imagens/logohsbc.jpg" alt="Banco HSBC" width="100" height="30" title="caixa" /></td>
    <td id="td_banco"><b><?php echo $codigo; ?></b></td>
    
    </tr>
    </table>
      <table class="tabelas" style="width:195px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">Sacado</div>
      <div class="var"><?php echo $sacado; ?></div></td>
    </tr>
      
    <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">Número do Documento</div>
      <div class="var"><?php echo $numero_documento; ?></div></td>
    </tr>
    
    <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">Data Vencimento</div>
      <div class="var"><?php echo $data_vencimento; ?></div></td>
    </tr>
    
    <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">Ag / Cód Cedente</div>
      <div class="var"><?php echo $agencia_codigo; ?></div></td>
    </tr>
    
    <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">Nosso Número</div>
      <div class="var"><?php echo $nosso_numero; ?></div></td>
    </tr>
    
    <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">Valor Documento</div>
      <div class="var"><?php echo $valor_boleto; ?></div></td>
    </tr>
    
    <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">(-) Desconto / Abatimentos</div>
      <div class="var"></div></td>
    </tr>
    
    <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">(+) Mora / Multa
	</div>
      <div class="var"></div></td>
    </tr>
    
    <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">(+) Outros acréscimos
	</div>
      <div class="var"></div></td>
    </tr>
    
    <tr>
      <td class="td_7_sb" style="width:15px;"> </td>
      <td style="width:103px;"><div class="titulo">(=) Valor cobrado
	</div>
      <div class="var"></div></td>
    </tr>
    
  </table>
  
  
  </td><td >
  
  <table border="0" cellpadding="0" cellspacing="0" id="tb_logo">
    <tr>
      <td rowspan="2" valign="bottom" style="width:150px;"><img src="imagens/logohsbc.jpg" alt="Banco HSBC" width="150" height="40" title="caixa" /></td>
      <td align="center" valign="bottom" style="font-size: 9px; border:none;">Banco</td>
      <td rowspan="2" align="right" valign="bottom" style="width:6px;"></td>
      <td rowspan="2" align="right" valign="bottom" style="font-size: 15px; font-weight:bold; width:445px;"><?php echo $linha_digitavel; ?></td>
      <td rowspan="2" align="right" valign="bottom" style="width:2px;"></td>
    </tr>
    <tr>
      <td id="td_banco"><?php echo $codigo; ?></td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb"> </td>
      <td style="width: 468px;"><div class="titulo">Local do Pagamento</div>
      <div class="var">Pag&aacute;vel em qualquer banco at&eacute; a data de vencimento</div></td>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">Vencimento</div>
        <div class="var"><?php echo $data_vencimento; ?></div></td>
      <td class="td_2"> </td>
    </tr>
    <tr>
      <td class="td_7_sb"> </td>
      <td><div class="titulo">Cedente</div>
      <div class="var"><span class="cp"><?php echo $cedente; ?></span></div></td>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">Ag&ecirc;ncia / C&oacute;digo do Cedente</div>
      <div class="var"><?php echo $agencia_codigo; ?></div></td>
      <td> </td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb"> </td>
      <td style="width:103px;"><div class="titulo">Data  Documento</div>
        <div class="var"><?php echo $data_documento; ?></div></td>
      <td class="td_7_cb"> </td>
      <td style="width:133px;"><div class="titulo">N&uacute;mero Documento</div>
      <div class="var"><?php echo $numero_documento; ?></div></td>
      <td class="td_7_cb"> </td>
      <td style="width:62px;"><div class="titulo">Esp&eacute;cie Doc.</div>
      <div class="var"><?php echo $especie_doc; ?></div></td>
      <td class="td_7_cb"> </td>
      <td style="width:34px;"><div class="titulo">Aceite</div>
      <div class="var"><?php echo $aceite ;?></div></td>
      <td class="td_7_cb"> </td>
      <td style="width:103px;"><div class="titulo"></div>
      <div class="var"><?php echo $data_processamento; ?></div></td>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">Nosso N&uacute;mero</div>
      <div class="var"><?php echo $nosso_numero; ?></div></td>
      <td class="td_2"> </td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="td_7_sb"> </td>
      <td style="width:118px;"><div class="titulo">Uso Banco</div>
      <div class="var"> </div></td>
      <td class="td_7_cb"> </td>
      <td style="width:55px;"><div class="titulo">Carteira</div>
      <div class="var"><?php echo $carteira; ?></div></td>
      <td class="td_7_cb"> </td>
      <td style="width:55px;"><div class="titulo">Esp. Moeda</div>
      <div class="var"><?php echo $especie; ?></div></td>
      <td class="td_7_cb"> </td>
      <td style="width:104px;"><div class="titulo">Qtde Moeda</div>
      <div class="var"><?php echo $quantidade; ?></div></td>
      <td class="td_7_cb"> </td>
      <td style="width:103px;"><div class="titulo">Valor</div>
      <div class="var"><?php echo $valor_unitario; ?></div></td>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">Valor do Documento</div>
      <div class="var"><?php echo $valor_boleto; ?></div></td>
      <td class="td_2"> </td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td rowspan="5" class="td_7_sb"></td>
      <td rowspan="5" valign="top"><div class="titulo" style="margin-bottom:18px;">Instru&ccedil;&otilde;es (texto de responsabilidade do Cedente)</div>
          <div class="var"><?php echo $instrucoes1; ?><br />
      <?php echo $instrucoes2; ?></div></td>
      <td class="td_7_cb"></td>
      <td class="direito"><div class="titulo">(+) Multa / Mora</div>
      <div class="var"> </div></td>
      <td class="td_2"></td>
    </tr>
    <tr>
      <td class="td_7_cb"></td>
      <td class="direito"><div class="titulo">(+) Outros Acr&eacute;scimos</div>
      <div class="var"> </div></td>
      <td class="td_2"></td>
    </tr>
    <tr>
      <td class="td_7_cb"></td>
      <td class="direito" valign="top"><div class="titulo">(=) Valor Cobrado</div>
      <div class="var"> </div></td>
      <td class="td_2"></td>
    </tr>
  </table>
  <table width="528" height="38" border="0" cellpadding="0" cellspacing="0" class="tabelas" style="width:666px; height:45px; border-left:solid; border-left-width:2px; border-left-color:#000000;">
    <tr>
      <td width="7" height="38" class="td_7_sb"></td>
      <td width="570" valign="top"><div class="titulo">Sacado</div>
          <div class="var" style="margin-bottom:2px; height:auto"><?php echo $sacado; ?><br><?php echo $endereco1; ?> / <?php echo $endereco2; ?>
            - </div></td>
      <td width="83" class="td_7_sb"></td>
      
      <td width="4" class="td_2"></td>
    </tr>
  </table>
  <table style="width:666px; border-top:solid; border-top-width:2px; border-top-color:#000000" border="0" cellspacing="0" cellpadding="0">
    <tr>
    
      <td width="7" class="td_7_sb"> </td>
      <td width="440" style="width: 417px; height:50px;"><?php 
// GERA CODIGO DE BARRA 
$linha = "$codigo_barras";

// Definimos as dimensoes das imagens
$fino = 1;
$largo = 3;
$altura = 40;

// Criamos um array associativo com os binários
$Bar[0] = "00110";
$Bar[1] = "10001";
$Bar[2] = "01001";
$Bar[3] = "11000";
$Bar[4] = "00101";
$Bar[5] = "10100";
$Bar[6] = "01100";
$Bar[7] = "00011" ;
$Bar[8] = "10010";
$Bar[9] = "01010";

// Inicio padrao do Código de Barras
echo "<img src=imagens/p.png  width=$fino height=$altura border=0>";
echo "<img src=imagens/b.png width=$fino height=$altura border=0>";
echo "<img src=imagens/p.png  width=$fino height=$altura border=0>";
echo "<img src=imagens/b.png width=$fino height=$altura border=0>";

// Checando para saber se o conteúdo é impar
if (bcmod(strlen($linha),2) <> 0) {
    $linha = '0'.$linha;
}

for ($a = 0; $a < strlen($linha); $a++){

    $Preto  = $linha[$a];
    $CodPreto  = $Bar[$Preto];

    $a = $a+1; // Sabemos que o Branco é um depois do Preto...
    $Branco = $linha[$a];
    $CodBranco = $Bar[$Branco];


    // Encontrado o CodPreto e o CodBranco vamos fazer outro looping dentro do nosso
    for ($y = 0; $y < 5; $y++) { // O for vai pegar os binários

        if ($CodPreto[$y] == '0') { // Se o binario for preto e fino ecoa
            echo "<img src=imagens/p.png  width=$fino height=$altura border=0>";
        }

        if ($CodPreto[$y] == '1') { // Se o binario for preto e grosso ecoa
            echo "<img src=imagens/p.png  width=$largo height=$altura border=0>";
        }

        if ($CodBranco[$y] == '0') { // Se o binario for branco e fino ecoa
            echo "<img src=imagens/b.png  width=$fino height=$altura border=0>";
        }

        if($CodBranco[$y] == '1') { // Se o binario for branco e grosso ecoa
            echo "<img src=imagens/b.png  width=$largo height=$altura border=0>";
        }
    }

} // Fechamos nosso looping maior

// Encerramos o código ecoando o final(encerramento)

// Final padrao do Codigo de Barras
echo "<img src=imagens/p.png  width=$largo height=$altura border=0>";
echo "<img src=imagens/b.png width=$fino  height=$altura border=0>";
echo "<img src=imagens/p.png  width=$fino  height=$altura border=0>";
?></td>
      <td width="37" class="td_7_sb"> </td>
      <td width="178" valign="top"><div class="titulo" style="text-align:left;">Autenticaçao Mecânica</div></td>
      <td width="4" class="td_2"> </td>
    </tr>
  </table>
  </td></tr></table>
  <br><hr size="1"><br>
</body>
<?php

} // fim do comando de laço

?>
</html>
