<?php
session_name('adm'.SESSAOADM);
session_cache_limiter('public, must-revalidate');
session_cache_expire( TEMPOSESSAO );
session_start();
function logadoAdm(){
    if(isset($_SESSION['usuario-adm-'.SESSAOADM]) and !empty($_SESSION['usuario-adm-'.SESSAOADM])){
        return true;
    }else{
        return false;
    }
}
