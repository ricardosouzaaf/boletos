<?php
ini_set("allow_url_fopen", 1);
ini_set("display_errors", 0);
error_reporting(0);
ini_set("track_errors","0");
date_default_timezone_set("Brazil/East");

// ERPMK GERADOR DE CARNE CEF - MODIFICAR SOMENTE SE NECESSARIO
// 02/04/2015 ERPMK SISTEMAS PROVEDOR 

require_once("../conexao.class.php");
$con = new conexao(); // instancia classe de conxao
$con->connect(); // abre conexao com o banco

// Variaveis Boleto
require_once("../config.boletos.php"); 

function formata_numero($numero,$loop,$insert,$tipo = "geral") {
	if ($tipo == "geral") {
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "valor") {
		/*
		retira as virgulas
		formata o numero
		preenche com zeros
		*/
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "convenio") {
		while(strlen($numero)<$loop){
			$numero = $numero . $insert;
		}
	}
	return $numero;
}


function fbarcode($valor){

$fino = 1 ;
$largo = 3 ;
$altura = 50 ;

  $barcodes[0] = "00110" ;
  $barcodes[1] = "10001" ;
  $barcodes[2] = "01001" ;
  $barcodes[3] = "11000" ;
  $barcodes[4] = "00101" ;
  $barcodes[5] = "10100" ;
  $barcodes[6] = "01100" ;
  $barcodes[7] = "00011" ;
  $barcodes[8] = "10010" ;
  $barcodes[9] = "01010" ;
  for($f1=9;$f1>=0;$f1--){ 
    for($f2=9;$f2>=0;$f2--){  
      $f = ($f1 * 10) + $f2 ;
      $texto = "" ;
      for($i=1;$i<6;$i++){ 
        $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
      }
      $barcodes[$f] = $texto;
    }
  }
}

function esquerda($entra,$comp){
	return substr($entra,0,$comp);
}

function direita($entra,$comp){
	return substr($entra,strlen($entra)-$comp,$comp);
}

function fator_vencimento($data) {
	$data = explode("/",$data);
	$ano = $data[2];
	$mes = $data[1];
	$dia = $data[0];
    return(abs((_dateToDays("1997","10","07")) - (_dateToDays($ano, $mes, $dia))));
}

function _dateToDays($year,$month,$day) {
    $century = substr($year, 0, 2);
    $year = substr($year, 2, 2);
    if ($month > 2) {
        $month -= 3;
    } else {
        $month += 9;
        if ($year) {
            $year--;
        } else {
            $year = 99;
            $century --;
        }
    }

    return ( floor((  146097 * $century)    /  4 ) +
            floor(( 1461 * $year)        /  4 ) +
            floor(( 153 * $month +  2) /  5 ) +
                $day +  1721119);
}

/*
#################################################
FUNÇÃO DO MÓDULO 10 RETIRADA DO PHPBOLETO

ESTA FUNÇÃO PEGA O DÍGITO VERIFICADOR DO PRIMEIRO, SEGUNDO
E TERCEIRO CAMPOS DA LINHA DIGITÁVEL
#################################################
*/
function modulo_10($num) { 
	$numtotal10 = 0;
	$fator = 2;
 
	for ($i = strlen($num); $i > 0; $i--) {
		$numeros[$i] = substr($num,$i-1,1);
		$parcial10[$i] = $numeros[$i] * $fator;
		$numtotal10 .= $parcial10[$i];
		if ($fator == 2) {
			$fator = 1;
		}
		else {
			$fator = 2; 
		}
	}
	
	$soma = 0;
	for ($i = strlen($numtotal10); $i > 0; $i--) {
		$numeros[$i] = substr($numtotal10,$i-1,1);
		$soma += $numeros[$i]; 
	}
	$resto = $soma % 10;
	$digito = 10 - $resto;
	if ($resto == 0) {
		$digito = 0;
	}

	return $digito;
}

/*
#################################################
FUNÇÃO DO MÓDULO 11 RETIRADA DO PHPBOLETO

MODIFIQUEI ALGUMAS COISAS...

ESTA FUNÇÃO PEGA O DÍGITO VERIFICADOR:

NOSSONUMERO
AGENCIA
CONTA
CAMPO 4 DA LINHA DIGITÁVEL
#################################################
*/

function modulo_11($num, $base=9, $r=0) {
	$soma = 0;
	$fator = 2; 
	for ($i = strlen($num); $i > 0; $i--) {
		$numeros[$i] = substr($num,$i-1,1);
		$parcial[$i] = $numeros[$i] * $fator;
		$soma += $parcial[$i];
		if ($fator == $base) {
			$fator = 1;
		}
		$fator++;
	}
	if ($r == 0) {
		$soma *= 10;
		$digito = $soma % 11;
		
		//corrigido
		if ($digito == 10) {
			$digito = "X";
		}

		/*
		alterado por mim, Daniel Schultz

		Vamos explicar:

		O módulo 11 só gera os digitos verificadores do nossonumero,
		agencia, conta e digito verificador com codigo de barras (aquele que fica sozinho e triste na linha digitável)
		só que é foi um rolo...pq ele nao podia resultar em 0, e o pessoal do phpboleto se esqueceu disso...
		
		No BB, os dígitos verificadores podem ser X ou 0 (zero) para agencia, conta e nosso numero,
		mas nunca pode ser X ou 0 (zero) para a linha digitável, justamente por ser totalmente numérica.

		Quando passamos os dados para a função, fica assim:

		Agencia = sempre 4 digitos
		Conta = até 8 dígitos
		Nosso número = de 1 a 17 digitos

		A unica variável que passa 17 digitos é a da linha digitada, justamente por ter 43 caracteres

		Entao vamos definir ai embaixo o seguinte...

		se (strlen($num) == 43) { não deixar dar digito X ou 0 }
		*/
		
		if (strlen($num) == "43") {
			//então estamos checando a linha digitável
			if ($digito == "0" or $digito == "X" or $digito > 9) {
					$digito = 1;
			}
		}
		return $digito;
	} 
	elseif ($r == 1){
		$resto = $soma % 11;
		return $resto;
	}
}

/*
Montagem da linha digitável - Função tirada do PHPBoleto
Não mudei nada
*/
function monta_linha_digitavel($linha) {
    // Posição 	Conteúdo
    // 1 a 3    Número do banco
    // 4        Código da Moeda - 9 para Real
    // 5        Digito verificador do Código de Barras
    // 6 a 19   Valor (12 inteiros e 2 decimais)
    // 20 a 44  Campo Livre definido por cada banco

    // 1. Campo - composto pelo código do banco, código da moéda, as cinco primeiras posições
    // do campo livre e DV (modulo10) deste campo
    $p1 = substr($linha, 0, 4);
    $p2 = substr($linha, 19, 5);
    $p3 = modulo_10("$p1$p2");
    $p4 = "$p1$p2$p3";
    $p5 = substr($p4, 0, 5);
    $p6 = substr($p4, 5);
    $campo1 = "$p5.$p6";

    // 2. Campo - composto pelas posiçoes 6 a 15 do campo livre
    // e livre e DV (modulo10) deste campo
    $p1 = substr($linha, 24, 10);
    $p2 = modulo_10($p1);
    $p3 = "$p1$p2";
    $p4 = substr($p3, 0, 5);
    $p5 = substr($p3, 5);
    $campo2 = "$p4.$p5";

    // 3. Campo composto pelas posicoes 16 a 25 do campo livre
    // e livre e DV (modulo10) deste campo
    $p1 = substr($linha, 34, 10);
    $p2 = modulo_10($p1);
    $p3 = "$p1$p2";
    $p4 = substr($p3, 0, 5);
    $p5 = substr($p3, 5);
    $campo3 = "$p4.$p5";

    // 4. Campo - digito verificador do codigo de barras
    $campo4 = substr($linha, 4, 1);

    // 5. Campo composto pelo valor nominal pelo valor nominal do documento, sem
    // indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
    // tratar de valor zerado, a representacao deve ser 000 (tres zeros).
    $campo5 = substr($linha, 5, 14);

    return "$campo1 $campo2 $campo3 $campo4 $campo5"; 
}

function geraCodigoBanco($numero) {
    $parte1 = substr($numero, 0, 3);
    $parte2 = modulo_11($parte1);
    return $parte1 . "-" . $parte2;
}

// CONSULTA FINANCEIRO GERA CARNE TODOAS AS PARCELAS DO PEDIDO -> ID + N 

$idpedido = base64_decode($_GET['pedido']);
$idcliente = base64_decode($_GET['cliente']);

$consultas = mysql_query("SELECT * FROM financeiro WHERE pedido = '$idpedido' AND situacao = 'N' AND cliente = '$idcliente'");
while($campo = mysql_fetch_array($consultas)){ 

$idc = $campo['cliente'];
$ccv = mysql_query("SELECT * FROM clientes WHERE id = '$idc'");
$cliente = mysql_fetch_array($ccv);

$id_cliente = $campo['cliente'];
$numero_documento_rec = $campo['boleto'];
$vc = explode("-",$campo['vencimento']);
$datacertavencimento = $vc[2]."/".$vc[1]."/".$vc[0];

$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = $campo['taxa'];
$data_venc = $datacertavencimento;
$valor_cobrado = $campo['valor']; 
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $campo['boleto'];
$dadosboleto["numero_documento"] = $campo['boleto'];	
$dadosboleto["data_vencimento"] = $data_venc; 
$dadosboleto["data_documento"] = date("d/m/Y"); 
$dadosboleto["data_processamento"] = date("d/m/Y"); 
$dadosboleto["valor_boleto"] = $valor_boleto; 	

			// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $cliente['nome'];
$dadosboleto["endereco1"] = $cliente['endereco'];
$dadosboleto["endereco2"] = $cliente['cidade']." ".$cliente['estado']." CEP ".$cliente['cep'];

			// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "";
$dadosboleto["demonstrativo2"] = "";
$dadosboleto["demonstrativo3"] = "";
$dadosboleto["instrucoes1"] = INSTRUCOES1;
$dadosboleto["instrucoes2"] = INSTRUCOES2;
$dadosboleto["instrucoes3"] = INSTRUCOES3;
$dadosboleto["instrucoes4"] = "";

			// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "1";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "S";		
$dadosboleto["uso_banco"] = ""; 	
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";

			// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //

// DADOS DA SUA CONTA - BANCO DO BRASIL
$dadosboleto["agencia"] = AG; // Num da agencia, sem digito
$dadosboleto["conta"] = AGDG; 	// Num da conta, sem digito

			// DADOS PERSONALIZADOS - BANCO DO BRASIL
$dadosboleto["convenio"] = CONVENIO;  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
$dadosboleto["contrato"] = CONTRATO; // Num do seu contrato
$dadosboleto["carteira"] = CARTEIRA;
$dadosboleto["variacao_carteira"] = "";  // Variação da Carteira, com traço (opcional)
			
$fconvenio = CONVENIO;
$cnosso = $assinatura['boleto'];
			
			// TIPO DO BOLETO
$dadosboleto["formatacao_convenio"] = "8"; 
$dadosboleto["formatacao_nosso_numero"] = "2"; 
			
if(strlen($fconvenio) == 6){
if(strlen($cnosso) <= 5){
$cont = 1;
}elseif(strlen($cnosso) > 5 && strlen($cnosso) < 17){
$cont = 2;
}

$dadosboleto["formatacao_nosso_numero"] = $cont; 
}
			
// SEUS DADOS
$dadosboleto["identificacao"] = IDENTIFICADOR;
$dadosboleto["cpf_cnpj"] = CNPJ;
$dadosboleto["endereco"] = ENDERECO;
$dadosboleto["cidade_uf"] = CIDADE;
$dadosboleto["cedente"] = CEDENTE;

//NAO altera

$codigobanco = "001";
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9";
$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);

//valor tem 10 digitos, sem virgula
$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
//agencia é sempre 4 digitos
$agencia = formata_numero($dadosboleto["agencia"],4,0);
//conta é sempre 8 digitos
$conta = formata_numero($dadosboleto["conta"],8,0);
//carteira 18
$carteira = $dadosboleto["carteira"];
//agencia e conta
$agencia_codigo = $agencia."-". modulo_11($agencia) ." / ". $conta ."-". modulo_11($conta);
//Zeros: usado quando convenio de 7 digitos
$livre_zeros='000000';

// Carteira 18 com Convênio de 8 dígitos
if ($dadosboleto["formatacao_convenio"] == "8") {
	$convenio = formata_numero($dadosboleto["convenio"],8,0,"convenio");
	// Nosso número de até 9 dígitos
	$nossonumero = formata_numero($dadosboleto["nosso_numero"],9,0);
	$dv=modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira");
	$linha="$codigobanco$nummoeda$dv$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira";
	//montando o nosso numero que aparecerá no boleto
	$nossonumero = $convenio . $nossonumero ."-". modulo_11($convenio.$nossonumero);
}

// Carteira 18 com Convênio de 7 dígitos
if ($dadosboleto["formatacao_convenio"] == "7") {
	$convenio = formata_numero($dadosboleto["convenio"],7,0,"convenio");
	// Nosso número de até 10 dígitos
	$nossonumero = formata_numero($dadosboleto["nosso_numero"],10,0);
	$dv=modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira");
	$linha="$codigobanco$nummoeda$dv$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira";
  $nossonumero = $convenio.$nossonumero;
	//Não existe DV na composição do nosso-número para convênios de sete posições
}

// Carteira 18 com Convênio de 6 dígitos
if ($dadosboleto["formatacao_convenio"] == "6") {
	$convenio = formata_numero($dadosboleto["convenio"],6,0,"convenio");
	
	if ($dadosboleto["formatacao_nosso_numero"] == "1") {
		
		// Nosso número de até 5 dígitos
		$nossonumero = formata_numero($dadosboleto["nosso_numero"],5,0);
		$dv = modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$convenio$nossonumero$agencia$conta$carteira");
		$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$convenio$nossonumero$agencia$conta$carteira";
		//montando o nosso numero que aparecerá no boleto
		$nossonumero = $convenio . $nossonumero ."-". modulo_11($convenio.$nossonumero);
	}
	
	if ($dadosboleto["formatacao_nosso_numero"] == "2") {
		
		// Nosso número de até 17 dígitos
		$nservico = "21";
		$nossonumero = formata_numero($dadosboleto["nosso_numero"],17,0);
		$dv = modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$convenio$nossonumero$nservico");
		$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$convenio$nossonumero$nservico";
	}
}

$dadosboleto["codigo_barras"] = $linha;
$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha);
$dadosboleto["agencia_codigo"] = $agencia_codigo;
$dadosboleto["nosso_numero"] = $nossonumero;
$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

$codigo = $dadosboleto["codigo_banco_com_dv"];
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
$idpedido = base64_decode($_GET['pedido']);

$cadastrar = mysql_query("INSERT INTO carnes (id_cliente, codigo, fatura, linha_digitavel, data_vencimento, cedente, agencia_codigo, data_documento, numero_documento, especie_doc, aceite, data_processamento, nosso_numero, carteira, especie, quantidade, valor_unitario, valor_boleto, instrucoes1, instrucoes2, sacado, endereco1, endereco2, codigo_barras, banco, pedido, situacao)
VALUES('$id_cliente','$codigo','$idpedido','$linha_digitavel','$data_vencimento','$cedente','$agencia_codigo','$data_documento','$numero_documento','$especie_doc','$aceite','$data_processamento','$nosso_numero','$carteira','$especie','$quantidade','$valor_unitario','$valor_boleto','$instrucoes1','$instrucoes2','$sacado','$endereco1','$endereco2','$codigo_barras','BB','$numero_documento_rec','N')") or die (mysql_error());

}
// RETORNA RESULTADO DO ERPMK 

$idcv = base64_encode($id_cliente);
$idpd = base64_encode($idpedido);
header("Location: cn_bb.php?cliente=$idcv&pedido=$idpd");

?>



