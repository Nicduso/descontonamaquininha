<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	require_once("../model/Connection.class.php");
	if(Connection::getInstance()) {
			echo "Banco de Dados Conectado!";
	} else {
			echo "Erro ao conectar o Banco de Dados.";
	}
?>
