<script>
    $(document).ready(function () {
        mostraDados('regras/grupos.txt', 'grupo');

        $("#bt-novo").click(function () {
            preparaEdicao("", "");
        });

        $("#bt-menu").click(function () {
            var novaURL = "index.php?modulos=principal&aba=arquivos";
            $(window.document.location).attr('href', novaURL);
        });

        $("#bt-grupoUser").click(function () {
            var novaURL = "index.php?modulos=alterarGrupoUsuario";
            $(window.document.location).attr('href', novaURL);
        });
    });

    function preparaEdicao(numero, valor) {
        $("#codigo").val(numero);
        $("#grupo").val(valor);
    }
</script>

<?php
$arquivo = "regras/grupos.txt";
$erros = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conteudo = $_POST["grupo"];
    $erros = adicionaGrupo($conteudo, $arquivo, $_POST['codigo']);
}

if (filter_input(INPUT_GET,'acao') == 'excluir' && filter_input(INPUT_GET,'numero') <> '') {
    excluir($arquivo, filter_input(INPUT_GET,'numero'));
    excluir_grupo(filter_input(INPUT_GET,'nome'));
}
?>

<div class="text-right">
    <div class="btn-group" id="dv-menu-topo">
        <button type="button" id="bt-novo" class= "btn btn-default ">Novo</button>
        <button type="button" id="bt-grupoUser" class= "btn btn-default "> Gerenciar Grupo Usuario</button>
        <button type="button" id="bt-menu" class= "btn btn-default ">Voltar ao Menu</button>
        <button type="button" id="bt-sair" class= "btn btn-default ">Sair</button>
    </div>
</div>
<ol class="breadcrumb">
    <li><a href="index.php?modulos=principal&aba=arquivos"><span class="glyphicon glyphicon-home"></span> Principal</a></li>
    <li class="active"><span class="glyphicon glyphicon-list-alt"></span> Grupos</li>
</ol>
<div class="jumbotron">
    <form action="index.php?modulos=grupo" id="formulario_usuario" method="POST" class="form-horizontal" role="form">
        <input type="hidden" value="" name="codigo" id='codigo' />
        <div class="form-group">
            <label for="nome" class="col-sm-2 control-label">grupo *</label>
            <div class="col-sm-7">
                <input type="text" name="grupo" id="grupo" class="form-control" placeholder="<?php echo $erros ?>" required autofocus/> 								
            </div>
            <div class="col-sm-2 ">
                <input type="submit" name="submit" id="submit" value="Gravar" class="btn btn-primary"/>			
            </div>
        </div>
    </form>  
</div>
<div id='carregando' style="display: none;"><img src="imagens/carregando.gif"/></div>
<div id='tabela'></div>



