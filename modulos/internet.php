<div class="jumbotron" style="text-align: center">
    <p>
        <a href="index.php?modulos=ipsLiberados" class="btn btn-primary btn-lg botoes">
            IPs Liberados
        </a>
        <a href="index.php?modulos=ipsBloqueados" class="btn btn-primary btn-lg botoes">
            IPs Bloqueados
        </a>
    </p>
    <p>
        <a href="index.php?modulos=livresSemSenha" class="btn btn-primary btn-lg botoes">
            Dominios sem senha
        </a>
        <a href="index.php?modulos=urlBloqueadas" class="btn btn-primary btn-lg botoes">
            Dominios Bloqueados
        </a>
    </p>
    <p>
        <a href="index.php?modulos=extBloqueadas" class="btn btn-primary btn-lg botoes">
            Extensões Bloqueadas
        </a>
        <button name="bt-squid" id="bt-squid" type="button" data-toggle="modal" data-target="#myModalSquid" class="btn btn-primary btn-lg botoes"> <span class="glyphicon glyphicon-refresh"></span> Reiniciar Squid</button>
</div>

<div class="modal fade" id="myModalSquid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <div id='reiniciandoServico'></div>
                    <?php
                }
                ?>
            </div>
            <?php
            if (PHP_OS == "Linux") {
                ?>
                <div class="modal-footer">
                    <button type="button" name="bt-servico" id="bt-servico" class="btn btn-primary">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>