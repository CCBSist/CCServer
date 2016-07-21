Reiniciando serviço ... <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
<?php
if (file_exists("/etc/init.d/samba")) {
    system('sudo /etc/init.d/samba restart' );
} else if (file_exists("/etc/init.d/smb")) {
    system('sudo /etc/init.d/smb restart');
} else if (file_exists("/etc/init.d/nmb")) {
    system('sudo /etc/init.d/nmb restart');
}
?>
