<?php
include ("functions/Utils.php");
?>
<script>
    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
<table class='table table-bordered  table-hover table-condensed' style="margin: 0 auto;">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>
                Usuarios
            </th>    
            <th>Admin</th>
            <th>Squid</th>
            <th>Samba</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dados = listaDadosPadrao($_POST['arquivo']);
        $linha = 0;
        foreach ($dados as $d) {
            $arrM = explode(":::|:::", $d);
            ?>
            <tr>     
                <?php
                $nome = $arrM[0];
                $arquivoLiberados = "regras/users/liberados.txt";
                $userLiberados = verificaUsuarioTodos($nome, $arquivoLiberados);
                $arquivoDefault = "regras/users/default.txt";
                $userDefault = verificaUsuarioTodos($nome, $arquivoDefault);
                $radio = "";
                if ($userLiberados <> "") {
                    $radio = "liberado";
                }
                if ($userDefault <> "") {
                    $radio = "default";
                }
                ?>                                  
                <td align='center' class='col-md-1'><a data-href='index.php?modulos=principal&aba=gerenciadorUsuarios&acao=excluir&numero=<?php echo $linha ?>&nome=<?= $arrM[0]; ?>'  data-toggle="modal" data-target="#confirm-delete"  href="javascript: preparaExcluir('<?= $arrM[0] ?>');"   ><img src='imagens/del.png' /></a> </td>
                <td align='center' class='col-md-1'><a href="javascript: preparaEdicao('<?php echo $linha ?>','<?= $arrM[0] ?>','<?= $arrM[2] ?>','<?= $arrM[3] ?>','<?= $arrM[4] ?>','<?php echo $radio ?>');" onclick="$('#nome').focus()"  ><img src='imagens/edit.png' /></a></td>
                <td><?= $arrM[0]; ?></td>
                <td align='center' class='col-md-1'><?= $arrM[2] == "admin" ? '<span class="glyphicon glyphicon-ok"></span>' : " " ?></td>
                <td align='center' class='col-md-1'><?= $arrM[3] == "squid" ? '<span class="glyphicon glyphicon-ok"></span>' : " " ?></td>
                <td align='center' class='col-md-1'><?= ($arrM[4] == "samba" || $arrM[4] == "samba\n") ? '<span class="glyphicon glyphicon-ok"></span>' : " " ?></td>
            </tr>    
            <?php
            $linha++;
        }
        ?> 

    </tbody>
</table>
<p></p>
