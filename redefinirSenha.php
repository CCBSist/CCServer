<?php
header('Content-Type: text/html; charset=ISO8859-1');
session_start();
include ("functions/Utils.php");
include ("includes/config.php");
$nome = $_SESSION['nome'];
if ($nome == "") {
    header("Location:  index.php?modulos=login");
}
$senha = buscarSenha($nome);
$arquivo = "regras/users/usersistema.txt";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incorreto = "";
    if ($_POST['senhaNova'] <> $_POST['confirmacao']) {
        $incorreto = '<div class="alert alert-danger" role="alert"> Senhas diferentes! </div>';
    } else if (md5($_POST['senhaAtual']) <> $senha) {
        $incorreto = '<div class="alert alert-danger" role="alert"> Senha atual incorreta! </div>';
    } else {
        redefinirSenha($nome, $_POST['senhaNova']);
        header("Location: index.php");
    }
}
?>
<html>
    <head>
        <meta charset="iso-8859-1">
        <link rel="shortcut icon" href="imagens/icone.ico">
        <title>SquidControl</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/style.css">

        <script src="js/jquery-2.1.1.js"></script>
        <script src="js/bootstrap.js"></script>
        <script>
            $(document).ready(function() {
                $("#bt-sair").click(function() {
                    var novaURL = "sairRedefinirSenha.php";
                    $(window.document.location).attr('href', novaURL);
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div id="conteudo" class="col-md-12">
                    <div class="text-right" id="dv-menu-topo">
                        <div class="btn-group">
                            <button name="bt-sair" id="bt-sair" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Sair</button>
                        </div>
                    </div>
                    <ul class="breadcrumb">
                        <li><font color="gray"> <span class="glyphicon glyphicon-lock"></span> Redefinir Senha</font></li>
                    </ul>
                    <div class="jumbotron">
                        <form action="redefinirSenha.php" id="formulario_usuario" method="POST" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="nome" class="col-sm-2 control-label">Senha Atual * </label>
                                <div class="col-sm-7">
                                    <input type="password" name="senhaAtual" id='senhaAtual' class="form-control" required autofocus/> 								
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nome" class="col-sm-2 control-label">Senha * </label>
                                <div class="col-sm-7">
                                    <input type="password" name="senhaNova" id="senhaNova" class="form-control" required /> 								
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nome" class="col-sm-2 control-label">Confirmação de Senha * </label>
                                <div class="col-sm-7">
                                    <input type="password" name="confirmacao" id="confirmacao" class="form-control" required /> 								
                                </div>
                                <div class="col-sm-2 ">
                                    <input type="submit" name="submit" id="submit" value="Salvar" class="btn btn-primary"/>			
                                </div>
                            </div>
                        </form> 
                        <p> <?php 
                            $incorreto = "";
                            echo $incorreto;
                        ?> </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>