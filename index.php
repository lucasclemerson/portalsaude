<?php
    session_start();
    header('Content-Type: text/html; charset=UTF-8');
    date_default_timezone_set("Brazil/East");

    const SERVIDOR = "localhost";
    const BANCO = "investteimoveisb_imob";
    const USUARIO = "investteimoveisb_imob";
    const SENHA = "Investt@135@";
    const PASTA = "";
    const AUTOR = "Clemerson Lucas de Olveiria";


    define("DOMINIO", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/");
    define("PASTA_CLIENTE", DOMINIO."arquivos/");
    define("AUTOR", AUTOR);
    define("CONTROLLERS", "controllers/");
    define("VIEWS", "views/");
    define("MODELS", "models/");
    define("LAYOUT", DOMINIO.VIEWS);

    require_once('system/system.php');
    require_once('system/mysql.php');
    require_once('system/controller.php');

    function auto_carregar($arquivo)
    {
        if (file_exists(MODELS . $arquivo . ".php")) {
            require_once(MODELS . $arquivo . ".php");
        } else {
            echo "Erro: Um arquivo importante do sistema não foi encontrado ($arquivo)!";
            exit;
        }
    }

    spl_autoload_register("auto_carregar");
    $start = new system();
    $start->run();