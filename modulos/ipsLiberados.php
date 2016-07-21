<script>
    $(document).ready(function () {
        mostraDados('regras/liberados/ips_liberados.txt', 'ipsLiberados');

        $("#bt-novo").click(function () {
            preparaEdicao("", "");
        });
    });

    function preparaEdicao(numero, valor) {
        $("#codigo").val(numero);
        $("#nome").val(valor);
    }

</script>
<?php
$arquivo = "regras/liberados/ips_liberados.txt";
$erro = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conteudo = $_POST["nome"];
    if (filter_var($conteudo, FILTER_VALIDATE_IP)) {
        if (buscarIp($conteudo) === "") {
            gravar($arquivo, $conteudo, $_POST['codigo']);
        } else {
            $erro = "Esse IP está cadastrado";
        }
    } else {
        $erro = "IP Inválido";
    }
}

if (filter_input(INPUT_GET,'acao') == 'excluir' && filter_input(INPUT_GET,'numero') <> '') {
    excluir($arquivo, filter_input(INPUT_GET,'numero'));
}
?>


<div class="text-right" id="dv-menu-topo">
    <div class="btn-group">
        <button type="button" id="bt-novo" class= "btn btn-default ">Novo</button>
        <button type="button" id="bt-aplicar" class= "btn btn-default ">Aplicar</button>
        <button type="button" id="bt-menu" class= "btn btn-default ">Voltar ao Menu</button>
        <button type="button" id="bt-sair" class= "btn btn-default ">Sair</button>
    </div>
</div>
<ol class="breadcrumb">
    <li><a href="index.php?modulos=principal"><span class="glyphicon glyphicon-home"></span> Principal</a></li>
    <li class="active">Ips Liberados</li>
</ol>
<div class="jumbotron">
    <form action="index.php?modulos=ipsLiberados" id="formulario_usuario" method="POST" class="form-horizontal" role="form">
        <input type="hidden" value="" name="codigo" id='codigo' />
        <div class="form-group">
            <label for="nome" class="col-sm-2 control-label">IP * </label>
            <div class="col-sm-7">
                <input type="text" name="nome" id='nome' class="form-control" placeholder="<?php echo $erro ?>" required autofocus/> 								
            </div>
            <div class="col-sm-2 ">
                <input type="submit" name="submit" id="submit" value="Gravar" class="btn btn-primary"/>			
            </div>
        </div>
    </form> 
</div>
<div id='carregando' style="display: none;"><img src="imagens/carregando.gif"/></div>
<div id='tabela'></div>



