<?php
date_default_timezone_set('America/Sao_Paulo');
//CONSTANTES
if($_SERVER['SERVER_NAME'] != 'localhost'){
    define('PROTOCOLO', 'https://');
} else {
    define('PROTOCOLO', 'http://');
}
define('URL', PROTOCOLO . $_SERVER['HTTP_HOST']);
define('URLADM', URL . '/adm');
const HOST = 'localhost';
const SESSAOADM = 'JOINVILLE';
define('NOMEBD', 'abc');
define('USUARIOBD', 'xyz');
define('SENHABD', 'password');
define('NOMEBANCO', substr(HOMEDIR, 0, 8) . '_' . NOMEBD);
define('USERBANCO', substr(HOMEDIR, 0, 8) . '_' . USUARIOBD);

define('EMPRESA',"JOINVILLE");
const TEMPOSESSAO = 600; //Minutos
const CAMINHOABSOLUTO = '/home/' . HOMEDIR . '/public_html/';
