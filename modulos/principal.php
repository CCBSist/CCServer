<?php
$aba = filter_input(INPUT_GET,'aba');
?>
<script>
    $(document).ready(function () {

        $("#bt-servidor").click(function () {
            reiniciarServidor();
        });

        $("#bt-servico").click(function () {
            reiniciarSquid();
        });

        $("#bt-servsamba").click(function () {
            reiniciarSamba();
        });

        $("#bt-status").click(function () {
            var novaURL = "phpsysinfo/";
            $(window.document.location).attr('href', novaURL);
        });
    });

    function reiniciarSquid() {
        var d = "";
        $.ajax({
            type: "POST",
            data: d,
            url: "includes/reiniciarServico.php",
            dataType: "html",
            success: function (result) {
                $("#reiniciandoServico").html('');
                $("#reiniciandoServico").append(result);
            },
            beforeSend: function () {
                $('#carregando').css({display: "block"});
            },
            complete: function (msg) {
                $('#carregando').css({display: "none"});
            }
        });
    }

    function reiniciarSamba() {
        var d = "";
        $.ajax({
            type: "POST",
            data: d,
            url: "includes/reiniciarSamba.php",
            dataType: "html",
            success: function (result) {
                $("#reiniciandoSamba").html('');
                $("#reiniciandoSamba").append(result);
            },
            beforeSend: function () {
                $('#carregando').css({display: "block"});
            },
            complete: function (msg) {
                $('#carregando').css({display: "none"});
            }
        });
    }

    function reiniciarServidor() {
        var d = "";
        $.ajax({
            type: "POST",
            data: d,
            url: "includes/reiniciar.php",
            dataType: "html",
            success: function (result) {
                $("#reiniciando").html('');
                $("#reiniciando").append(result);
            },
            beforeSend: function () {
                $('#carregando').css({display: "block"});
            },
            complete: function (msg) {
                $('#carregando').css({display: "none"});
            }
        });
    }
</script>
<ul class="nav nav-tabs" role="tablist" id="dv-menu-topo">
    <li <?= $c = ($aba == "internet") || ($aba == "") ? "class='active'" : "" ?>><a href="index.php?modulos=principal&aba=internet">Servidor de Internet</a></li>
    <li <?= $c = ($aba == "arquivos") ? "class='active'" : "" ?>><a href="index.php?modulos=principal&aba=arquivos">Servidor de Arquivos</a></li>
    <li <?= $c = ($aba == "gerenciadorUsuarios") ? "class='active'" : "" ?>><a href="index.php?modulos=principal&aba=gerenciadorUsuarios">Gerenciador de Usuários</a></li>
</ul>

<?php
if ($aba == "") {
    include ("modulos/internet.php");
} else {
    if (file_exists("modulos/" . $aba . ".php")) {
        include ("modulos/" . $aba . ".php");
    } else {
        echo "<div align='center'><br /><br /><br /><br />";
        echo "<img src='imagens/notfound.png' border='0' /><br /><br />";
        echo "<h3> Pagina não encontrada! <h3>";
        echo "</div>";
    }
}
?>

<div class="text-center">
    <div class="btn-group">
        <button name="bt-status" id="bt-status" type="button" class="btn btn-default "><span class="glyphicon glyphicon-list"></span> Status Máquina</button>
        <button name="bt-reiniciar" id="bt-reiniciar" class="btn btn-default" data-toggle="modal" data-target="#myModal" type="button"><span class="glyphicon glyphicon-refresh"></span> Reiniciar Servidor</button>       
        <button name="bt-sair" id="bt-sair" type="button" class="btn btn-default"><span class="glyphicon glyphicon-off"></span> Sair</button>
    </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="myModalLabel"> <span class="glyphicon glyphicon-warning-sign"></span></h3>
            </div>
            <div class="modal-body">
                <?php
                if (PHP_OS <> "Linux") {
                    echo 'Recurso Indisponível';
                } else {
                    ?>
                    Deseja Reiniciar o Servidor?
                    <div id='carregando' style="display: none;">Carregando...</div>
                    <div id='reiniciando'></div>
                    <?php
                }
                ?>
            </div>
            <?php
            if (PHP_OS == "Linux") {
                ?>
                <div class="modal-footer">
                    <button type="button" name="bt-servidor" id="bt-servidor" class="btn btn-primary">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>