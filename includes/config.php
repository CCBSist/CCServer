<?php

define('OS', strtoupper(substr(PHP_OS, 0, 3)));
if (OS == "WIN") {
    define("DIR_SISTEMA", "C:/xampp/htdocs/SquidControl");
} else {
    define("DIR_SISTEMA", "/var/www/html/SquidControl");
}
define("DIR_DADOS", "/home/dados");
define("DIR_USUARIO", "/home/dados/usuarios");
define("DIR_USER_SAMBA", DIR_SISTEMA ."/regras/users/usersamba.txt");
define("DIR_USER_SQUID", DIR_SISTEMA ."/regras/users/usersquid.txt");
define("DIR_USER_SISTEMA", DIR_SISTEMA ."/regras/users/usersistema.txt");
define("DIR_USER_LIBERADOS", DIR_SISTEMA ."/regras/users/liberados.txt");
define("DIR_USER_DEFAULT", DIR_SISTEMA ."/regras/users/default.txt");
define("DIR_IP_LIBERADO", DIR_SISTEMA ."/regras/liberados/ips_liberados.txt");
define("DIR_IP_BLOQUEADO", DIR_SISTEMA ."/regras/bloqueados/ips_bloqueados.txt");

$titulo_pagina = "SquidControl";
?>