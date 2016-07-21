Reiniciando serviço ... <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
<?php
if (file_exists('/etc/init.d/squid')) {
    system('sudo /etc/init.d/squid restart');
} else if (file_exists('/etc/init.d/squid3')) {
    system('sudo /etc/init.d/squid3 restart');
}
if (file_exists('/etc/init.d/dansguardian')){
    system('sudo /etc/init.d/dansguardian restart');
}
?>