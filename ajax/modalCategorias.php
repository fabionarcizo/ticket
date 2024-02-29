<?php 
//error_reporting(0);
include('../includes/conexao.php');
include('../includes/funcao.php');

//echo '<span>teste</span>';

$query = "SELECT
	sc.categoria,
	st.tipo_solicitacao,
	st.sla,
	st.sla1,
	st.sla2
from SOLICITACOES_CATEGORIAS as SC
left join SOLICITACOES_TIPOS as ST
on SC.id_categoria = ST.id_categoria
order by sc.categoria asc";	
//var_dump($query);
$consulta = sql($conexao, $query, 'select');
if(gettype($consulta) !='object'){
	if(count($consulta) > 0 ){
		foreach($consulta as $dados){
			$categoria = $dados['categoria'];
			$tipo_solicitacao = $dados['tipo_solicitacao'];
			$sla = $dados['sla'];
			$sla1 = $dados['sla1'];			
			$sla2 = $dados['sla2'];
			$sla2 = intval($sla2);

			if($sla1 < 1){
				$slap = $sla1 * 60;
				$slap = $slap.' minutos';
			}

			if($sla1 >= 1){
				$sla1 = intval($sla1);					
				$slap = $sla1.' hora';
			}				
			
			echo '<tr>';
				echo '<td>'.$categoria.'</td>';
				echo '<td>'.$tipo_solicitacao.'</td>';
				echo '<td>'.$sla.'</td>';										
				echo '<td>'.$slap.'</td>';
				echo '<td>'.$sla2.' horas </td>';
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

$mensagem = "Falha ao carregar lista!";
$option =  '<option> '.$mensagem.' </option>';
echo $option;