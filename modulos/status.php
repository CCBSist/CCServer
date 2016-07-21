<?php
if (PHP_OS <> "Linux") {
    include ("includes/recursoIndisponivel.php");
} else {
    ?>
    <div class="text-right" id="dv-menu-topo">
        <div class="btn-group">
            <button type="button" id="bt-menu" class= "btn btn-default ">Voltar ao Menu</button>
            <button type="button" id="bt-sair" class= "btn btn-default ">Sair</button>
        </div>
    </div>
    <?php
    include ("phpsysinfo/index.php");
}
?>