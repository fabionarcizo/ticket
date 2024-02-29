<?php 
//error_reporting(0);
include('../includes/conexao.php');
include('../includes/funcao.php');

//echo '<span>teste</span>';


if(isset($_POST['id_solicitacao'])){
	$id_solicitacao = $_POST['id_solicitacao'];
	$query = "SELECT 
		A.id_anexo, 
		A.id_solicitacao, 
		A.hora_anexo, 
		A.data_anexo, 
		A.id_user, 
		A.caminho_arquivo, 
		U.nome, 
		U.sobrenome
	from SOLICITACOES_ANEXOS AS A
	left join USUARIOS_PHP as U
	on A.id_user = U.id_user
	WHERE id_solicitacao = '$id_solicitacao'";
	//$query = "SELECT * from SOLICITACOES_ANEXOS WHERE id_solicitacao = '$id_solicitacao'";
	//var_dump($query);
	$consulta = sql($conexao, $query, 'select');
	if(gettype($consulta) !='object'){
		if(count($consulta) > 0 ){
			foreach($consulta as $dados){
				$id_anexo = $dados['id_anexo'];
				$id_solicitacao = $dados['id_solicitacao'];
				$hora_anexo = $dados['hora_anexo'];				
				$hora_anexo = substr($hora_anexo, 0, 5);				
				$data_anexo = $dados['data_anexo'];
				$data_anexo = databr($data_anexo);
				$id_user = $dados['id_user'];
				$caminho_arquivo = $dados['caminho_arquivo'];
				$nome = $dados['nome'].' '.$dados['sobrenome'];
				echo '<tr>';
					echo '<td>'.$data_anexo.'</td>';
					echo '<td>'.$hora_anexo.'</td>';
					echo '<td>'.$nome.'</td>';					
					echo '<td width="2%"><a href="'.$caminho_arquivo.'" target="_blank"><i class="fa fa-search"></i></a></td>';
				echo '</tr>';
			}
		}else{
			echo '<tr>';
				echo '<td colspan="5">Nenhum anexo encontrado.</td>';
			echo '</tr>';
		}		
	}else{
		$mensagem = $consulta->getMessage();
	}	
}else{
	$mensagem = "Falha ao carregar lista!";
	$option =  '<option> '.$mensagem.' </option>';
	echo $option;
}//Fim isset
?>