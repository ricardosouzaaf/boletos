<?php
/*
Formata as Variaveis Para Boletos e Carnês.
*/
$empresas = mysql_query("SELECT * FROM empresa WHERE id = '1'");
$empresa = mysql_fetch_array($empresas);
$eqcendereco = $empresa['endereco'];
$eqccnpj = $empresa['cnpj'];
$eqcestado = $empresa['cidade']." ".$empresa['estado'];
$eqccedente = $empresa['empresa'];
$eqcid = $empresa['empresa'];
$eqcb1 = $empresa['receberate'];
$eqcb2 = $empresa['instrucoes1'];
$eqcb3 = $empresa['instrucoes2'];
$eqcb4 = $empresa['instrucoes3'];
$eqcb5 = $empresa['carteira'];
$eqcb6 = $empresa['agencia'];
$eqcb7 = $empresa['digito_ag'];
$eqcb8 = $empresa['conta'];
$eqcb9 = $empresa['digito_co'];
$eqcb10 = $empresa['tipo_carteira'];
$eqcb11 = $empresa['convenio'];
$eqcb12 = $empresa['contrato'];
define('ENDERECO', "$eqcendereco");	
define('CNPJ', "$eqccnpj");
define('CIDADE', "$eqcestado");
define('CEDENTE', "$eqccedente");
define('IDENTIFICADOR', "$eqcid");
define('RECEBER', "$eqcb1");
define('INSTRUCOES1', "$eqcb2");
define('INSTRUCOES2', "$eqcb3");
define('INSTRUCOES3', "$eqcb4");
define('CARTEIRA', "$eqcb5");
define('AG', "$eqcb6");
define('AGDG', "$eqcb7");
define('CONTA', "$eqcb8");
define('CONTADG', "$eqcb9");
define('TIPO', "$eqcb10");
define('CONVENIO', "$eqcb11");
define('CONTRATO', "$eqcb12");
?>