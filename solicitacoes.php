<div class="card shadow-sm">
	<div class="card-body">
		<h5>Solicitações abertas</h5>
		<hr class="hr-primary">
		<div class="table-responsive">
			<table class="table table-sm table-hover table-bordered" id="table">
				<thead align="center" class="bg-primary text-white">
					<tr>
						<th width="1%"><i class="fa fa-warning"></i></th>
						<th width="2%">SLA</th>
						<th>Título</th>
						<th width="15%">Solicitante</th>
						<th width="10%">Setor</th>
						<th width="10%">Data</th>
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
								S.setor,
								S.titulo,
								S.data_solicitacao
							FROM SOLICITACOES AS S
								left join USUARIOS_PHP as U
								on S.id_solicitante = U.id_user
							where S.situacao in ('1')";
						$sql = $conexao->prepare($query);
						if ($sql->execute()) {
							$consulta = $sql->fetchAll(PDO::FETCH_ASSOC);
							foreach ($consulta as $dados) {
								$id_solicitacao = $dados['id_solicitacao'];
								$id_solicitante = $dados['id_solicitante'];
								$solicitante = $dados['nome'] . ' ' . $dados['sobrenome'];
								$setor = $dados['setor'];
								;
								$titulo = $dados['titulo'];
								$data_solicitacao = $dados['data_solicitacao'];
								$m_data_solicitacao = databr($data_solicitacao);
								?>
								<tr>
									<td><input type="checkbox" class="form-check-input"></td>
									<td><i class="fa fa-circle"></td>
									<td><?= $titulo; ?></td>
									<td><?= $solicitante; ?></td>
									<td><?= $setor; ?></td>
									<td><?= $m_data_solicitacao; ?></td>
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