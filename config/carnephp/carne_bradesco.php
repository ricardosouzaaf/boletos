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

function digitoVerificador_nossonumero($numero) {
	$resto2 = modulo_11($numero, 7, 1);
     $digito = 11 - $resto2;
     if ($digito == 10) {
        $dv = "P";
     } elseif($digito == 11) {
     	$dv = 0;
	} else {
        $dv = $digito;
     	}
	 return $dv;
}


function digitoVerificador_barra($numero) {
	$resto2 = modulo_11($numero, 9, 1);
     if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
        $dv = 1;
     } else {
	 	$dv = 11 - $resto2;
     }
	 return $dv;
}


// FUN��ES
// Algumas foram retiradas do Projeto PhpBoleto e modificadas para atender as particularidades de cada banco

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

function modulo_10($num) { 
		$numtotal10 = 0;
        $fator = 2;

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num,$i-1,1);
            // Efetua multiplicacao do numero pelo (falor 10)
            // 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Ita�
            $temp = $numeros[$i] * $fator; 
            $temp0=0;
            foreach (preg_split('//',$temp,-1,PREG_SPLIT_NO_EMPTY) as $k=>$v){ $temp0+=$v; }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }
		
        // v�rias linhas removidas, vide fun��o original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }
		
        return $digito;
		
}

function modulo_11($num, $base=9, $r=0)  {
    /**
     *   Autor:
     *           Pablo Costa <pablo@users.sourceforge.net>
     *
     *   Fun��o:
     *    Calculo do Modulo 11 para geracao do digito verificador 
     *    de boletos bancarios conforme documentos obtidos 
     *    da Febraban - www.febraban.org.br 
     *
     *   Entrada:
     *     $num: string num�rica para a qual se deseja calcularo digito verificador;
     *     $base: valor maximo de multiplicacao [2-$base]
     *     $r: quando especificado um devolve somente o resto
     *
     *   Sa�da:
     *     Retorna o Digito verificador.
     *
     *   Observa��es:
     *     - Script desenvolvido sem nenhum reaproveitamento de c�digo pr� existente.
     *     - Assume-se que a verifica��o do formato das vari�veis de entrada � feita antes da execu��o deste script.
     */                                        

    $soma = 0;
    $fator = 2;

    /* Separacao dos numeros */
    for ($i = strlen($num); $i > 0; $i--) {
        // pega cada numero isoladamente
        $numeros[$i] = substr($num,$i-1,1);
        // Efetua multiplicacao do numero pelo falor
        $parcial[$i] = $numeros[$i] * $fator;
        // Soma dos digitos
        $soma += $parcial[$i];
        if ($fator == $base) {
            // restaura fator de multiplicacao para 2 
            $fator = 1;
        }
        $fator++;
    }

    /* Calculo do modulo 11 */
    if ($r == 0) {
        $soma *= 10;
        $digito = $soma % 11;
        if ($digito == 10) {
            $digito = 0;
        }
        return $digito;
    } elseif ($r == 1){
        $resto = $soma % 11;
        return $resto;
    }
}

function monta_linha_digitavel($codigo) {

	// 01-03    -> C�digo do banco sem o digito
	// 04-04    -> C�digo da Moeda (9-Real)
	// 05-05    -> D�gito verificador do c�digo de barras
	// 06-09    -> Fator de vencimento
	// 10-19    -> Valor Nominal do T�tulo
	// 20-44    -> Campo Livre (Abaixo)
	
	// 20-23    -> C�digo da Agencia (sem d�gito)
	// 24-05    -> N�mero da Carteira
	// 26-36    -> Nosso N�mero (sem d�gito)
	// 37-43    -> Conta do Cedente (sem d�gito)
	// 44-44    -> Zero (Fixo)
        

        // 1. Campo - composto pelo c�digo do banco, c�digo da mo�da, as cinco primeiras posi��es
        // do campo livre e DV (modulo10) deste campo
        
        $p1 = substr($codigo, 0, 4);							// Numero do banco + Carteira
        $p2 = substr($codigo, 19, 5);						// 5 primeiras posi��es do campo livre
        $p3 = modulo_10("$p1$p2");						// Digito do campo 1
        $p4 = "$p1$p2$p3";								// Uni�o
        $campo1 = substr($p4, 0, 5).'.'.substr($p4, 5);

        // 2. Campo - composto pelas posi�oes 6 a 15 do campo livre
        // e livre e DV (modulo10) deste campo
        $p1 = substr($codigo, 24, 10);						//Posi��es de 6 a 15 do campo livre
        $p2 = modulo_10($p1);								//Digito do campo 2	
        $p3 = "$p1$p2";
        $campo2 = substr($p3, 0, 5).'.'.substr($p3, 5);

        // 3. Campo composto pelas posicoes 16 a 25 do campo livre
        // e livre e DV (modulo10) deste campo
        $p1 = substr($codigo, 34, 10);						//Posi��es de 16 a 25 do campo livre
        $p2 = modulo_10($p1);								//Digito do Campo 3
        $p3 = "$p1$p2";
        $campo3 = substr($p3, 0, 5).'.'.substr($p3, 5);

        // 4. Campo - digito verificador do codigo de barras
        $campo4 = substr($codigo, 4, 1);

        // 5. Campo composto pelo fator vencimento e valor nominal do documento, sem
        // indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
        // tratar de valor zerado, a representacao deve ser 000 (tres zeros).
		$p1 = substr($codigo, 5, 4);
		$p2 = substr($codigo, 9, 10);
		$campo5 = "$p1$p2";

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
$valorcorrigido = $campo['valor'];

$datacertavencimento = $vc[2]."/".$vc[1]."/".$vc[0];

$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = $campo['taxa'];
$data_venc = $datacertavencimento;
$valor_cobrado = $valorcorrigido; 
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
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";

			// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //

// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = AG; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = AGDG; // Digito do Num da agencia
$dadosboleto["conta"] = CONTA; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = CONTADG; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = CONTA; // ContaCedente do Cliente, sem digito (Somente N�meros)
$dadosboleto["conta_cedente_dv"] = CONTADG; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = CARTEIRA;  // C�digo da Carteira: pode ser 06 ou 03

// SEUS DADOS
$dadosboleto["identificacao"] = IDENTIFICADOR;
$dadosboleto["cpf_cnpj"] = CNPJ;
$dadosboleto["endereco"] = ENDERECO;
$dadosboleto["cidade_uf"] = CIDADE;
$dadosboleto["cedente"] = CEDENTE;

//NAO altera

$codigobanco = "237";
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9";
$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);

//valor tem 10 digitos, sem virgula
$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
//agencia � 4 digitos
$agencia = formata_numero($dadosboleto["agencia"],4,0);
//conta � 6 digitos
$conta = formata_numero($dadosboleto["conta"],6,0);
//dv da conta
$conta_dv = formata_numero($dadosboleto["conta_dv"],1,0);
//carteira � 2 caracteres
$carteira = $dadosboleto["carteira"];

//nosso n�mero (sem dv) � 11 digitos
$nnum = formata_numero($dadosboleto["carteira"],2,0).formata_numero($dadosboleto["nosso_numero"],11,0);
//dv do nosso n�mero
$dv_nosso_numero = digitoVerificador_nossonumero($nnum);

//conta cedente (sem dv) � 7 digitos
$conta_cedente = formata_numero($dadosboleto["conta_cedente"],7,0);
//dv da conta cedente
$conta_cedente_dv = formata_numero($dadosboleto["conta_cedente_dv"],1,0);

//$ag_contacedente = $agencia . $conta_cedente;

// 43 numeros para o calculo do digito verificador do codigo de barras
$dv = digitoVerificador_barra("$codigobanco$nummoeda$fator_vencimento$valor$agencia$nnum$conta_cedente".'0', 9, 0);
// Numero para o codigo de barras com 44 digitos
$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$agencia$nnum$conta_cedente"."0";

$nossonumero = substr($nnum,0,2).'/'.substr($nnum,2).'-'.$dv_nosso_numero;
$agencia_codigo = $agencia."-".$dadosboleto["agencia_dv"]." / ". $conta_cedente ."-". $conta_cedente_dv;


$dadosboleto["codigo_barras"] = $linha;
$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha);
$dadosboleto["agencia_codigo"] = $agencia_codigo;
$dadosboleto["nosso_numero"] = $nossonumero;
$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;



// GREVA BOLETO NO SQL 
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
VALUES('$id_cliente','$codigo','$idpedido','$linha_digitavel','$data_vencimento','$cedente','$agencia_codigo','$data_documento','$numero_documento','$especie_doc','$aceite','$data_processamento','$nosso_numero','$carteira','$especie','$quantidade','$valor_unitario','$valor_boleto','$instrucoes1','$instrucoes2','$sacado','$endereco1','$endereco2','$codigo_barras','BRADESCO','$numero_documento_rec','N')") or die (mysql_error());

}
// RETORNA RESULTADO DO ERPMK 

$idcv = base64_encode($id_cliente);
$idpd = base64_encode($idpedido);
header("Location: cn_bradesco.php?cliente=$idcv&pedido=$idpd");
?>



