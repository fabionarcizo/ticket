<?php 
if(!isset($_SESSION)){
	session_start();
}
include('../includes/conexao.php');
include('../includes/funcao.php');
$link = '../logout.php';
verifica_online($link);


//var_dump($_POST);
$id_solicitante = $_POST['id_solicitante'];
$setor = $_POST['setor'];
$cliente = $_POST['cliente'];
$cliente = trim($cliente);
$titulo = $_POST['titulo'];
$id_categoria = $_POST['id_categoria'];
$id_tipo_solicitacao = $_POST['id_tipo_solicitacao'];
$descricao = $_POST['descricao'];
$situacao = '1';
$data_solicitacao = date('Y-m-d');
$hora_solicitacao = date('H:i');
//$anexos = $_POST['anexos'];

$area_ti = verifica_area_ti($conexao, $id_tipo_solicitacao);

$query = "INSERT INTO SOLICITACOES (
	id_solicitante,
	setor,
	cliente,
	titulo,
	id_categoria,
	id_tipo_solicitacao,
	descricao,
	situacao, 
	data_solicitacao,
	hora_solicitacao,
	area_ti						
) VALUES (
	'$id_solicitante',
	'$setor',
	'$cliente',
	'$titulo',
	'$id_categoria',
	'$id_tipo_solicitacao',
	'$descricao',
	'$situacao',
	'$data_solicitacao',
	'$hora_solicitacao',
	'$area_ti'
)
";
$insert = sql($conexao, $query, 'insert');
if(gettype($insert) != 'object'){
	$_SESSION['msgOk'] = "Solicitação cadastrada com sucesso!";
	redirect('../dashboard.php');
}else{	
	$mensagem =  $insert->getMessage();
	//$mensagem = "Entre em contato com o setor de TI";
	alert($mensagem, 'Erro: ');
	//redirect('../dashboard.php');
}


 ?>