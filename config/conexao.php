<?php
$host = 'localhost';
$usuario = 'root';
$senha = 'rub32912289';
$banco = 'boletos';

	$bd = mysql_connect($host,$usuario,$senha);
	mysql_select_db($banco) or die(mysql_error());
	
?>
