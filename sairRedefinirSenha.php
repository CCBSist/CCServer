<?php

session_start("sessaoSenha");
session_destroy();
echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL='index.php'\">";
?>