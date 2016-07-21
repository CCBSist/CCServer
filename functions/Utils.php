<?php

function buscarSenha($nome) {
    $arquivo = fopen(DIR_USER_SISTEMA, "r+");
    if (!file_exists(DIR_USER_SISTEMA)) {
        exec('/bin/touch ' . DIR_USER_SISTEMA);
    }

    $user = "";
    while (!feof($arquivo)) {
        $arrM = explode(":::|:::", fgets($arquivo));
        $parte_user = trim($arrM[0]);
        if ($parte_user === $nome) {
            $user = trim($arrM[1]);
        }
    }
    fclose($arquivo);
    return $user;
}

function buscarUsuarios($nome, $senha) {
    $arquivo = fopen(DIR_USER_SISTEMA, "r");
    $adm = "";
    if (!file_exists(DIR_USER_SISTEMA)) {
        exec('/bin/touch ' . DIR_USER_SISTEMA);
    }
    while (!feof($arquivo)) {
        $arrM = explode(":::|:::", fgets($arquivo));
        $parte_user = trim($arrM[0]);
        $parte_password = trim($arrM[1]);
        if ($parte_user === $nome && $parte_password === $senha) {
            $user = $arrM;
            $adm = trim($arrM[2]);
            if ($adm <> "") {
               # session_start();
                $_SESSION['logado'] = true;
            }
        }
    }
    fclose($arquivo);
    return $user;
}

function verificaUsuario($nome) {
    $arquivo = fopen(DIR_USER_SQUID, "r");
    $user = "";
    if (!file_exists(DIR_USER_SQUID)) {
        exec('/bin/touch ' . DIR_USER_SQUID);
    }
    while (!feof($arquivo)) {
        $arrM = explode(":", fgets($arquivo));
        $parte_user = trim($arrM[0]);
        if ($parte_user === $nome) {
            $user = $arrM;
        }
    }
    fclose($arquivo);
    return $user;
}

function listaDadosPadrao($caminho) {
    $arquivo = fopen($caminho, "r");
    if (!file_exists($caminho)) {
        exec('/bin/touch ' . $arquivo);
    }
    $dados = array();
    
    while (!feof($arquivo)) {
        $valor = fgets($arquivo);
        if ($valor <> "") {
            $dados[] = $valor;
        }
    }
    fclose($arquivo);
    sort($dados);
    return $dados;
}

function gravar($caminho, $conteudo, $codigo = "") {
    if (!file_exists($caminho)) {
        exec('/bin/touch ' . $caminho);
    }
    if ($codigo == "") {
        $f = fopen($caminho, "a");
        $arquivo_linhas = file($caminho);
        $conta_linhas = count($arquivo_linhas);
        $quebra = ($conta_linhas > 0) ? "\n" : "";
        fwrite($f, $quebra . $conteudo);
        fclose($f);
    } else {
        editar($caminho, $codigo, $conteudo);
    }
}

function gravarUsuarioSquid($usuario, $passwd) {
    $arquivoSquid = DIR_USER_SQUID;
    $up = " '$usuario' " . " '$passwd' ";
    $string = "/usr/bin/htpasswd -b" . " $arquivoSquid '$usuario' '$passwd' ";
    exec("$string");
}

function excluir($caminho, $num) {
    $arquivo = fopen($caminho, 'r+');
    if ($arquivo) {
        $lin = 0;
        $string = array();
        while (true) {
            $linha = fgets($arquivo);
            if ($linha == null || $linha == "") {
                break;
            }
            $l = str_replace("\n", "", str_replace("\r", "", $linha));
            if ($num <> $lin) {
                $string[] = $l;
            }
            $lin++;
        }

        rewind($arquivo);
        ftruncate($arquivo, 0);
        fwrite($arquivo, implode("\n", $string));
        fclose($arquivo);
    }
}

function excluirUsuario($caminho, $nome) {
    $arquivo = fopen($caminho, 'r+');
    if ($arquivo) {
        while (true) {
            $linha = fgets($arquivo);
            if ($linha == null || $linha == "") {
                break;
            }
            $user = explode(":", $linha);
            if (trim($user[0]) <> $nome) {
                $string .= $linha;
            }
        }

        rewind($arquivo);
        ftruncate($arquivo, 0);
        fwrite($arquivo, $string);
        fclose($arquivo);
    }
}

function excluirGerenciaUsuario($nome) {
    $arquivo = fopen("regras/gerencia_grupos.txt", 'r+');
    if ($arquivo) {
        while (true) {
            $linha = fgets($arquivo);
            if ($linha == null || $linha == "") {
                break;
            }
            $user = explode(":", $linha);
            if (trim($user[1]) <> $nome) {
                $string .= $linha;
            }
        }

        rewind($arquivo);
        ftruncate($arquivo, 0);
        fwrite($arquivo, $string);
        fclose($arquivo);
    }
}

function editar($caminho, $num, $nome) {
    $arquivo = fopen($caminho, 'r+');
    $arquivo_linhas = file($caminho);
    $conta_linhas = count($arquivo_linhas);
    if ($arquivo) {
        $lin = 0;
        while (true) {
            $linha = fgets($arquivo);
            if ($linha == null) {
                break;
            }
            if ($num == $lin) {
                if ($conta_linhas - 1 <> $lin) {
                    $string .= $nome . "\n";
                } else {
                    $string .= $nome;
                }
            } else {
                $string .= $linha;
            }
            $lin++;
        }
        rewind($arquivo);
        ftruncate($arquivo, 0);
        fwrite($arquivo, $string);
        fclose($arquivo);
    }
}

function redefinirSenha($nome, $senha) {
    $arquivoUser = fopen(DIR_USER_SISTEMA, "r+");
    if (!file_exists(DIR_USER_SISTEMA)) {
        exec('/bin/touch ' . DIR_USER_SISTEMA);
    }
    while (!feof($arquivoUser)) {
        $linha = fgets($arquivoUser);
        $arrM = explode(":::|:::", $linha);
        $parte_user = trim($arrM[0]);
        if ($parte_user === $nome) {
            if ($arrM[3] <> " ") {
                excluirUsuario($nome);
                gravarUsuarioSquid($nome, $senha);
            }
            if ($arrM[4] <> " ") {
                excluirUsuario(DIR_USER_SAMBA, $nome);
                gravar(DIR_USER_SAMBA, $nome);
            }
            $string .= str_replace(trim($arrM[1]), md5($senha), $linha);
        } else {
            $string .= $linha;
        }
    }
    rewind($arquivoUser);
    ftruncate($arquivoUser, 0);
    fwrite($arquivoUser, $string);
    fclose($arquivoUser);

    session_start("sessaoSenha");
    session_destroy();
}

function buscarIp($ip) {
    $arqLiberados = fopen(DIR_IP_LIBERADO, "r+");
    $arqBloqueados = fopen(DIR_IP_BLOQUEADO, "r+");
    if (!file_exists(DIR_IP_LIBERADO)) {
        exec('/bin/touch ' . DIR_IP_LIBERADO);
    }
    if (!file_exists(DIR_IP_BLOQUEADO)) {
        exec('/bin/touch ' . DIR_IP_BLOQUEADO);
    }
    $ip_resp = "";
    while (!feof($arqLiberados)) {
        $linha = fgets($arqLiberados);
        if ($linha === $ip) {
            $ip_resp = $ip;
        }
    }
    while (!feof($arqBloqueados)) {
        $l = fgets($arqBloqueados);
        if ($l === $ip) {
            $ip_resp = $ip;
        }
    }
    fclose($arqLiberados);
    fclose($arqBloqueados);
    return $ip_resp;
}

function verificaGravar($nome, $senha, $conteudo, $codigo = "", $caminhos) {
    if ($codigo == "") {
        $arrM = explode(":", $caminhos);
        $samba = trim($arrM[1]);
        $squid = trim($arrM[0]);
        $radio = trim($arrM[2]);
        if ($samba == "samba") {
            gravarUsuarios(DIR_USER_SAMBA, $nome);
            gravarUsuarioSamba($nome, $senha);
        }
        if ($radio == "liberados") {
            gravarUsuarios(DIR_USER_LIBERADOS, $nome);
        }
        if ($radio == "default") {
            gravarUsuarios(DIR_USER_DEFAULT, $nome);
        }
        if ($squid == "squid") {
            gravarUsuarioSquid($nome, $senha);
        }

        gravarUsuarios(DIR_USER_SISTEMA, $conteudo);
    } else {
        editarUsuarios($nome, $senha, $conteudo, $caminhos, $codigo);
    }
}

function verificaUsuarioSistema($nome) {
    $arquivo = fopen(DIR_USER_SISTEMA, "r");
    if (!file_exists(DIR_USER_SISTEMA)) {
        exec('/bin/touch ' . DIR_USER_SISTEMA);
    }
    $user = "";
    while (!feof($arquivo)) {
        $arrM = explode(":::|:::", fgets($arquivo));
        $parte_user = trim($arrM[0]);
        if ($parte_user === $nome) {
            $user = $arrM;
        }
    }
    fclose($arquivo);
    return $user;
}

function verificaUsuarioTodos($nome, $caminho) {
    if (!file_exists($caminho)) {
        exec('/bin/touch ' . $caminho);
    }
    $arquivo = fopen($caminho, "r");
    $user = "";
    while (!feof($arquivo)) {
        $arrM = explode(" ", fgets($arquivo));
        $parte_user = trim($arrM[0]);
        if ($parte_user === $nome) {
            $user = $arrM[0];
        }
    }
    fclose($arquivo);
    return $user;
}

function procuraExclui($nome, $caminho) {
    $f = fopen($caminho, "r");
    if (!file_exists($caminho)) {
        exec('/bin/touch ' . $caminho);
    }
    $linha = 0;
    $lin = 0;
    while (!feof($f)) {
        $linhaArquivo = fgets($f);

        if ($linhaArquivo === $nome) {
            $lin = $linha;
        }
        $linha++;
    }
    fclose($f);
    return $lin;
}

function gravarUsuarios($caminho, $conteudo) {
    if (!file_exists($caminho)) {
        exec('/bin/touch ' . $caminho);
    }
    $f = fopen($caminho, "a");
    $arquivo_linhas = file($caminho);
    $conta_linhas = count($arquivo_linhas);
    $quebra = ($conta_linhas > 0) ? "\n" : "";
    fwrite($f, $quebra . $conteudo);
    fclose($f);
}

function editarUsuarios($nome, $senha, $conteudo, $caminhos, $codigo) {
    $userSquid = verificaUsuario($nome);
    $userLiberados = verificaUsuarioTodos($nome, DIR_USER_LIBERADOS);
    $userDefault = verificaUsuarioTodos($nome, DIR_USER_DEFAULT);
    $userSamba = verificaUsuarioTodos($nome, DIR_USER_SAMBA);
    excluir(DIR_USER_SISTEMA, $codigo);
    $arrM = explode(":", $caminhos);
    $samba = trim($arrM[1]);
    $squid = trim($arrM[0]);
    $radio = trim($arrM[2]);
    if ($userSamba <> "" && $samba == "samba") {
        exec("(echo '" . $senha . "'; " . "echo '" . $senha . "') " . "| " . " sudo smbpasswd -s " . $nome);
    } else if ($samba == "samba") {
        gravarUsuarios(DIR_USER_SAMBA, $nome);
        gravarUsuarioSamba($nome, $senha);
    } else if ($userSamba <> "") {
        excluirUsuario(DIR_USER_SAMBA, $nome);
        excluirUsuarioSamba($nome);
    }

    if ($userSquid <> "") {
        excluirUsuario(DIR_USER_SQUID, $nome);
        aplicarSquid();
    }
    if ($userLiberados <> "") {
        $numeroLinha = procuraExclui($userLiberados, DIR_USER_LIBERADOS);
        excluir(DIR_USER_LIBERADOS, ($numeroLinha));
    }
    if ($userDefault <> "") {
        $numeroLinha = procuraExclui($userDefault, DIR_USER_DEFAULT);
        excluir(DIR_USER_DEFAULT, ($numeroLinha));
    }
    if ($radio == "liberados") {
        gravarUsuarios(DIR_USER_LIBERADOS, $nome);
    }
    if ($radio == "default") {
        gravarUsuarios(DIR_USER_DEFAULT, $nome);
    }
    if ($squid == "squid") {
        gravarUsuarioSquid($nome, $senha);
        aplicarSquid();
    }
    gravarUsuarios(DIR_USER_SISTEMA, $conteudo);
}

function aplicarSquid() {
    if (file_exists("/usr/sbin/squid")) {
        system('sudo /usr/sbin/squid -k reconfigure');
    } else if (file_exists("/usr/sbin/squid3")) {
        system('sudo /usr/sbin/squid3 -k reconfigure');
    }

    if (file_exists('/etc/init.d/dansguardian')) {
        system('sudo /etc/init.d/dansguardian restart');
    }
}

function verificaExcluir($nome, $numero) {
    $userSistema = verificaUsuarioSistema($nome, DIR_USER_SISTEMA);
    $userSquid = verificaUsuario($nome);
    $userLiberados = verificaUsuarioTodos($nome, DIR_USER_LIBERADOS);
    $userDefault = verificaUsuarioTodos($nome, DIR_USER_DEFAULT);
    $userSamba = verificaUsuarioTodos($nome, DIR_USER_SAMBA);

    if ($userSamba <> "") {
        $numeroLinha = procuraExclui($userSamba, DIR_USER_SAMBA);
        excluir(DIR_USER_SAMBA, ($numeroLinha));
        excluirUsuarioSamba($userSamba);
        excluirGerenciaUsuario($nome);
    }
    if ($userSquid <> "") {
        excluirUsuario(DIR_USER_SQUID, $nome);
    }
    if ($userLiberados <> "") {
        $numeroLinha = procuraExclui($nome, DIR_USER_LIBERADOS);
        excluir(DIR_USER_LIBERADOS, ($numeroLinha));
    }
    if ($userDefault <> "") {
        $numeroLinha = procuraExclui($nome, DIR_USER_DEFAULT);
        excluir(DIR_USER_DEFAULT, ($numeroLinha));
    }
    if ($userSistema <> "") {
        excluir(DIR_USER_SISTEMA, $numero);
    }
}

function gravarUsuarioSamba($usuario, $senha) {
    $string_cmd_um = "sudo useradd -U -d " . DIR_USUARIO . "/" . $usuario . " -s /bin/false " . $usuario;
    $string_cmd_dois = "sudo mkdir -p " . DIR_USUARIO . "/" . $usuario;
    $string_cmd_tres = "sudo chown " . $usuario . " " . DIR_USUARIO . "/" . $usuario;
    $string_cmd_quatro = "sudo chmod 770 " . DIR_USUARIO . "/" . $usuario;
    $string_cmd_cinco = "(echo '" . $senha . "';  " . "echo '" . $senha . "') " . "| " . " sudo smbpasswd -s -a " . $usuario;
    exec("$string_cmd_um");
    exec("$string_cmd_dois");
    exec("$string_cmd_tres");
    exec("$string_cmd_quatro");
    exec("$string_cmd_cinco");
}

function excluirUsuarioSamba($usuario) {
    $string_cmd_um = "sudo mv " . DIR_USUARIO . "/" . $usuario . " " . DIR_SISTEMA . "/" . backup;
    $string_cmd_dois = "sudo smbpasswd -x " . $usuario;
    $string_cmd_tres = "sudo userdel " . $usuario;
    $string_cmd_quatro = "sudo groupdel " . $usuario;
    exec("$string_cmd_um");
    exec("$string_cmd_dois");
    exec("$string_cmd_tres");
    exec("$string_cmd_quatro");
}

function adicionaGrupo($grupo, $arquivo, $codigo = "") {
    $erro = "";
    $verifica_sistema = shell_exec("cat /etc/group | cut -d : -f 1 | grep -i ^" . $grupo . "$");
    $verifica = shell_exec("ls " . DIR_DADOS . " |grep -i $grupo");
    if ($verifica_sistema <> "" || $verifica <> "") {
        $erro = "Grupo não pode ser criado";
    } else {
        gravar($arquivo, $grupo, $codigo);
        $string_cmd_um = "sudo mkdir " . DIR_DADOS . "/$grupo";
        $string_cmd_dois = "sudo groupadd $grupo";
        $string_cmd_tres = "sudo chown .$grupo " . DIR_DADOS . "/$grupo";
        $string_cmd_quatro = "sudo chmod 770 " . DIR_DADOS . "/$grupo";
        exec("$string_cmd_um");
        exec("$string_cmd_dois");
        exec("$string_cmd_tres");
        exec("$string_cmd_quatro");
    }
    return $erro;
}

function alterar_grupo($user, $grupos) {
    $comandoUserModeUsuario = "sudo usermod -G $user $user";
    exec($comandoUserModeUsuario);
    $GRUPOS_USER = "$user:";
    foreach ($grupos as $g) {
        if ($g <> "") {
            exec("sudo usermod -a -G $g $user");
            $GRUPOS_USER .= "$g:";
        }
    }
    exec("sed -i /$user:/d " . DIR_SISTEMA . "/regras/gerencia_grupos.txt");
    exec("echo $GRUPOS_USER >> " . DIR_SISTEMA . "/regras/gerencia_grupos.txt");
}

function excluir_grupo($grupo) {
    $string_cmd_um = "sudo mv " . DIR_DADOS . "/$grupo " . DIR_DADOS . "/backup";
    $string_cmd_dois = "sudo sed -i /:$grupo:/d " . DIR_SISTEMA . "/.grupos";
    $string_cmd_tres = "sudo groupdel $grupo";
    exec("$string_cmd_um");
    exec("$string_cmd_dois");
    exec("$string_cmd_tres");
}

?>
