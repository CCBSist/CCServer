<script>
    $(document).ready(function () {
        $("#table thead tr th:first input:checkbox").click(function () {
            var checkedStatus = this.checked;
            $("#table tbody tr td:first-child input:checkbox").each(function () {
                this.checked = checkedStatus;
            });
        });
    });
</script>
<?php
include ("includes/config.php");
include ("functions/Utils.php");
?>

<div class="col-lg-6">
    <table id="table" class='table table-bordered  table-hover table-condensed'>
        <thead>
            <tr>
                <th align='center'><input type="checkbox"  name="checkboxGrupo[]" id='checkboxGrupo' value='' /></th>
                <th>
                    Grupos
                </th>       
            </tr>
        </thead>
        <tbody>
            <?php
            $arrM = shell_exec("cat " . DIR_SISTEMA . "/regras/grupos.txt");
            $dados = array();
            if ($arrM <> "") {
                $dados = explode("\n", $arrM);
            }

            $usuario = $_POST['usuario'];
            $arquivo = fopen(DIR_SISTEMA . "/regras/gerencia_grupos.txt", "r");
            $grupoSelecionado = array();
            while (!feof($arquivo)) {
                $lin = fgets($arquivo);
                $valor = explode(":", $lin);
                if ($usuario <> "" && ($valor[0] == trim($usuario))) {
                    $grupoSelecionado = $valor;
                }
            }

            foreach ($dados as $d) {
                $sel = "";
                foreach ($grupoSelecionado as $key => $g) {
                    if ($g == $d) {
                        $sel = "checked";
                    }
                }
                ?>
                <tr>
                    <td align='center' class='col-md-1'><input type="checkbox"  name="checkboxGrupo[]" id='checkboxGrupo' value='<?= $d ?>' <?= $sel ?> /></td>
                    <td><?= $d ?></td>
                </tr>    
                <?php
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
