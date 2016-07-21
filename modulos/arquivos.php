<div class="jumbotron" style="text-align: center">
    <a class="btn btn-primary btn-lg botoes" href="index.php?modulos=grupo">Grupos</a>
    <a class="btn btn-primary btn-lg botoes" href="index.php?modulos=alterarGrupoUsuario">Alterar Grupo do Usuário</a>
    <button name="bt-samba" id="bt-squid" type="button" data-toggle="modal" data-target="#myModalSamba" class="btn btn-primary btn-lg botoes"><span class="glyphicon glyphicon-refresh"></span> Reiniciar Samba</button>
</div>

<div class="modal fade" id="myModalSamba" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    Deseja Reiniciar o Serviço?
                    <div id='carregando' style="display: none;">Carregando...</div>
                    <div id='reiniciandoSamba'></div>
                    <?php
                }
                ?>
            </div>
            <?php
            if (PHP_OS == "Linux") {
                ?>
                <div class="modal-footer">
                    <button type="button" name="bt-servsamba" id="bt-servico" class="btn btn-primary">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>