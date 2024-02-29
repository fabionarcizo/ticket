<?php 
include('includes/conexao.php');
if(!isset($_SESSION)){
	session_start();
}

$id = $_POST['id'];
$empresa = $_POST['empresa'];
$cnpj = $_POST['cnpj'];
$grupo = $_POST['grupo'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$aniversario = $_POST['aniversario'];
if($aniversario == ''){
	$aniversario = '1900-01-01';
}
$genero = $_POST['genero'];
$cargo = $_POST['cargo'];
$setor = $_POST['setor'];
$endereco = $_POST['endereco'];
$participa_clube = $_POST['participa_clube'];
$categoria_interesse = $_POST['categoria_interesse'];
$ciente_parceria = $_POST['ciente_parceria'];
$data_cadastro = date('Y-m-d');

$query = "UPDATE LEBACK_FORMs SET 
						empresa = '$empresa',
						cnpj = '$cnpj',
						grupo = '$grupo',
						nome = '$nome',
						email = '$email',
						telefone = '$telefone',
						aniversario = '$aniversario',
						genero = '$genero', 
						cargo = '$cargo',
						setor = '$setor',
						endereco = '$endereco',
						participa_clube = '$participa_clube',
						categoria_interesse = '$categoria_interesse',
						ciente_parceria = '$ciente_parceria',
						data_cadastro = '$data_cadastro'
					WHERE id = '$id' ";

$sql = $conexao->prepare($query);
try{
	if($sql->execute()){
		$_SESSION['msg'] = 'Atualizado com sucesso!';
		header("Location: formEdit.php?id=$id");
	}
}catch(Exception $e){
	$mensagem = $e->getMessage();
	$_SESSION['msg'] = 'Erro ao atualizar! '.$mensagem;
	header("Location: formEdit.php?id=$id");
}
?>