<?php
function mascaraTelefone($telefone){
    $telefone = soNumero($telefone);
    if($telefone == ''){
        return '';
    }
    if(strlen($telefone) <= 9){
        $ddd = "(51)";
        $numero = substr($telefone, 0, 5) . "-" . substr($telefone, 5, 4);
    } else {
        $ddd = "(". substr($telefone, 0, 2) . ")";
        $numero = substr($telefone, 2, 4) . "-" . substr($telefone, 6, 5);
    }
    $telefone = $ddd . $numero;
    return $telefone;
}

function gerasenha(){
    $silabas = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    $a = $silabas[rand(0,count($silabas)-1)];
    return($a);
}

function pegaGeolocalizacao($endereco){
    $endereco = removeacentos($endereco);
    $prepAddr = str_replace(' ','+',$endereco);

    $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');

    $output= json_decode($geocode);

    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;

    return array('latitude' => $latitude,'longitude' => $longitude);
}

function geraGrafico($largura, $altura, $valores, $referencias, $tipo = "p3"){
    $valores = implode(',', $valores);
    $referencias = implode('|', $referencias);

    return "http://chart.apis.google.com/chart?chs=". $largura ."x". $altura . "&amp;chd=t:" . $valores . "&amp;cht=p3&amp;chl=" . $referencias;
}

function exibeAlerta($recado, $redirecionamento=null){
    $alerta = "<script type='text/javascript'>";
    if($recado!=''){
        $alerta .= "alert(\"".$recado."\");";
    }
    if( $redirecionamento == 'voltar'){
        $alerta .= "history.back();";
    } else if( $redirecionamento != '' and $redirecionamento != './' ){
        $alerta .= "document.location='" . $redirecionamento . "'; ";
    }else{
        $alerta .= "document.location='./?acesso=ok'; ";
    }
    $alerta .= "</script>";
    return $alerta;
}

function encriptaSenha($senha){
    $limite = 3;
    for ($i=0; $i < $limite; $i++) {
        $senha = md5($senha);
    }
    return $senha;
}

function exibeId($id, $numCaracteres = 5){
    return str_pad($id,$numCaracteres,'0',STR_PAD_LEFT);
}

function dataTexto($dia){
//TRATA SE FOR DATA EM FORMATO DE BD
    $aux = strpos($dia, '/');
    if ($aux === false) {
        $dia = basetodata($dia);
    }
//QUEBRA A DATA EM DIA MES ANO
    $diaa=substr($dia,0,2);
    $mes=substr($dia,3,2);
    $ano=substr($dia,6,4);
    return $diaa . " de " . qualMes($mes) . " de " . $ano;
}

function mascarCep($cep) {
    $cep = soNumero($cep);
    if(strlen($cep) == 8){
        $cep1= substr($cep, 0, 5);
        $cep2= substr($cep, 5, 3);
        $cep = ($cep1 . "-" . $cep2);
    }
    return $cep;
}

function mascaraValorGerencianet( $valor ) {
    $valor = soNumero($valor);
    $valor1 = substr($valor, 0, -2);
    $valor2 = substr($valor,-2);
    $valor = ($valor1 . "." . $valor2);
    return $valor;
}

function mascaraCpf($cpf) {
    $cpf = soNumero($cpf);
    $cpf = str_pad($cpf, 11, "0", STR_PAD_LEFT);
    $cpf1= substr($cpf, 0, 3);
    $cpf2= substr($cpf, 3, 3);
    $cpf3= substr($cpf, 6, 3);
    $cpf4= substr($cpf, 9, 2);
    return ($cpf1 . "." . $cpf2 . "." . $cpf3 . "-" . $cpf4);
}

function mascaraCnpj($cnpj) {
    $cnpj = soNumero($cnpj);
    $cnpj = str_pad($cnpj, 14, "0", STR_PAD_LEFT);
    $cnpj1= substr($cnpj, 0, 2);
    $cnpj2= substr($cnpj, 2, 3);
    $cnpj3= substr($cnpj, 5, 3);
    $cnpj4= substr($cnpj, 8, 4);
    $cnpj5= substr($cnpj, 12, 2);
    return ($cnpj1 . "." . $cnpj2 . "." . $cnpj3 . "/" . $cnpj4 . "-" . $cnpj5);
}

function mascaraDocumento($documento){
    $documento = soNumero($documento);
    if(strlen($documento) <= 11){
        $documento = mascaraCpf($documento);
    } else if(strlen($documento) <= 14){
        $documento =  mascaraCnpj($documento);
    }
    return $documento;
}

function validaDocumento($documento) {
    if((checa_cnpj($documento) == 0) or (checa_cpf($documento) == 0)){
        return true;
    } else {
        return false;
    }
}

function checa_cpf ($cpf){
    $cpf = str_pad(soNumero($cpf), 11, "0", STR_PAD_LEFT);
    if((!is_numeric($cpf)) or (strlen($cpf) <> 11))	{
        return 2;
    } else {
        if ( ($cpf == '11111111111') || ($cpf == '22222222222') ||
            ($cpf == '33333333333') || ($cpf == '44444444444') ||
            ($cpf == '55555555555') || ($cpf == '66666666666') ||
            ($cpf == '77777777777') || ($cpf == '88888888888') ||
            ($cpf == '99999999999') || ($cpf == '00000000000') )
        {
            return 1;
        }
        else
        {
            $cpf_dv = substr($cpf, 9,2);
        }
    }
    for($i=0; $i<=8; $i++)
    {
        $digito[$i] = substr($cpf, $i,1);
    }
    $posicao = 10;
    $soma = 0;
    for($i=0; $i<=8; $i++)
    {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }
    $digito[9] = $soma % 11;
    if($digito[9] < 2)
    {
        $digito[9] = 0;
    }
    else
    {
        $digito[9] = 11 - $digito[9];
    }
    $posicao = 11;
    $soma = 0;
    for ($i=0; $i<=9; $i++)
    {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }
    $digito[10] = $soma % 11;
    if ($digito[10] < 2)
    {
        $digito[10] = 0;
    }
    else
    {
        $digito[10] = 11 - $digito[10];
    }
    $dv = $digito[9] * 10 + $digito[10];
    if ($dv != $cpf_dv)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

/*
    Função checa_cnpj
    Essa função retorna:
    0 em caso de sucesso
    1 em caso de cnpj errado
    2 em caso de cnpj não numérico ou se o tamanho não estiver certo.
*/
function checa_cnpj($cnpj){
    $cnpj = str_pad(soNumero($cnpj), 14, "0", STR_PAD_LEFT);
    if ((!is_numeric($cnpj)) or (strlen($cnpj) <> 14)){
        return 2;
    } else {
        $i = 0;
        while ($i < 14)
        {
            $cnpj_d[$i] = substr($cnpj,$i,1);
            $i++;
        }
        $dv_ori = $cnpj[12] . $cnpj[13];
        $soma1 = $soma2 = 0;
        $soma1 = $soma1 + ($cnpj[0] * 5);
        $soma1 = $soma1 + ($cnpj[1] * 4);
        $soma1 = $soma1 + ($cnpj[2] * 3);
        $soma1 = $soma1 + ($cnpj[3] * 2);
        $soma1 = $soma1 + ($cnpj[4] * 9);
        $soma1 = $soma1 + ($cnpj[5] * 8);
        $soma1 = $soma1 + ($cnpj[6] * 7);
        $soma1 = $soma1 + ($cnpj[7] * 6);
        $soma1 = $soma1 + ($cnpj[8] * 5);
        $soma1 = $soma1 + ($cnpj[9] * 4);
        $soma1 = $soma1 + ($cnpj[10] * 3);
        $soma1 = $soma1 + ($cnpj[11] * 2);
        $rest1 = $soma1 % 11;
        if ($rest1 < 2)	{
            $dv1 = 0;
        } else {
            $dv1 = 11 - $rest1;
        }
        $soma2 = $soma2 + ($cnpj[0] * 6);
        $soma2 = $soma2 + ($cnpj[1] * 5);
        $soma2 = $soma2 + ($cnpj[2] * 4);
        $soma2 = $soma2 + ($cnpj[3] * 3);
        $soma2 = $soma2 + ($cnpj[4] * 2);
        $soma2 = $soma2 + ($cnpj[5] * 9);
        $soma2 = $soma2 + ($cnpj[6] * 8);
        $soma2 = $soma2 + ($cnpj[7] * 7);
        $soma2 = $soma2 + ($cnpj[8] * 6);
        $soma2 = $soma2 + ($cnpj[9] * 5);
        $soma2 = $soma2 + ($cnpj[10] * 4);
        $soma2 = $soma2 + ($cnpj[11] * 3);
        $soma2 = $soma2 + ($dv1 * 2);
        $rest2 = $soma2 % 11;
        if ($rest2 < 2)
        {
            $dv2 = 0;
        }
        else
        {
            $dv2 = 11 - $rest2;
        }
        $dv_calc = $dv1 . $dv2;
        if ($dv_ori == $dv_calc)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
}

function pegaTodasVarGet() {
    $url = explode("?", $_SERVER['REQUEST_URI']);
    $url = $url[1];
    return $url;
}

function printR($dado){
    echo "<pre>";
    var_dump($dado);
    echo "</pre>";
}

function soNumero($string) {
    return preg_replace("/[^0-9]/", "", $string);
}

function nametofile($texto){
    $remover = array(" ", "´", "\"", "/", "\\");
    $inserir = array("_", "_", "_", "_", "_");
    $texto = str_replace($remover, $inserir, $texto);
    $texto = corrigeCodificacao($texto);
    $texto = tiracento($texto);
    $texto = removeacentos($texto);
    return strtolower($texto);
}

function tiracento($texto){
    $trocarIsso = 	array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ');
    $porIsso = 		array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','0','U','U','U','Y');
    $titletext = str_replace($trocarIsso, $porIsso, $texto);
    return $titletext;
}

function corrigeCodificacao($texto){
    $trocarIsso = 		array('Ã ','Ã¡','Ã¢','Ã£','Ã¤','Ã¥','Ã§','Ã¨','Ã©','Ãª','Ã«','Ã¬','Ã­','Ã®','Ã¯','Ã±','Ã²','Ã³','Ã´','Ãµ','Ã¶','Ã¹','Ã¼','Ãº','Ã¿','Ã?','Ã','Ã?','Ã?','Ã?','Ã?','Ã?','Ã?','Ã?','Ã?','Ã?','Ã?','Ã','Ã?','Ã','Ã?','Ã?','Ã?','Ã?','Ã?','Ã?','O','Ã?','Ã?','Ã?','Å¸');
    $porIsso = 	array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ');
    $titletext = str_replace($trocarIsso, $porIsso, $texto);
    return $titletext;
}

function removeacentos($texto){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ","a A e E i I o O u U n N c C"), $texto);
}
//DATAS
function baseToData($data){
    return implode('/',array_reverse(explode('-',$data)));
}
function dataToBase($data){
    return implode('-',array_reverse(explode('/',$data)));
}

function diaSemana( $dia ){
    $semana = array(
        'Sun' => 'Domingo',
        'Mon' => 'Segunda-Feira',
        'Tue' => 'Terca-Feira',
        'Wed' => 'Quarta-Feira',
        'Thu' => 'Quinta-Feira',
        'Fri' => 'Sexta-Feira',
        'Sat' => 'Sábado'
    );
    return $semana[$dia];
}

function timeStamptoData($data, $tipo){
    if($tipo == 'datahora'){
        $data = date('d/m/Y H:i',strtotime($data));
    } else if($tipo == 'horadata'){
        $data = date('H:i d/m/Y',strtotime($data));
    } else if($tipo == 'data'){
        $data = date('d/m/Y',strtotime($data));
    } else if($tipo == 'hora'){
        $data = date('H:i',strtotime($data));
    } else {
        $data = '';
    }
    return $data;
}

function baseToDecimal($valor){
    return str_replace(".", ",",$valor);
}

function decimalToBase($valor){
    $pos = strpos($valor, ',');
    if ($pos === false) {
    } else {
        $tirar = array(".", ",");
        $colocar = array("", ".");
        $valor = str_replace ($tirar, $colocar, $valor);
    }
    return $valor;
}

function uploadFoto($imagem, $nomeImg, $tipo, $caminho, $tamanhoMax){
    $caminho = $caminho.$nomeImg.'.jpg';
    $ok = 0;
    //envio e redimensionamento da imagem
    list($width, $height) = getimagesize($imagem);
    if($width > $tamanhoMax){
        $new_width = $tamanhoMax;
    } else {
        $new_width = $width;
    }
    $new_height = ($height * $new_width)/$width;
    $image_p = imagecreatetruecolor($new_width, $new_height);
    imagefill($image_p, 0, 0, imagecolorallocate($image_p, 255, 255, 255));
    if($tipo == 1){
        $image = imagecreatefromjpeg($imagem);
    }elseif($tipo == 2){
        $image = imagecreatefromgif($imagem);
    }elseif($tipo == 3){
        $image = imagecreatefrompng($imagem);
    }
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    if(imagejpeg($image_p, $caminho, 100)){
        $ok++;
    }
    imagedestroy($image_p);
    if($ok==1){
        return true;
    }else{
        return false;
    }
}

function criaMiniatura($caminho, $caminhoMin, $tamanhoMax){
    $ok = 0;
    if(!empty($caminhoMin)){
        $filename = $caminho;
        list($width, $height) = getimagesize($filename);
        if($width > $tamanhoMax){
            $new_width = $tamanhoMax;
        } else {
            $new_width = $width;
        }
        $new_height = ($height * $new_width)/$width;
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        if(imagejpeg($image_p, $caminhoMin, 100)){
            $ok++;
        }
        imagedestroy($image_p);
    }else{
        $ok++;
    }
    if($ok==1){
        return true;
    }else{
        return false;
    }
}

//FUNÇÕES URL
//PEGA URL AMIGÁVEL
function getUrlAmigavel($origem = URLADM) {
    $actual_link = PROTOCOLO . "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_link = str_replace($origem."/","",$actual_link);
    $actual_link = str_replace(strrchr($actual_link, "?"), "", $actual_link);
    $gets = ["","","",""];
    if($actual_link != ''){
        $links = explode("/", $actual_link);
        for($i = 0; $i < count($links); $i++) {
            $link = $links[$i];
            if(!empty($link)){
                $gets[$i] = $link;
            }
        }
    }
    return $gets;
}
$gets = getUrlAmigavel();
//EXIBE COM BASE NA URL AMIGÁVEL
function mostrapaginas() {
    $gets = getUrlAmigavel();
    if(!empty($gets[0]) and $gets[0] != ''){
        if(file_exists("telas/".$gets[0]) and $gets[0] != ''){
            if(!empty($gets[2])){
                if(file_exists("telas/".$gets[0]."/".$gets[1]."/".$gets[2].".php")){
                    require_once ("telas/".$gets[0]."/".$gets[1]."/".$gets[2].".php");
                }
            } else {
                require_once ("telas/".$gets[0]."/".$gets[1]."/visualizar.php");
            }
        }
    } else {
        require_once ("telas/home.php");
    }
}
/* USER-AGENTS
================================================== */
function check_user_agent ( $type = NULL ) {
    $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
    if ( $type == 'bot' ) {
        // matches popular bots
        if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
            return true;
            // watchmouse|pingdom\.com are "uptime services"
        }
    } else if ( $type == 'browser' ) {
        // matches core browser types
        if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
            return true;
        }
    } else if ( $type == 'mobile' ) {
        // matches popular mobile devices that have small screens and/or touch inputs
        // mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
        // detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
        if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
            // these are the most common
            return true;
        } else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
            // these are less common, and might not be worth checking
            return true;
        }
    }
    return false;
}

function qualMes($mes){
    switch ($mes) {
        case 1: $mes = "Janeiro"; break;
        case 2: $mes = "Fevereiro"; break;
        case 3: $mes = "Março"; break;
        case 4: $mes = "Abril"; break;
        case 5: $mes = "Maio"; break;
        case 6: $mes = "Junho"; break;
        case 7: $mes = "Julho"; break;
        case 8: $mes = "Agosto"; break;
        case 9: $mes = "Setembro"; break;
        case 10: $mes = "Outubro"; break;
        case 11: $mes = "Novembro"; break;
        case 12: $mes = "Dezembro"; break;
    }
    return($mes);
}

function diasVencimento( $dataVencimento ){
    $data1 = new DateTime( date('Y-m-d') );
    $data2 = new DateTime( dataToBase($dataVencimento) );
    $intervalo = $data1->diff( $data2 );
    $dias = $virgula = NULL;
    if($intervalo->y > 0){
        $dias = $intervalo->y .' ano';
        if($intervalo->y > 1){
            $dias .= 's';
        }
        $virgula = ', ';
    }
    if($intervalo->m > 0){
        $dias .= $virgula . $intervalo->m .' mes';
        if($intervalo->m > 1){
            $dias .= 'es';
        }
        $virgula = ' e ';
    }
    if($intervalo->d > 0){
        $dias .= $virgula . $intervalo->d .' dia';
        if($intervalo->d > 1){
            $dias .= 's';
        }

    }
    return $dias;
}

function validaEmail($email){
    //verifica se e-mail esta no formato correto de escrita
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //$mensagem='<br />E-mail Inv&aacute;lido! ' . $email; echo $mensagem;
        return false;
    } else {
        //Valida o dominio
        $dominio=explode('@',$email);
        if(!checkdnsrr($dominio[1],'A')){
            //$mensagem='<br />Domínio do e-mail Inv&aacute;lido! ' . $email; echo $mensagem;
            return false;
        } else if(!checkdnsrr($dominio[1],'MX')){
            //$mensagem='<br />Domínio do e-mail Inv&aacute;lido! ' . $email; echo $mensagem;
            return false;
        } else {
            //echo "<br />E-mail correto: " . $email;
            return true;
        } // Retorno true para indicar que o e-mail é valido
    }
}

function positivoNegativo( $valor ){
    echo $valor > 0 ? NULL : ' style="color: red;"';
}

function preco($valor, $decimais = 2) {
    $valor = decimalToBase($valor);
    $valor = number_format( (float) $valor, $decimais, ',','.' );
    return $valor;
}

function nomeProprio($nome, $minimo = 3){
    $nome = strtolower($nome);
    $nome = explode(' ', $nome);
    for ($i = 0; $i < count($nome); $i++) {
        if(strlen($nome[$i]) < $minimo){
            continue;
        }
        $nome[$i] =  ucfirst($nome[$i]);
    }
    $nome = implode( ' ', $nome);
    return $nome;
}

function traduzGerencianet( $status ){
    switch ($status) {
        case 'paid':
            $status = "Pago";
            break;
        case 'unpaid':
            $status = "Inadimplente";
            break;
        case 'waiting':
            $status = "Aguardando";
            break;
    }
    return $status;
}

function ola(){
    $hora = date('H');
    if ($hora < 12) {
        $ola = "Bom dia";
    } else if ($hora < 18) {
        $ola = "Boa tarde";
    } else {
        $ola = "Boa noite";
    }
    return $ola;
}
