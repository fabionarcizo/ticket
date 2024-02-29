<?php 
if(!isset($_SESSION)){
	session_start();
}
include('../includes/conexao.php');
include('../includes/funcao.php');
$link = '../logout.php';
verifica_online($link);


//var_dump($_POST);
$id_solicitacao = $_POST['id_solicitacao'];
$hora_mensagem = date('H:i');
$data_mensagem = date('Y-m-d');
$id_user = $_POST['id_user'];
$tipo_mensagem = $_POST['tipo_mensagem'];
$mensagem = $_POST['mensagem'];

//$anexos = $_POST['anexos'];

$query = "INSERT INTO SOLICITACOES_MENSAGENS (
	id_solicitacao,
	hora_mensagem,
	data_mensagem,
	id_user,
	tipo_mensagem,
	mensagem				
) VALUES (
	'$id_solicitacao',
	'$hora_mensagem',
	'$data_mensagem',
	'$id_user',	
	'$tipo_mensagem',
	'$mensagem'
)
";
$insert = sql($conexao, $query, 'insert');
if(gettype($insert) != 'object'){
	//$_SESSION['msgOk'] = "Solicitação cadastrada com sucesso!";
	$caminho = '../solicitacao.php?id='.$id_solicitacao;
	$atividade = 'Mensagem adicionada';
	$query_atividade = "INSERT INTO SOLICITACOES_ATIVIDADES (
		id_solicitacao,
		hora_atividade,
		data_atividade,
		id_user,
		atividade						
	) VALUES (
		'$id_solicitacao',
		'$hora_mensagem',
		'$data_mensagem',
		'$id_user',
		'$atividade'
	)
	";
	$insert_atividade = sql($conexao, $query_atividade, 'insert');
	if(gettype($insert_atividade) != 'object'){
		//echo 'Atividade inserida';
	}else{
		$mensagem =  $insert_atividade->getMessage();
		//echo $mensagem;	
	}

	redirect($caminho);
}else{	
	$mensagem =  $insert->getMessage();
	//$mensagem = "Entre em contato com o setor de TI";
	alert($mensagem, 'Erro: ');
	//redirect('../dashboard.php');
}




 ?>