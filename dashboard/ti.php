<?php 
	$quant_dev = 0;
	$quant_infra = 0;
	$quant_aberto = 0;
	$quant_andamento = 0;
?>
<div class="container-fluid">
	<br>
	<span class="fs-4 text-secondary">Dashboard</span>
	<div class="row mb-2">
		<div class="col-sm-4 mb-2">
			<div class="card shadow-sm" id="solicitacoes" >
				<div class="card-body">
					<div class="row mb-1">
						<div class="col-sm-12 mb-1"><span class="fs-3">Quantidade de Solicitações</span></div>
					</div>
					<div class="row mb-1">
						<div class="col-sm-7 mb-1">
							<div align="center" ><canvas id="grafico"></canvas></div>
						</div>
						<div class="col-sm-5 mb-1" align="center">							
							<div class="card mb-2">
								<div class="card-body">
									<div class="row">
										<span class="fs-5" id="quant_dev" >Dev</span>
									</div>
									<div class="row">
										<span class="fs-5" id="quant_infra" >Infra</span>
									</div>
								</div>
							</div>
							<div class="card mb-2">
								<div class="card-body">
									<div class="row">
										<span class="fs-6" id="quant_aberto" >Aberto: 99</span>
									</div>
									<div class="row">
										<span class="fs-6" id="quant_andamento" >Andamento: 99</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-8 mb-2">
			<div class="card shadow-sm" id="atividades" >
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-sm table-hover table-borderless text-nowrap">
							<thead>
								<tr>
									<th width="5%">Data</th>
									<th width="5%">Hora</th>
									<th width="10%">Usuário</th>
									<th width="40%">Atividade</th>									
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									$query_atividade = "SELECT TOP 10 * FROM SOLICITACOES_ATIVIDADES order by id_atividade desc";
									$atividades = sql($conexao, $query_atividade, 'select');
									if(gettype($atividades == 'object')){
										foreach($atividades as $dados_atividades){
											$a_id_solicitacao = $dados_atividades['id_solicitacao'];
											$hora_atividade = $dados_atividades['hora_atividade'];
											if(!is_null($hora_atividade)){
												$m_hora_atividade = substr($hora_atividade, 0, 5);
											}else{
												$m_hora_atividade = '';
											}
											$data_atividade = $dados_atividades['data_atividade'];
											if(!is_null($data_atividade)){
												$m_data_atividade = databr($data_atividade);
											}else{
												$m_data_atividade = '';
											}											
											$atividade = $dados_atividades['atividade'];
											$usuario = $dados_atividades['id_user'];
										?>
										<tr>
											<td width="8%"><? $m_hora_atividade;?></td>
											<td width="15%" class="text-success"><? $m_data_atividade;?></td>
											<td><? $id_user;?></td>
											<td width="75%"><?php echo $atividade.' id: '.$a_id_solicitacao;?></td>											
											<td width="2%"><i class="fa fa-search"></i></td>
										</tr>
										<?php 
										}
									}else{
										$mensagem = $atividades->getMessage();
									}
								
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Solicitações abertas -->
	<div class="card shadow-sm">
		<div class="card-body">
			<h5>Solicitações abertas</h5>
			<hr class="hr-primary">
			<div class="table-responsive">
				<table class="table table-sm table-hover table-bordered text-nowrap" id="table">
					<thead align="center" class="bg-primary text-white">
						<tr>
							<th width="1%"><i class="fa fa-warning"></i></th>
							<th width="1%">SLA</th>
							<th width="5%">Data</th>
							<th width="10%">Solicitante</th>
							<th width="5%">Setor</th>		
							<th>Título</th>							
							<th width="10%">Categoria</th>								
							<th width="1%"></th>
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
							SC.categoria,
							sct.tipo_solicitacao
						FROM SOLICITACOES AS S
							left join USUARIOS_PHP as U
							on S.id_solicitante = U.id_user
							left join USUARIOS_PHP_SETORES as ST
							on S.setor = ST.id_setor
							left join SOLICITACOES_CATEGORIAS as SC
							on S.id_categoria = SC.id_categoria
							left join SOLICITACOES_TIPOS AS SCT
							on s.id_tipo_solicitacao = sct.id_tipo_solicitacao
						where S.situacao in ('1') order by s.data_solicitacao desc";
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
								$categoria = $dados['categoria'];
								$tipo_solicitacao = $dados['tipo_solicitacao'];
								if($area_ti == 1){
									$quant_infra++;
								}
								if($area_ti == 2){
									$quant_dev++;
								}
								?>
								<tr>
									<td><input type="checkbox" class="form-check-input"></td>
									<td><i class="fa fa-circle"></td>
									<td><?= $m_data_solicitacao; ?></td>
									<td><?= $solicitante; ?></td>
									<td><?= $setor; ?></td>
									<td><?= $titulo; ?></td>
									<td><span data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $tipo_solicitacao;?>"><?= $categoria; ?></span></td>											
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
	<!-- Fim Solicitações Abertas -->
	<!-- Solicitações Em andamento -->	
	<div class="card shadow-sm">
		<div class="card-body">
			<h5>Solicitações em andamento</h5>
			<hr class="hr-primary">
			<div class="table-responsive">
				<table class="table table-sm table-hover table-bordered text-nowrap" id="table">
					<thead align="center" class="bg-primary text-white">
						<tr>
							<th width="1%"><i class="fa fa-warning"></i></th>
							<th width="1%">SLA</th>
							<th width="5%">Data</th>
							<th width="10%">Solicitante</th>
							<th width="5%">Setor</th>		
							<th>Título</th>							
							<th width="10%">Categoria</th>
							<th width="10%">Responsável</th>
							<th width="1%"></th>
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
							SC.categoria,
							sct.tipo_solicitacao
						FROM SOLICITACOES AS S
							left join USUARIOS_PHP as U
							on S.id_solicitante = U.id_user
							left join USUARIOS_PHP_SETORES as ST
							on S.setor = ST.id_setor
							left join SOLICITACOES_CATEGORIAS as SC
							on S.id_categoria = SC.id_categoria
							left join SOLICITACOES_TIPOS AS SCT
							on s.id_tipo_solicitacao = sct.id_tipo_solicitacao
						where S.situacao in ('2') order by s.data_solicitacao desc";
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
								$categoria = $dados['categoria'];
								$tipo_solicitacao = $dados['tipo_solicitacao'];
								if($area_ti == 1){
									$quant_infra++;
								}
								if($area_ti == 2){
									$quant_dev++;
								}
								?>
								<tr>
									<td><input type="checkbox" class="form-check-input"></td>
									<td><i class="fa fa-circle"></td>
									<td><?= $m_data_solicitacao; ?></td>
									<td><?= $solicitante; ?></td>
									<td><?= $setor; ?></td>
									<td><?= $titulo; ?></td>
									<td><span data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $tipo_solicitacao;?>"><?= $categoria; ?></span></td>
									<td><?= $solicitante; ?></td>
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
	<!-- FimSolicitações Em andamento -->
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
<script>
  const ctx = document.getElementById('grafico');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Dev', 'Infra '],
      datasets: [{        
        data: [<?= $quant_dev; ?>, <?= $quant_infra; ?>],
        borderWidth: 1
      }]
    },
    options: { 
			plugins:{
				legend: {
					display: true
					
				}
			}
    }
  });
</script>