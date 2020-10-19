<?php
date_default_timezone_set('America/Sao_Paulo');
//CONSTANTES
if($_SERVER['SERVER_NAME'] != 'localhost'){
    define('PROTOCOLO', 'https://');
} else {
    define('PROTOCOLO', 'http://');
}
define('URLADM', PROTOCOLO . $_SERVER['HTTP_HOST']);
define('URL', PROTOCOLO . $_SERVER['HTTP_HOST']);
const HOST = 'localhost';
const EMPRESA = 'JOINVILLE';
const SESSAOADM = EMPRESA;
const USUARIOBD = 'root';
const SENHABD = 'sucesso2020';
const NOMEBANCO = 'joinville';
const USERBANCO = 'postgres';
const TEMPOSESSAO = 600; //Minutos
