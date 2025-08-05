<?php

    require_once("../model/Connection.class.php");
    if(Connection::getInstance()) {
        echo "Banco de Dados Conectado!";
    } else {
        echo "Erro ao conectar o Banco de Dados.";
    }

?>
