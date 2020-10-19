<?php
class BdSQL{
    private $tipoBanco	= 'pgsql';
    private $host		= HOST;
    private $porta		= '5432';
    private $nomeBanco	= NOMEBANCO;
    private $userBanco	= USERBANCO;
    private $passBanco	= SENHABD;

    public function __construct(){}

    public function conecta(){
        try {
            $bd = new PDO( $this->tipoBanco.':host='.$this->host.';port='.$this->porta.';dbname='.$this->nomeBanco, $this->userBanco, $this->passBanco);
            return $bd;
        }catch(PDOException $e){
            print_r($e->getMessage());
            echo "ERRO ao conectar ao banco<br>".$e->getMessage(); die();
        }
    }

    public function consulta( $query ){
        try {
            $banco = $this->conecta();

            $resultado = $banco->prepare($query);
            if(!$resultado->execute()){
                $erro = $resultado->errorInfo();
                if($erro[2]){
                    printR($erro[2]);
                    throw new Exception("Erro ao efetuar consulta" . $erro[2]);
                }
            }
            $linhas = $resultado->fetchAll();
            return $linhas;
        }catch(Exception $e){
            exibeAlerta($erro[2], 'voltar');
            return $e->getMessage();
            die();
        }
        $banco = null;
    }

    public function insereRetornaId( $query, $dados ){
        try {
            $banco = $this->conecta();
            $statement = $banco->prepare($query);
            for($i=0;$i<count($dados);$i++){
                foreach($dados[$i] as $chave => $valor){
                    $statement->bindValue($chave, $valor);
                }
            }
            $statement->execute();
            $erro = $statement->errorInfo();
            if($erro[2]){
                printR($erro);
                throw new Exception("Erro ao efetuar consulta");
            }
            return $banco->lastInsertId();
        }catch(Exception $e){
            echo $e->getMessage();
        }
        $banco = null;
    }

    public function insere( $query, $dados ){
        try {
            $banco = $this->conecta();
            $statement = $banco->prepare($query);
            for($i=0;$i<count($dados);$i++){
                foreach($dados[$i] as $chave => $valor){
                    $statement->bindValue($chave, $valor);
                }
            }
            $statement->execute();
            if(count($dados[0]) > 10){
            }
            $erro = $statement->errorInfo();
            if($erro[2]){
                echo "\n<!-- ".printR($erro)." -->\n"; die();
                throw new Exception("Erro ao efetuar cadastro");
            }
            return "ok";
        }catch(Exception $e){
            echo $e->getMessage();
        }
        $banco = null;
    }

    public function altera( $query, $dados ){
        try {
            $banco = $this->conecta();
            $statement = $banco->prepare($query);
            for($i=0;$i<count($dados);$i++){
                foreach($dados[$i] as $chave => $valor){
                    $statement->bindValue($chave, $valor);
                }
            }
            $statement->execute();
            $erro = $statement->errorInfo();
            if($erro[2]){
                echo $erro[2];
                throw new Exception("Erro ao efetuar cadastro");
            }
            return "ok";
        }catch(Exception $e){
            exibeAlerta($erro[2], 'voltar');
            return $e->getMessage();
        }
        $banco = null;
    }

    public function deleta( $query, $dados ){
        try {
            $banco = $this->conecta();
            $statement = $banco->prepare($query);
            for($i=0;$i<count($dados);$i++){
                foreach($dados[$i] as $chave => $valor){
                    $statement->bindValue($chave, $valor);
                }
                $statement->execute();
                if(!$statement->execute()){
                    $erro = $statement->errorInfo();
                    if($erro[2]){
                        printR($erro);
                        throw new Exception($erro[2]);
                    }
                }
            }
            return "ok";
        }catch(Exception $e){
            return $e->getMessage();
        }
        $banco = null;
    }
}
