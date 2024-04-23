<?php

    // Criando conexão com o Banco de Dados
    function conectar() {
        try {
        $conexao = new PDO("mysql:host=127.0.0.1; dbname=licitflow", "root", "Root1234*");
        } catch(PDOException $e) {
            echo $e -> getMessage();
            echo $e -> getCode();
        }

        return $conexao;
    }
    
?>