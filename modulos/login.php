<?php
if (!file_exists(DIR_USER_SISTEMA)) {
    $novoUser = '<div class="alert alert-danger" role="alert"> Usuário: admin, senha: admin; favor alterar. </div>';
    echo $novoUser;
    $conteudo = "admin" . ":::|:::" . md5("admin") . ":::|:::" . "admin" . ":::|:::" . " " . ":::|:::" . " ";
    gravarUsuarios(DIR_USER_SISTEMA, $conteudo);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incorreto = "";
    $logado = buscarUsuarios($_POST['nome'], md5($_POST['senha']));
    if (($logado[2] == "admin") && !($logado[0] == "admin" && $logado[1] == md5("admin"))) {
        header("Location: index.php?modulos=principal");
    } else if (($logado[3] == "squid" || $logado[4] == "samba" || $logado[4] == "samba\n") || ($logado[0] == "admin" && $logado[1] == md5("admin"))) {
        session_start();
        $_SESSION['nome'] = $_POST['nome'];
        header("Location:  redefinirSenha.php");
    } else {
        $incorreto = '<div class="alert alert-danger" role="alert"> Usuário ou senha incorreta </div>';
    }
}
?>
<div class="row">
    <div id="conteudo" class="col-md-12">                
        <div class="col-md-4 col-lg-offset-4"> 
            <form class="form-signin" role="form" action="index.php?modulos=login" method="POST">
                <h3><span class="glyphicon glyphicon-circle-arrow-down"></span> Login</h3>
                <input type="hidden" value="principal" id="pagina" name="pagina" />
                <input type="text" name="nome" id="email" class="form-control" placeholder="Login" required autofocus>
                <input type="password" name="senha" id="senha" class="form-control"   placeholder="Senha" required>    
                <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            </form>
            <p> 
            <?php 
                $incorreto ="";
                echo $incorreto;
            ?> 
            </p>
        </div>
    </div>
</div>