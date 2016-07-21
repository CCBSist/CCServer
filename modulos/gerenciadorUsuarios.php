<script>
    $(document).ready(function () {
        mostraDadosUsuarios('regras/users/usersistema.txt');

        $("#bt-novo").click(function () {
            preparaEdicao("", "", "", "", "", "");
        });

        $("#bt-grupoUser").click(function () {
            var novaURL = "index.php?modulos=alterarGrupoUsuario";
            $(window.document.location).attr('href', novaURL);
        });
    });

    function mostraDadosUsuarios(arquivo) {
        var d = "arquivo=" + arquivo;
        $.ajax({
            type: "POST",
            data: d,
            url: "viewTabelaUsuarioSistema.php",
            dataType: "html",
            success: function (result) {
                $("#tabela").html('');
                $("#tabela").append(result);
            },
            beforeSend: function () {
                $('#carregando').css({display: "block"});
            },
            complete: function (msg) {
                $('#carregando').css({display: "none"});
            }
        });
    }

    function preparaEdicao(numero, valor, admin, squid, samba, radio) {
        $("#codigo").val(numero);
        $("#nome").val(valor);

        if (admin === "admin") {
            document.getElementById('checkboxAdmin').checked = true;
        } else {
            document.getElementById('checkboxAdmin').checked = false;
        }

        if (squid === "squid") {
            document.getElementById('checkboxSquid').checked = true;
            document.getElementById('liberado').disabled = false;
            document.getElementById('default').disabled = false;
        } else {
            document.getElementById('checkboxSquid').checked = false;
            document.getElementById('liberado').disabled = true;
            document.getElementById('default').disabled = true;
        }

        if (samba === "samba") {
            document.getElementById('checkboxSamba').checked = true;
        } else {
            document.getElementById('checkboxSamba').checked = false;
        }

        if (radio === "liberado") {
            document.getElementById('liberado').checked = true;
        } else {
            document.getElementById('liberado').checked = false;
        }

        if (radio === "default") {
            document.getElementById('default').checked = true;
        } else {
            document.getElementById('default').checked = false;
        }
        habilitar();
    }
    function preparaExcluir(nome) {
        $("#usuario").val(nome);
    }

    function habilitar() {
        if (document.getElementById('checkboxSquid').checked) {
            document.getElementById('liberado').disabled = false;
            document.getElementById('default').disabled = false;
            document.getElementById('default').checked = true;
        } else {
            document.getElementById('liberado').disabled = true;
            document.getElementById('default').disabled = true;
        }

        if ($("#codigo").val() === "") {
            document.getElementById('nome').readOnly = false;
        } else {
            document.getElementById('nome').readOnly = true;
        }
    }
</script>
<?php
$caminhos ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userSistema = verificaUsuarioSistema($_POST['nome']);
    $userSquid = verificaUsuarioTodos($_POST['nome'], DIR_USER_SQUID);
    $userLiberados = verificaUsuarioTodos($_POST['nome'], DIR_USER_LIBERADOS);
    $userDefault = verificaUsuarioTodos($_POST['nome'], DIR_USER_DEFAULT);
    $userSamba = verificaUsuarioTodos($_POST['nome'], DIR_USER_SAMBA);
    if (preg_match("/^[a-z.]+?$/i", $_POST["nome"])) {
        if (($userSistema <> "" || $userSquid <> "" || $userLiberados <> "" || $userDefault <> "" || $userSamba <> "" ) && $_POST['codigo'] == "") {
            $erro = '<div class="alert alert-danger" role="alert"> Usuário já cadastrado! </div>';
        } else {
            $conteudo = $_POST["nome"] . ":::|:::" . md5($_POST['senha']) . ":::|:::";
            if ($_POST['checkboxAdmin'] <> 'adm') {
                $conteudo .= " ";
            } else {
                $conteudo .= "admin";
            }
            if ($_POST['checkboxSquid'] == 'squid') {
                $conteudo .= ":::|:::" . "squid";
                $caminhos .= "squid" . ":";
            } else {
                $conteudo .= ":::|:::" . " ";
                $caminhos .= " " . ":";
            }
            if ($_POST['checkboxSamba'] == 'samba') {
                $conteudo .= ":::|:::" . "samba";
                $caminhos .= "samba" . ":";
            } else {
                $conteudo .= ":::|:::" . " ";
                $caminhos .= " " . ":";
            }
            if ($_POST['radio'] == 'liberado') {
                $caminhos .= "liberados";
            }

            if ($_POST['radio'] == 'default') {
                $caminhos .= "default";
            }

            if ($conteudo == $_POST["nome"] . ":::|:::" . md5($_POST['senha']) . ":::|:::" . " " . ":::|:::" . " " . ":::|:::" . " ") {
                $erro = '<div class="alert alert-warning" role="alert"> <strong>É necessário marcar alguma opção! </strong></div>';
            } else {
                verificaGravar($_POST["nome"], $_POST['senha'], $conteudo, $_POST['codigo'], $caminhos);
                $erro = '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> <strong>Usuário cadastrado com sucesso! </strong></div>';
            }
        }
    } else {
        $erro = '<div class="alert alert-danger" role="alert"> <strong> Nome de Usuário Inválido! </strong> </div>';
    }
}


if (filter_input(INPUT_GET,'acao') === 'excluir' && filter_input(INPUT_GET,'numero') <> '') {
    $nome = filter_input(INPUT_GET,'nome');
    $numero = filter_input(INPUT_GET,'numero');
    verificaExcluir($nome, $numero);
}
?>
<script>
    habilitar();
</script>
<div class="text-right">
    <div class="btn-group" id="dv-menu-topo">
        <button type="button" id="bt-novo" class= "btn btn-default "> Novo</button>
        <button type="button" id="bt-grupoUser" class= "btn btn-default "> Gerenciar Grupo Usuario</button>
    </div>
</div>
<div class="jumbotron">
    <form action="index.php?modulos=principal&aba=gerenciadorUsuarios" id="formulario_usuario" method="POST" class="form-horizontal" role="form">
        <input type="hidden" value="" name="codigo" id='codigo' />
        <div class="form-group">
            <label for="nome" class="col-sm-2 control-label">Nome * </label>
            <div class="col-sm-7">
                <input type="text" name="nome" id='nome' class="form-control"  required autofocus/> 								
            </div>

        </div>
        <div class="form-group">
            <label for="nome" class="col-sm-2 control-label">Senha * </label>
            <div class="col-sm-7">
                <input type="password" name="senha" id="senha" class="form-control" required /> 								
            </div>
        </div>
        <div class="form-group">
            <label for="nome" class="col-sm-2 control-label">Confirmação de Senha * </label>
            <div class="col-sm-7">
                <input type="password" name="confirmacao" id="confirmacao" class="form-control" required /> 								
            </div>
            <div class="col-sm-2">
                <input type="submit" name="submit" id="submit" value="Gravar" class="btn btn-primary"/>			
            </div>
        </div>
        <div class="form-group">

            <div align="center">
                <input type="checkbox" class="checkbox-inline" name="checkboxAdmin" id="checkboxAdmin" value="adm" > Administrador
                <input type="checkbox" class="checkbox-inline" name="checkboxSquid" id="checkboxSquid" value="squid" onclick="habilitar();" > Squid
                <input type="checkbox" class="checkbox-inline" name="checkboxSamba" id="checkboxSamba" value="samba" onclick="habilita_samba();"> Samba
            </div>
        </div>

        <div class="form-group">
            <div align="center">
                <input type="radio" name="radio" class="radio-inline" value="liberado" id='liberado' disabled>Liberado
                <input type="radio" name="radio" class="radio-inline" value="default" id='default' disabled>Default
            </div>
        </div>
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> Deseja excluir esse usuario? </div> <div class="modal-body"></div> <div class="modal-footer"> <button type="button" class="btn btn-default" data-dismiss="modal">Cancela</button> <a href="#" class="btn btn-danger danger">Excluir</a> </div> </div> </div> </div>    
    </form>  
    <p> 
    <?php 
        $erro="";
        echo $erro; 
        ?> 
    </p>
</div>
<div id='carregando' style="display: none;"><img src="imagens/carregando.gif"/></div>
<div id='tabela'></div>