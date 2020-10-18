<?php
class Fatura{
    private $id;
    private $idCliente;
    private $idBoleto = NULL;
    private $idUsuario = NULL;
    private $idControle = NULL;
    private $status = 'A';
    private $pagamento = NULL;
    private $vencimento;
    private $numeroNota = NULL;

    private $valor;

// contrutor vazio
    public function __construct(){}

//MÉTODOS
    public function alteraIdBoleto(){
        $sql = "
          UPDATE Fatura
             SET idBoleto = ?
           WHERE id = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idBoleto,
                '2' => $this->id
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            $this->logFaturaHistorico( $this->idUsuario, $this->id, 'B' );
            return true;
        }else{
            return false;
        }
    }

    public function alteraNumeroNota(){
        $sql = "
          UPDATE Fatura
             SET numeroNota = ?
           WHERE id = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->numeroNota,
                '2' => $this->id
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            $this->logFaturaHistorico( $this->idUsuario, $this->id, 'N' );
            return true;
        }else{
            return false;
        }
    }

    public function alteraGrupoNota(){
        $sql = "
          UPDATE Fatura
             SET numeroNota = ?
           WHERE idControle = ?
             AND numeroNota IS NULL
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->numeroNota,
                '2' => $this->idControle
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            $this->logFaturaHistorico( $this->idUsuario, $this->id, 'N' );
            return true;
        }else{
            return false;
        }
    }

    public function alteraVencimento(){
        $sql = "
          UPDATE Fatura
             SET vencimento = ?
           WHERE id = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->vencimento,
                '2' => $this->id
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            $this->logFaturaHistorico( $this->idUsuario, $this->id, 'V' );
            return true;
        }else{
            return false;
        }
    }

    public function atualizaIdControle(){
        $sql = "
			UPDATE Fatura
			   SET idControle = ?
			 WHERE id = ?
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idControle,
                '2' => $this->idControle
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            return true;
        }else{
            return false;
        }
    }

    public function cancela(){
        $sql = "
            UPDATE Fatura
               SET pagamento = NOW(),
                   status = 'C',
                   idUsuario = ?
             WHERE id = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idUsuario,
                '2' => $this->id
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            $this->logFaturaHistorico( $this->idUsuario, $this->id, 'C' );
            return true;
        }else{
            return false;
        }
    }

    public function insere(){
        $sql = "
            INSERT INTO Fatura (
                   idCliente,
                   status,
                   pagamento,
                   vencimento,
                   idControle
            ) VALUES (
                   ?,?,?,?,?
            )
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->idCliente,
                '2' => $this->status,
                '3' => $this->pagamento,
                '4' => $this->vencimento,
                '5' => $this->idControle
            )
        );
        $result = $bd->insereRetornaId($sql, $dados);
        if($result > 0){
            $this->logFaturaHistorico( $this->idUsuario, $result, 'G' );
            return $result;
        }else{
            return false;
        }
    }

    public function liquida(){
        $sql = "
            UPDATE Fatura
               SET pagamento = ?,
                   status = 'F'
             WHERE id = ?
        ";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $this->pagamento,
                '2' => $this->id
            )
        );
        $result = $bd->altera($sql, $dados);
        if($result=='ok'){
            $this->logFaturaHistorico( $this->idUsuario, $this->id, 'L' );
            return true;
        }else{
            return false;
        }
    }

    public function listaAbertas( $idCliente ){
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   SUM(FatIte.valor) AS valor,
				   FatIte.descricao AS status,
				   cli.razaoSocial AS idCliente
			  FROM Fatura AS fat,
			  	   FaturaItem AS FatIte,
			  	   Cliente AS cli
		     WHERE fat.status = 'A'
		       AND fat.idCliente = '$idCliente'
		       AND fat.id = FatIte.idFatura
		       AND fat.idCliente = cli.id
		       AND NOT EXISTS (
		           SELECT 1
		             FROM FaturaHistorico AS fatHis
		            WHERE fatHis.idFatura = fat.id
		              AND fatHis.status IN ('E','A')
		       )
		  GROUP BY fat.id
		  ORDER BY fat.vencimento
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public static function listaCaixa( $dataInicial, $dataFinal ){
        if($dataInicial < $dataFinal){
            $ordem = 'ASC';
        } else {
            $ordem = 'DESC';
            $aux = $dataInicial;
            $dataInicial = $dataFinal;
            $dataFinal = $aux;
        }
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   SUM(FatIte.valor) AS valor,
				   cli.razaoSocial AS idCliente
			  FROM Fatura AS fat,
			  	   FaturaItem AS FatIte,
			  	   Cliente AS cli
		     WHERE fat.status = 'F'
		       AND fat.id = FatIte.idFatura
		       AND fat.idCliente = cli.id
		       AND fat.pagamento BETWEEN '$dataInicial' AND '$dataFinal'
		  GROUP BY fat.id
		  ORDER BY fat.pagamento $ordem,
		           fat.vencimento $ordem
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaCanceladas( ){
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   FatIte.descricao AS status,
				   SUM(FatIte.valor) AS valor,
				   usu.nome AS idUsuario,
				   cli.nomeFantasia AS idCliente
			  FROM Fatura AS fat
			  JOIN FaturaItem AS FatIte
			    ON fat.id = FatIte.idFatura
			  JOIN Cliente AS cli
			    ON fat.idCliente = cli.id
		 LEFT JOIN Usuario AS usu
		        ON fat.idUsuario = usu.idUsuario
		     WHERE fat.status = 'C'
		  GROUP BY fat.id
		  ORDER BY fat.pagamento DESC
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaControle( ){
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   SUM(FatIte.valor) AS valor,
				   FatIte.descricao AS status,
				   cli.nomeFantasia AS idCliente
			  FROM Fatura AS fat,
			  	   FaturaItem AS FatIte,
			  	   Cliente AS cli
		     WHERE fat.idControle = '$this->idControle'
		       AND fat.id = FatIte.idFatura
		       AND fat.idCliente = cli.id
		  GROUP BY fat.id
		  ORDER BY fat.vencimento
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaEnviadas( $idCliente ){
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   SUM(FatIte.valor) AS valor,
				   FatIte.descricao AS status,
				   cli.razaoSocial AS idCliente
			  FROM Fatura AS fat,
			  	   FaturaItem AS FatIte,
			  	   Cliente AS cli
		     WHERE fat.status = 'A'
		       AND fat.idCliente = '$idCliente'
		       AND fat.id = FatIte.idFatura
		       AND fat.idCliente = cli.id
		       AND EXISTS (
		           SELECT 1
		             FROM FaturaHistorico AS fatHis
		            WHERE fatHis.idFatura = fat.id
                      AND fatHis.status IN ('E','A')	            
		       )
		  GROUP BY fat.id
		  ORDER BY fat.vencimento
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaGerencianet( ){
        $dataLimite = date('Y-m-d', strtotime('+' . DIASENVIOFATURA . ' days'));
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   SUM(fatIte.valor) AS valor,
				   fatIte.descricao AS status,
				   cli.razaoSocial AS idCliente
			  FROM Fatura AS fat
		 LEFT JOIN FaturaItem AS fatIte ON fat.id = fatIte.idFatura
	     LEFT JOIN Cliente AS cli ON fat.idCliente = cli.id 
		     WHERE fat.status = 'A'
		       AND fat.idBoleto IS NOT NULL
		       AND fat.vencimento <= '$dataLimite'
		  GROUP BY fat.id
		  ORDER BY vencimento
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaGraficoPrevisao( $dataInicial, $dataFinal ){
        $dataInicial = dataToBase($dataInicial);
        $dataFinal = dataToBase($dataFinal);
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   SUM(fatIte.valor) AS valor,
				   ser.nome AS status,
				   ser.idServico AS numeroNota
			  FROM Fatura AS fat
		 LEFT JOIN FaturaItem AS fatIte ON fat.id = fatIte.idFatura
		 LEFT JOIN Servico AS ser ON fatIte.idServico = ser.idServico 
		     WHERE fat.status = 'A'
		       AND fat.vencimento BETWEEN '$dataInicial' AND '$dataFinal'
		  GROUP BY YEAR(fat.vencimento),
		           MONTH(fat.vencimento),
		           fatIte.idServico
		  ORDER BY fat.vencimento
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaLiquidadas( $idCliente ){
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   FatIte.descricao AS status,
				   SUM(FatIte.valor) AS valor
			  FROM Fatura AS fat,
			  	   FaturaItem AS FatIte
		     WHERE fat.status = 'F'
		       AND fat.idCliente = '$idCliente'
		       AND fat.id = FatIte.idFatura
		  GROUP BY fat.id
		  ORDER BY fat.pagamento DESC
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaLiquidadasPorServico( $idServico ){
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   FatIte.descricao AS status,
				   SUM(FatIte.valor) AS valor
			  FROM Fatura AS fat,
			  	   FaturaItem AS FatIte
		     WHERE fat.status = 'F'
		       AND fat.idCliente = '$this->idCliente'
		       AND fat.vencimento < '$this->vencimento'
		       AND FatIte.idServico = '$idServico'
		       AND fat.id = FatIte.idFatura
		  GROUP BY fat.id
		  ORDER BY fat.vencimento DESC
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaNotasTrocadas( ){
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   FatIte.descricao AS status,
				   usu.nome AS idUsuario,
				   cli.nomeFantasia AS idCliente,
			       fatHis.alterado AS idBoleto
			  FROM FaturaHistorico AS fatHis
			  JOIN Fatura AS fat
			    ON fatHis.idFatura = fat.id
			  JOIN FaturaItem AS FatIte
			    ON fat.id = FatIte.idFatura
			  JOIN Cliente AS cli
			    ON fat.idCliente = cli.id
		 LEFT JOIN Usuario AS usu
		        ON fatHis.idUsuario = usu.idUsuario
			 WHERE fatHis.status = 'R'			
		  ORDER BY fatHis.alterado DESC
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaPagamentos( $status, $dataInicial, $dataFinal ){
        $dataInicial = dataToBase($dataInicial);
        $dataFinal = dataToBase($dataFinal);
        if($status == 'F'){
            $campoFiltro = 'pagamento';
        } else {
            $campoFiltro = 'vencimento';
        }
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   SUM(FatIte.valor) AS valor,
				   FatIte.descricao AS status
			  FROM Fatura AS fat,
			  	   FaturaItem AS FatIte,
			  	   Cliente AS cli
		     WHERE fat.status = '$status'
		       AND fat.id = FatIte.idFatura
		       AND fat.idCliente = cli.id
		       AND fat.$campoFiltro BETWEEN '$dataInicial' AND '$dataFinal'
		  GROUP BY fat.id
		  ORDER BY fat.$campoFiltro
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function listaPendentes( $diaLimite = DIASENVIOFATURA ){
        $dataLimite = date('Y-m-d', strtotime("+$diaLimite days"));
        $bd = new BdSQL;
        $sql = "
			SELECT fat.*,
				   SUM(FatIte.valor) AS valor,
				   FatIte.descricao AS status
			  FROM Fatura AS fat,
			  	   FaturaItem AS FatIte,
			  	   Cliente AS cli
		     WHERE fat.status = 'A'
		       AND fat.id = FatIte.idFatura
		       AND fat.idCliente = cli.id
		       AND NOT EXISTS (SELECT 1
		                        FROM FaturaHistorico AS fatHis
		                       WHERE fat.id = fatHis.idFatura 
		                         AND fatHis.status IN ('E','A')
		                      )
		       AND fat.vencimento < '$dataLimite'
		  GROUP BY fat.id
		  ORDER BY fat.vencimento,
		           fat.id
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function logFaturaHistorico( $idUsuario, $idFatura, $status){
        $insere = "
            INSERT INTO FaturaHistorico (
				idUsuario,
				idFatura,
				status
			)  VALUES (
				?,?,?
			)
		";
        $bd = new BdSQL;
        $dados = array(
            array(
                '1' => $idUsuario,
                '2' => $idFatura,
                '3' => $status
            )
        );
        $result = $bd->insereRetornaId($insere, $dados);
        if($result > 0){
            return $result;
        }else{
            return false;
        }
    }

    public function logFaturaHistoricoLista( $idFatura ){
        $bd = new BdSQL;
        $sql = "
			SELECT fatHis.alterado AS id,
			CASE fatHis.status
                WHEN 'G' THEN 'Fatura Gerada'
                WHEN 'B' THEN 'Boleto Gerado'
                WHEN 'N' THEN 'Nota Carregada'
                WHEN 'E' THEN 'Cobrança enviada'
                WHEN 'L' THEN 'Fatura Liquidada'
                WHEN 'V' THEN 'Vecimento alterado'
                WHEN 'C' THEN 'Fatura cancelada'
                WHEN 'A' THEN 'Envio Agrupado'
                WHEN 'R' THEN 'Nota Removida'
                ELSE 'Desconhecido'
			END AS status,
			       usu.nome AS idUsuario
			  FROM FaturaHistorico AS fatHis
			  JOIN Usuario AS usu ON fatHis.idUsuario = usu.idUsuario
		     WHERE fatHis.idFatura = '$idFatura'
		  ORDER BY alterado
		";
        $resultSet = $bd->consulta( $sql );
        $resultado = array();
        $i = 0;
        $totalResultados = count($resultSet);
        for( $j=0; $j<$totalResultados; $j++ ){
            $objeto = new Fatura;
            foreach($resultSet[$j] as $chave=>$valor){
                if(!is_int($chave)){
                    $set = "set".ucfirst( $chave );
                    $objeto->$set( $valor );
                }
            }
            $resultado[$i] = $objeto;
            $i++;
        }
        return $resultado;
    }

    public function seleciona(){
        $bd = new BdSQL;
        $sql = "
            SELECT *
              FROM Fatura
             WHERE id = '$this->id'
        ";
        $resultado = $bd->consulta($sql);
        if(count($resultado)==1){
            foreach( $resultado[0] as $chave=>$valor ){
                if(!is_int($chave)){
                    $this->$chave = $valor;
                }
            }
            return true;
        }else{
            return false;
        }
    }

    public function selecionaPelaFatura( ){
        $bd = new BdSQL;
        $sql = "
            SELECT fat.*,
                   fatIte.descricao AS status,
                   fatIte.idServico AS idUsuario,
                   SUM(fatIte.valor) AS valor
              FROM Fatura AS fat,
                   FaturaItem AS fatIte
             WHERE fat.id = fatIte.idFatura
               AND fat.id = '$this->id'
        ";
        $resultado = $bd->consulta($sql);
        if(count($resultado)==1){
            foreach( $resultado[0] as $chave=>$valor ){
                if(!is_int($chave)){
                    $this->$chave = $valor;
                }
            }
            return $resultado;
        } else {
            return false;
        }
    }

    public function selecionaPeloBoleto( ){
        $bd = new BdSQL;
        $sql = "
            SELECT fat.*,
                   SUM(fatIte.valor) AS valor
              FROM Fatura AS fat,
                   FaturaItem AS fatIte
             WHERE fat.id = fatIte.idFatura
               AND fat.idBoleto = '$this->idBoleto'
               AND fat.status = 'A'
        ";
        $resultado = $bd->consulta($sql);
        if(count($resultado)==1){
            foreach( $resultado[0] as $chave=>$valor ){
                if(!is_int($chave)){
                    $this->$chave = $valor;
                }
            }
            return $resultado;
        } else {
            return false;
        }
    }

    public static function selecionaHistoricoCaixa( $dataInicial, $dataFinal ){
        if($dataInicial > $dataFinal){
            $dataInicial = $dataFinal;
        }
        $bd = new BdSQL;
        $sql = "
            SELECT SUM(fatIte.valor) AS valor
              FROM Fatura AS fat,
                   FaturaItem AS fatIte
             WHERE fat.id = fatIte.id
               AND fat.status = 'F'
               AND fat.pagamento < '$dataInicial'
        ";
        $resultado = $bd->consulta($sql);
        return $resultado[0]['valor'];
    }

//GETTERS E SETTERS
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getIdCliente(){
        return $this->idCliente;
    }
    public function setIdCliente($idCliente){
        $this->idCliente = $idCliente;
    }
    public function getIdBoleto()
    {
        return $this->idBoleto;
    }
    public function setIdBoleto($idBoleto)
    {
        $this->idBoleto = $idBoleto;
    }
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    public function getIdControle()
    {
        return $this->idControle;
    }
    public function setIdControle($idControle)
    {
        $this->idControle = $idControle;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function getPagamento(){
        return baseToData($this->pagamento);
    }
    public function setPagamento($pagamento){
        $this->pagamento = dataToBase($pagamento);
    }
    public function getVencimento(){
        return baseToData($this->vencimento);
    }
    public function setVencimento($vencimento){
        $this->vencimento = dataToBase($vencimento);
    }
    public function getValor(){
        return baseToDecimal($this->valor);
    }
    public function setValor($valor){
        $this->valor = decimalToBase($valor);
    }
    public function getNumeroNota()
    {
        return $this->numeroNota;
    }
    public function setNumeroNota($numeroNota)
    {
        $this->numeroNota = $numeroNota;
    }
}
