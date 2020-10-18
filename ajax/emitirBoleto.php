<?php
include_once('../config/includes.php');
require __DIR__ . '/../api/vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$options = [
    'client_id' => GERENCIANETID,
    'client_secret' => GERENCIANETSECRET,
    'sandbox' => GERENCIANETSANDBOX
];

if (isset($_POST)) {

    $item_1 = [
        'name' => $_POST["descricao"],
        'amount' => (int) $_POST["quantidade"],
        'value' => (int) $_POST["valor"]
    ];

    $items = [
        $item_1
    ];

    $body = ['items' => $items];

    try {
        $api = new Gerencianet($options);
        $charge = $api->createCharge([], $body);
        if ($charge["code"] == 200) {

            if(!empty($_POST["telefone"])){
                $telefone = $_POST["telefone"];
            } else {
                $telefone = '51992848424';
            }

            $nomeCliente = explode(' ', $_POST["nome_cliente"]);
            if(count($nomeCliente > 1)){
                $nomeCliente = $_POST["nome_cliente"];
            } else {
                $nomeCliente = $_POST["nome_empresa"];
            }

            $params = ['id' => $charge["data"]["charge_id"]];
            $customer = [
                'name' => $nomeCliente,
                'phone_number' => $telefone,
            ];

            $documento = $_POST["cpf"];
            if(strlen($_POST["cpf"]) > 11){
                $customer['juridical_person'] = [
                    'corporate_name' => $_POST["nome_empresa"],
                    'cnpj' => $documento,
                ];

            } else {
                $customer['cpf'] = $documento;
            }
            //Formatando a data, convertendo do estino brasileiro para americano.
            //$data_brasil = DateTime::createFromFormat('d/m/Y', $_POST["vencimento"]);
            $bankingBillet = [
                //'expire_at' => $data_brasil->format('Y-m-d'),
                'expire_at' => $_POST["vencimento"],
                'customer' => $customer,
                'message' => $_POST['message'],
            ];
            $payment = ['banking_billet' => $bankingBillet];
            $body = ['payment' => $payment];

            $api = new Gerencianet($options);
            $pay_charge = $api->payCharge($params, $body);
            $boleto = $pay_charge['data']['pdf']['charge'];
            $original = $boleto;
            $nomeBoleto = soNumero($_POST["descricao"]);
            $destino = "../../uploads/boletos/$nomeBoleto.pdf";
            copy($original, $destino);
            $usuario = unserialize($_SESSION['usuario-adm-'.SESSAOADM]);
            $fatura = new Fatura;
            $fatura->setId( soNumero($_POST["descricao"]) );
            $fatura->setIdUsuario( $usuario->getIdUsuario() );
            $fatura->setIdBoleto($pay_charge['data']['charge_id']);
            $fatura->alteraIdBoleto();
            echo json_encode($pay_charge);
        } else {

        }
    } catch (GerencianetException $e) {
        $retorno = [
            'code' => $e->code,
            'error' => $e->error,
            'errorDescription' => $e->errorDescription,
        ];
        echo json_encode($retorno);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}
