<script>
    $(document).ready(function () {
        selecionaGrupos();

        $("#bt-grupo").click(function () {
            var novaURL = "index.php?modulos=grupo";
            $(window.document.location).attr('href', novaURL);
        });

        $("#bt-user").click(function () {
            var novaURL = "index.php?modulos=principal&aba=gerenciadorUsuarios";
            $(window.document.location).attr('href', novaURL);
        });

        $("input[type=radio][name=usuario]").click(function () {
            selecionaGrupos();
        });

    });

    function selecionaGrupos() {
        var user = $("input[type=radio][name=usuario]:checked").val();
        mostraGrupos('alterarGrupoUsuario', user);
    }

    function mostraGrupos(modulo, user) {
        var d = "modulo=" + modulo + "&usuario=" + user;
        $.ajax({
            type: "POST",
            data: d,
            url: "viewSelecionaGrupo.php",
            dataType: "html",
            success: function (result) {
                $("#grupos").html('');
                $("#grupos").append(result);
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
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erro = "";
    if (empty($_POST['checkboxGrupo']) == array() && $_POST['usuario'] <> "") {
        alterar_grupo($_POST['usuario'], $_POST['checkboxGrupo']);
    } else {
        $erro = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong> Selecione os grupos do usuário antes de gravar. </strong></div>';
    }
}
?>

<div class="text-right">
    <div class="btn-group" id="dv-menu-topo">
        <button type="button" id="bt-grupo" class= "btn btn-default ">Novo Grupo</button>
        <button type="button" id="bt-user" class= "btn btn-default ">Novo Usuario</button>
        <button type="button" id="bt-menu" class= "btn btn-default ">Voltar ao Menu</button>
        <button type="button" id="bt-sair" class= "btn btn-default ">Sair</button>
    </div>
</div>
<ol class="breadcrumb">
    <li><a href="index.php?modulos=principal&aba=arquivos"><span class="glyphicon glyphicon-home"></span> Principal</a></li>
    <li class="active"> <span class="glyphicon glyphicon-user"></span> Alterar Grupo do Usuário</li>
</ol>
<div class="col-sm-12">
    <?php 
        $erro = "";
        echo $erro; 
     ?>
</div>
<form action="index.php?modulos=alterarGrupoUsuario" id="form_grupo" method="POST" class="form-horizontal" role="form">
    <div class="col-lg-6">
        <table class='table table-bordered  table-hover table-condensed'>
            <thead>
                <tr>
                    <th></th>
                    <th>
                        Usuarios
                    </th>       
                </tr>
            </thead>
            <tbody>
                <?php
                $dados = listaDadosPadrao("regras/users/usersamba.txt");

                $sel = "checked";
                foreach ($dados as $d) {
                    ?>
                    <tr>
                        <td align='center' class='col-md-1'>
                            <input type="radio" name="usuario" id='usuario' value='<?= str_replace(["\n","\r"], "", $d) ?>' <?= $sel ?> />
                        </td>
                        <td><?= $d ?></td>
                    </tr>    
                    <?php
                    $sel = "";
                }
                if (count($dados) <= 0) {
                    echo "<tr>";
                    echo "<td colspan='3'>Nenhum registro encontrado</td>";
                    echo "</tr>";
                }
                ?> 
            </tbody>
        </table>
    </div>
    <div id='grupos'></div>
    <div id='carregando'></div>
    <div class="col-sm-12 text-right">
        <input type="submit" name="submit" id="submit" value="Gravar" class="btn btn-primary btn-lg"/>			
    </div>
</form>