<?php
include_once("config/includes.php");
if(logadoAdm()){
    $usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
    include("estrutura.php");
}else{
    include("telas/form-acesso.php");
}
?>
<script type="text/javascript">
    if (document.location.protocol != "https:" && !(location.hostname === "localhost")) {
        document.location = document.URL.replace(/^http:/i, "https:");
    }
</script>
