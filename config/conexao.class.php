<?php
// CONEXAO PADR�O
require_once("conexao.php"); 
date_default_timezone_set("Brazil/East"); // Brasil
$host = $host; // servidor
$database = $banco; // nome do banco
$login_db = $usuario; // usuario do banco 
$senha_db = $senha; // senha do usuario do banco
define('HOST', $host);	
define('BANCO',  $database);
define('LOGIN',  $login_db);
define('SENHA',  $senha_db);		

$cn=mysql_connect($host, $login_db, $senha_db);
mysql_select_db($database);

class conexao
{

    /*
    CONEX�O CRUDS
    */

    private $db_host = HOST; // servidor
    private $db_user = LOGIN; // usuario do banco
    private $db_pass = SENHA; // senha do usuario do banco
    private $db_name = BANCO; // nome do banco

    private $con = false;

   
    public function connect() // Estabelece conexao
    {
        if(!$this->con)
        {
            $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
            if($myconn)
            {
                $seldb = @mysql_select_db($this->db_name,$myconn);
                if($seldb)
                {
                    $this->con = true;
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }

   
    public function disconnect() // Fecha conexao
    {
    if($this->con)
    {
        if(@mysql_close())
        {
                        $this->con = false;
            return true;
        }
        else
        {
            return false;
        }
    }
    }
      
}

function acento($string)
{
  $string = str_replace('�','a',$string);
  $string = str_replace('�','A',$string);
  $string = str_replace('�','a',$string);
  $string = str_replace('�','A',$string);
  $string = str_replace('�','a',$string);
  $string = str_replace('�','A',$string);
  $string = str_replace('�','a',$string);
  $string = str_replace('�','A',$string);
  $string = str_replace('�','c',$string);
  $string = str_replace('�','C',$string);
  $string = str_replace('�','e',$string);
  $string = str_replace('�','E',$string);
  $string = str_replace('�','e',$string);
  $string = str_replace('�','E',$string);
  $string = str_replace('�','e',$string);
  $string = str_replace('�','E',$string);
  $string = str_replace('�','i',$string);
  $string = str_replace('�','I',$string);
  $string = str_replace('�','o',$string);
  $string = str_replace('�','O',$string);
  $string = str_replace('�','o',$string);
  $string = str_replace('�','O',$string);
  $string = str_replace('�','o',$string);
  $string = str_replace('�','O',$string);
  $string = str_replace('�','u',$string);
  $string = str_replace('�','U',$string);
  $string = str_replace('~','',$string);
  $string = str_replace('&','e',$string);
  $string = str_replace('.','',$string);
  $string = str_replace('-','',$string);
  $string = str_replace(',','',$string);
  $string = str_replace(';','',$string);
  $string = str_replace(':','',$string);
  $string = str_replace('(','',$string);
  $string = str_replace(')','',$string);
  $string = str_replace(' ','+',$string);
  $string = str_replace('/','',$string);
  return $string;
  
  } 

// Fun��es Juros
function Moeda($value){
return number_format($value, 2, ",", ".");
};
 
 function convdata($dataform, $tipo){
 if ($tipo == 0) {
 $datatrans = explode ("/", $dataform);
 $data = "$datatrans[2]-$datatrans[1]-$datatrans[0]";
 } elseif ($tipo == 1) {
 $datatrans = explode ("-", $dataform);
 $data = "$datatrans[2]/$datatrans[1]/$datatrans[0]";
 }elseif ($tipo == 2) {
 $datatrans = explode ("-", $dataform);
 $data = "$datatrans[1]/$datatrans[2]/$datatrans[0]";
 } elseif ($tipo == 3) {
 $datatrans = explode ("/", $dataform);
 $data = "$datatrans[2]-$datatrans[1]-$datatrans[0]";
 }
 
 return $data;
 };
 
 function diasEntreData($date_ini, $date_end){
 $data_ini = strtotime( convdata(convdata($date_ini,3),2) ); //data inicial '29 de julho de 2003'
 $hoje = convdata($date_end,3);//date("m/d/Y"); // data atual
 $foo = strtotime($hoje); // transforma data atual em segundos (eu acho)
 $dias = ($foo - $data_ini)/86400; //calcula intervalo
 return $dias;
 };

?>