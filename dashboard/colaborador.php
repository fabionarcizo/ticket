<?php 
	$quant_dev = 0;
	$quant_infra = 0;
	$quant_aberto = 0;
	$quant_andamento = 0;
    $setor = $_SESSION['setor'];
?>
<div class="container-fluid">
	<br>
	<span class="fs-4 text-secondary">Dashboard</span>	
	<div class="card shadow-sm">
		<div class="card-body">
			<h5>Solicitações abertas</h5>
			<hr class="hr-primary">
			<div class="table-responsive">
				<table class="table table-sm table-hover table-bordered text-nowrap" id="table">
					<thead align="center" class="bg-primary text-white">
						<tr>
							<th width="1%"><i class="fa fa-warning"></i></th>
							<th width="2%">SLA</th>
							<th width="10%">Data</th>
							<th>Título</th>
							<th width="15%">Solicitante</th>
							<th width="10%">Situação</th>							
							<th width="10%">Previsão</th>
							<th width="2%"></th>
						</tr>
					</thead>
					<tbody align="center">
						<?php
						$query = "SELECT 
                            S.id_solicitacao,
                            S.id_solicitante,
                            U.nome,
                            U.sobrenome,
                            ST.setor,
                            S.titulo,
                            S.data_solicitacao,
                            s.previsao,
                            S.area_ti,
							S.situacao
                        FROM SOLICITACOES AS S
                            left join USUARIOS_PHP as U
                            on S.id_solicitante = U.id_user
                            left join USUARIOS_PHP_SETORES as ST
                            on S.setor = ST.id_setor
                        where S.situacao in ('1','2') 
                        and s.setor = '$setor'
                        order by s.id_solicitacao desc";
                        //print_r($query);
						$sql = $conexao->prepare($query);
						if ($sql->execute()) {
							$consulta = $sql->fetchAll(PDO::FETCH_ASSOC);
							$quant_aberto = count($consulta);
							foreach ($consulta as $dados) {
								$id_solicitacao = $dados['id_solicitacao'];
								$id_solicitante = $dados['id_solicitante'];
								$solicitante = $dados['nome'] . ' ' . $dados['sobrenome'];
								$setor = $dados['setor'];
								$previsao = $dados['previsao'];
								$m_previsao = databr($previsao);
								$titulo = $dados['titulo'];
								$data_solicitacao = $dados['data_solicitacao'];
								$m_data_solicitacao = databr($data_solicitacao);
								$area_ti = $dados['area_ti'];
								$situacao = $dados['situacao'];
								
								if($area_ti == 1){
									$quant_infra++;
								}
								if($area_ti == 2){
									$quant_dev++;
								}
								if($situacao == '1'){
									$m_situacao = 'Aberto';
								}
								if($situacao == '2'){
									$m_situacao = 'Em Andamento';
								}
								
								?>
								<tr>
									<td><input type="checkbox" class="form-check-input"></td>
									<td><i class="fa fa-circle"></td>
									<td><?= $m_data_solicitacao; ?></td>
									<td><?= $titulo; ?></td>
									<td><?= $solicitante; ?></td>
									<td><?= $m_situacao; ?></td>			
									<td><?= $m_previsao; ?></td>						
									<td><a href="solicitacao.php?id=<?= $id_solicitacao; ?>" target="_blank"><i class="fa fa-search"></i></a>
									</td>
								</tr>
								<?php
							}
						} else { ?>
							<tr>
								<td colspan="6"><span class="text-danger">Erro ao consultar banco de dados!</span></td>
							</tr>
						<?php }

						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>	
</div> <!-- Container -->
<br>
<script>
	// $(document).ready(function() {
	// 	$('#table').DataTable({
	// 					"pageLength": 25,
	// 			"language": {
	// 			"url": "assets/dataTables/language.json"
	// 			}
	// 	});
	// });
</script>
<script>
	$(document).ready(function (){
		var atividades = $('#atividades').height();
		var solicitacoes = $('#solicitacoes').height();		
		if (atividades > solicitacoes){
			$('#solicitacoes').height(atividades);		
		}else{
			$('#atividades').height(solicitacoes);		
		}
		var quant_dev = "<?= $quant_dev?>";
		var quant_infra = "<?= $quant_infra?>";
		var quant_aberto = "<?= $quant_aberto?>";
		var quant_andamento = "<?= $quant_andamento?>";
		document.getElementById("quant_dev").innerHTML = 'Dev: '+quant_dev;
		document.getElementById("quant_infra").innerHTML = 'Infra: '+quant_infra;
		document.getElementById("quant_aberto").innerHTML = 'Aberto: '+quant_aberto;
		document.getElementById("quant_andamento").innerHTML = 'Andamento: '+quant_andamento;
		
	});
	
</script>