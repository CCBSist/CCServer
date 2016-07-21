<?php
header('Content-Type: text/html; charset=ISO8859-1');
session_start();
include ("./includes/config.php");
include ("functions/Utils.php");

if (isset($_SESSION['logado']) === true) {
    
    $modulo = filter_input(INPUT_GET, 'modulos');
} else {
    $modulo = "login";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="iso-8859-1">
        <link rel="shortcut icon" href="imagens/icone.ico">
        <title><?=$titulo_pagina?></title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/style.css">

        <script src="js/jquery-2.1.1.js"></script>
        <script src="js/bootstrap.js"></script>

        <script>
            $(document).ready(function() {
                $("#bt-sair").click(function() {
                    var novaURL = "sair.php";
                    $(window.document.location).attr('href', novaURL);
                });

                $("#bt-aplicar").click(function() {
                    aplicar();
                });

                $("#bt-menu").click(function() {
                    var novaURL = "index.php?modulos=principal";
                    $(window.document.location).attr('href', novaURL);
                });
            });

            function mostraDados(arquivo, modulo) {
                var d = "arquivo=" + arquivo + "&modulo=" + modulo;
                $.ajax({
                    type: "POST",
                    data: d,
                    url: "viewTabelaPadrao.php",
                    dataType: "html",
                    success: function(result) {
                        $("#tabela").html('');
                        $("#tabela").append(result);
                    },
                    beforeSend: function() {
                        $('#carregando').css({display: "block"});
                    },
                    complete: function(msg) {
                        $('#carregando').css({display: "none"});
                    }
                });
            }

            function aplicar() {
                var d = "";
                $.ajax({
                    type: "POST",
                    data: d,
                    url: "includes/aplicar.php",
                    dataType: "html",
                    success: function(result) {
                        $("#aplicado").html('');
                        $("#aplicado").append(result);
                    },
                    beforeSend: function() {
                        $('#aplicando').css({display: "block"});
                    },
                    complete: function(msg) {
                        $('#aplicando').css({display: "none"});
                    }
                });
            }
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div id="aplicando" style="display: none;"><img src="imagens/carregando.gif"/></div>
                <div id="aplicado"></div>
                <div id="conteudo" class="col-md-12"> 
                    <?php
                    if ($modulo == "") {
                        include ("modulos/login.php");
                    } else {
                        if (file_exists("modulos/" . $modulo . ".php")) {
                            include ("modulos/" . $modulo . ".php");
                        } else {
                            echo "<div align='center'><br /><br /><br /><br />";
                            echo "<img src='notfound.png' border='0' /><br /><br />";
                            echo "<h3> Pagina não encontrada !!! <h3>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>

<!--            <div class="dv-footer">
              <p>Desenvolvido por  <a href="http://www.mactus.com.br" target="_blank">Mactus Soluções em T.I.</a>  Todos os Direitos Reservados</p>
            </div>-->
        </div>
    </body>
</html>
