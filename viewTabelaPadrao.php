<?php
include ("functions/Utils.php");
?>


<table class='table table-bordered  table-hover table-condensed' style="margin: 0 auto; ">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>
                Itens
            </th>       
        </tr>
    </thead>
    <tbody>
        <?php
        $dados = listaDadosPadrao($_POST['arquivo']);

        $linha = 0;

        foreach ($dados as $d) {
            ?>
            <tr>
                <td align='center' class='col-md-1'><a href='index.php?modulos=<?= $_POST['modulo'] ?>&acao=excluir&numero=<?php echo $linha ?>&nome=<?php echo $d ?>'><img src='imagens/del.png' /></a> </td>
                <td align='center' class='col-md-1'><a href="javascript: preparaEdicao('<?php echo $linha ?>','<?= $d ?>');" ><img src='imagens/edit.png' /></a> </td>
                <td><?= $d ?></td>
            </tr>    
            <?php
            $linha++;
        }
        if (count($dados) <= 0) {
            echo "<tr>";
            echo "<td colspan='3'>Nenhum registro encontrado</td>";
            echo "</tr>";
        }
        ?> 
    </tbody>
</table>
