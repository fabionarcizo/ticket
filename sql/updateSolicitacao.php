<?php 
if(!isset($_SESSION)){
	session_start();
}
include('../includes/conexao.php');
include('../includes/funcao.php');
$link = '../logout.php';
verifica_online($link);

//Query sem situação de finalizado
if($situacao != 4){
	$query = "UPDATE SOLICITACOES SET
		cliente = '$cliente',			                                    	
		titulo = '$titulo',
		id_categoria = '$id_categoria',
		id_tipo_solicitacao = '$id_tipo_solicitacao',			
		descricao = '$descricao',
		situacao = '$situacao',
		id_responsavel = '$id_responsavel',
		previsao = '$previsao',
		prioridade = '$prioridade'
	where id_solicitacao = '$id_solicitacao'";
}else{//Query com situação de finalizado
	$query = "UPDATE SOLICITACOES SET
		cliente = '$cliente',			                                    	
		titulo = '$titulo',
		id_categoria = '$id_categoria',
		id_tipo_solicitacao = '$id_tipo_solicitacao',			
		descricao = '$descricao',
		situacao = '$situacao',
		id_responsavel = '$id_responsavel',
		previsao = '$previsao',
		prioridade = '$prioridade',
		data_finalizacao = '$data_finalizacao',
		hora_finalizacao = '$hora_finalizacao'
	where id_solicitacao = '$id_solicitacao'";
}



