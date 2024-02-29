<?php 
	include('includes/no-nav.php');
	include('includes/funcao.php');
	include('includes/conexao.php');
	if(!isset($_SESSION)){
		session_start();
	}
	
	$id_solicitacao = $_GET['id'];
	$query = "SELECT 
		S.id_solicitacao,
		S.id_solicitante,
		U.nome,
		U.sobrenome,
		ST.setor,
		S.cliente,							
		S.titulo,
		S.id_categoria,
		S.id_tipo_solicitacao,
		S.descricao,
		S.data_solicitacao,
		S.hora_solicitacao,
		S.situacao,
		S.id_responsavel,
		S.previsao,
		S.prioridade,
		S.data_finalizacao,
		S.hora_finalizacao,
		S.reaberto,
		S.data_reabertura
	FROM SOLICITACOES AS S
	left join USUARIOS_PHP as U
	on S.id_solicitante = U.id_user
	left join USUARIOS_PHP_SETORES as ST
	on S.setor = ST.id_setor
	WHERE id_solicitacao = '$id_solicitacao'
						";
	$consulta = sql($conexao, $query, 'select');
	if(gettype($consulta) != 'object'){
		foreach ($consulta as $dados) {
			$id_solicitacao = $dados['id_solicitacao'];
			$id_solicitante = $dados['id_solicitante'];
			$solicitante = $dados['nome'].' '.$dados['sobrenome'];
			$setor = $dados['setor'];                                    
			$cliente = $dados['cliente'];
			$titulo = $dados['titulo'];
			$id_categoria = $dados['id_categoria'];
			$id_tipo_solicitacao = $dados['id_tipo_solicitacao'];			
			$descricao = $dados['descricao'];
			$data_solicitacao = $dados['data_solicitacao'];
			$m_data_solicitacao = databr($data_solicitacao);
			$hora_solicitacao = $dados['hora_solicitacao'];
			$m_hora_solicitacao = substr($hora_solicitacao, 0, 5);
			$situacao = $dados['situacao'];
			$id_responsavel = $dados['id_responsavel'];
			$previsao = $dados['previsao'];
			$prioridade = $dados['prioridade'];
			$data_finalizacao = $dados['data_finalizacao'];
			$hora_finalizacao = $dados['hora_finalizacao'];
			$reaberto = $dados['reaberto'];
			$data_reabertura = $dados['data_reabertura'];
			
			//var_dump($id_solicitacao);
			

			//Ajustando o numero da solicitacao
			$len_id = strlen($id_solicitacao);			
			if($len_id == 1){
				$m_id_solicitacao = '00'.$id_solicitacao;
			}
			if($len_id > 1){
				$m_id_solicitacao = '0'.$id_solicitacao;
			}
			if($len_id > 2){
				$m_id_solicitacao = $id_solicitacao;
			}
			
			
		}   
	}else{
		//Se for objeto é pq retornou uma mensagem de erro do try/catch
		$mensagem =  $consulta->getMessage();
		echo $mensagem;
	}
	//Permissões de modificação
	#Permissões do responsavel	
	$modificar_responsavel = ' disabled';
	$modificar_previsao = ' readonly';
	$modificar_categoria = ' disabled';
	$modificar_tipo_solicitacao = ' disabled';	
	if($_SESSION['setor'] == '1'){
		$modificar_responsavel = ' ';
		$modificar_previsao = ' ';
		$modificar_categoria = ' ';
		$modificar_tipo_solicitacao = ' ';
	}
	#Permissões do solicitante
	$modifica_titulo = ' readonly';	
	$modifica_descricao = ' readonly';	
	if($situacao == 1){
		if($_SESSION['id_user'] == $id_solicitante){
			$modifica_titulo = ' ';
			$modifica_descricao = ' ';
		}
	}
	
	#Permissões da diretoria
	$modifica_prioridade = ' disabled';
	if($_SESSION['setor'] == 'Diretoria'){
		$modifica_prioridade = ' ';
	}
	//var_dump($modifica_descricao);
?>
<div class="container">
	<br>
	<span class="fs-4 text-secondary">Solicitação #<?=  $m_id_solicitacao.' | Data: '.$m_data_solicitacao.' '.$m_hora_solicitacao; ?></span>
	<form action="sql/updateSolicitacao.php" method="POST">
		<div class="card shadow-sm rounded-3">
			<div class="card-body">		
				<div class="row mb-2">			
					<div class="col-sm-4">
						<label for="solicitante">SOLICITANTE</label>
						<input type="text" class="form-control form-control-sm" name="solicitante" id="solicitante" readonly value="<?= $solicitante;?>">
					</div>
					<div class="col-sm-2">
						<label for="setor">SETOR</label>
						<input type="text" class="form-control form-control-sm" name="setor" id="setor" readonly value="<?= $setor;?>">
					</div>
					<div class="col-sm-6">
						<label for="cliente">CLIENTE</span></label>
						<select name="cliente" id="cliente" class="form-select form-select-sm">
							<option value="">Selecione...</option>
							<?php selectCliente($conexao); ?>
						</select>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-sm-6">						
						<label for="titulo">TÍTULO<span class="text-danger">*</span></label>
						<input type="text" maxlength="100" class="form-control form-control-sm" name="titulo" id="titulo" required <?= $modifica_titulo;?> value="<?= $titulo;?>">
					</div>
					<div class="col-sm-2">
						<label for="id_categoria">CATEGORIA</label>
						<select class="form-select form-select-sm" name="id_categoria" id="id_categoria" onchange="selectTipoSolicitacao(this.value, 0)" required>
							<option value="">Selecione...</option>
							<?php selectCategoria($conexao); ?>
						</select>
					</div>
					<div class="col-sm-4">						
						<label for="id_tipo_solicitacao">TIPO DE SOLICITAÇÃO</label>
						<select class="form-select form-select-sm" name="id_tipo_solicitacao" id="id_tipo_solicitacao" required>
							<option value=""></option>							
						</select>
					</div>
											
				</div>
				<div class="row mb-2">
					<div class="col-sm-12">						
						<label for="descricao">DESCRIÇÃO<span class="text-danger">*</span></label>
						<textarea name="descricao" id="descricao" cols="30" rows="3" class="form-control" style="resize: none;" <?= $modifica_descricao;?>><?= $descricao;?></textarea>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-sm-4">						
							<label for="id_responsavel">RESPONSÁVEL<span class="text-danger">*</span></label>								
							<select name="id_responsavel" id="id_responsavel" class="form-select form-select-sm" <?= $modificar_responsavel;?> required>
							<option value="">Selecione...</option>	
							<?php selectResponsavel($conexao);?>
							</select>	
					</div>						
					<div class="col-sm-2">						
						<label>PREVISÃO</label>
						<input type="date" class="form-control form-control-sm" name="previsao" id="previsao" <?= $modificar_previsao; ?>>
					</div>
					<div class="col-sm-2">
						<label for="situacao">SITUAÇÃO</span></label>
						<select name="situacao" id="situacao" class="form-select form-select-sm">
							<option value="1">1-Aberto</option>
							<option value="2">2-Em andamento</option>
							<option value="3">3-Aguardando reposta</option>
							<option value="4">4-Finalizado</option>
							<option value="5">5-Cancelado</option>								
						</select>
					</div>
					<div class="col-sm-2">						
						<label>DATA FINALIZAÇÃO</label>
						<input type="date" class="form-control form-control-sm" name="" id="data_finalizacao" readonly>
					</div>
					<div class="col-sm-2">						
						<label>HORA FINALIZAÇÃO</label>
						<input type="time" class="form-control form-control-sm" name="" id="hora_finalizacao" readonly>																	
					</div>					
				</div>
				<hr class="hr-primary">
				<div class="row mb-2">
					<div class="col-sm-2">
						<button type="submit" class="btn btn-sm btn-primary shadow-sm">Salvar</button>						
					</div>
					<div class="col-sm-2 mt-2">
						<input type="checkbox" name="prioridade" id="prioridade" class="checkbox-input" <?= $modifica_prioridade;?> >	
						<label for="prioridade">Prioridade</label>						
					</div>
				</div>					
			</div>
		</div>
		<br>		
	</form>
	<!-- Modal -->
	<!-- Mensagens -->
	<div class="modal fade" id="ModalMensagens" tabindex="-1" aria-labelledby="ModalMensagensLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary ">
					<h5 class="modal-title text-white" id="ModalMensagensLabel">Incluir mensagem</h5>
					<button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>			
				</div>
				<form action="sql/insertMensagem.php" method="POST" enctype="multipart/form-data">
					<div class="modal-body">					
						<div class="card shadow-sm rounded-3">
							<div class="card-body">
								<!-- <div class="row mb-2">            
									<div class="col-sm-12">
										<label for="anexos">Incluir anexos</label>
										<input type="file" name="anexo" id="anexo" class="form-control form-control-sm" multiple >
									</div>
								</div> -->
								<div class="row mb-2">
									<div class="col-sm-12">
										<label for="mensagem">Mensagem</label>
										<textarea type="text" name="mensagem" id="mensagem" rows="5" class="form-control form-control-sm" style="resize: none"></textarea>
									</div>
								</div>																
							</div>
						</div>					
					</div>				
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-success">Incluir</button>
						<input type="hidden" name="id_solicitacao" value="<?= $id_solicitacao; ?>">
						<input type="hidden" name="tipo_mensagem" value="1">
						<input type="hidden" name="id_user" value="<?= $_SESSION['id_user']; ?>">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Mensagens -->
	<!-- Anexos -->
	<div class="modal fade" id="ModalAnexos" tabindex="-1" aria-labelledby="ModalAnexosLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary ">
					<h5 class="modal-title text-white" id="ModalAnexosLabel"><i class="fa fa-file" >&nbsp;</i> Anexos</h5>
					<button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>			
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-sm table-hover table-bordered" id="tabelaAnexos" >
							<thead align="center">
								<tr>
									<th>Data</th>
									<th>Hora</th>
									<th>Colaborador</th>									
									<th></th>
								</tr>
							</thead>
							<tbody id="tbodyAnexos" align="center">								
							</tbody>
						</table>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>					
				</div>
			</div>
		</div>
	</div>
	<!-- Fim Anexos -->
	<!-- Fim Modal -->
	<div class="card shadow-sm rounded-3">
		<h5 class="card-header text-white bg-primary"><i class="fa fa-comments">&nbsp;</i>Mensagens</h5>
		<div class="card-body">			
			<div class="row mb-3">
				<div class="col-sm-3 mb-1">
					<button type="button" class="btn btn-sm btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#ModalMensagens">Incluir mensagem</button>
				</div>
				<div class="col-sm-6 mb-1"></div>
				<!-- <div class="col-sm-3 mb-1" align="right">
					<button class="btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" id="btnModalAnexos" data-bs-target="#ModalAnexos" ><i class="fa fa-file">&nbsp;</i>Visualizar Anexos</button>
				</div> -->
			</div>			
			<div class="table-responsive">
				<table class="table table-sm table-bordered table-hover" >					
					<tbody>
					<?php
						$query_mensagem =  "SELECT
							sm.id_solicitacao,							
							sm.hora_mensagem,
							sm.data_mensagem,
							sm.id_user,
							u.nome,
							u.sobrenome,							
							sm.tipo_mensagem,
							sm.id_mensagem,
							sm.mensagem							
						from SOLICITACOES_MENSAGENS as SM
						left join USUARIOS_PHP as U
						on sm.id_user = u.id_user
						where id_solicitacao ='$id_solicitacao' order by id_mensagem desc";
						$mensagens = sql($conexao, $query_mensagem, 'select');
						//var_dump($mensagens);
						if(gettype($mensagens) != 'object'){
							foreach ($mensagens as $dados) {
								$id_solicitacao = $dados['id_solicitacao'];
								$hora_mensagem = $dados['hora_mensagem'];
								$m_hora = substr($hora_mensagem, 0, 5);								
								$data_mensagem = $dados['data_mensagem'];
								$m_data = databr($data_mensagem);
								$id_user = $dados['id_user'];
								$nome = $dados['nome'];
								$sobrenome = $dados['sobrenome'];
								$tipo_mensagem = $dados['tipo_mensagem'];
								$mensagem = $dados['mensagem'];
							?>
								<tr>								
									<td width="20%"><span class="fw-bold"><?php echo $nome.' '.$sobrenome;?></span></td>
									<td width="15%"><span><?php echo $m_data.' '.$m_hora;?></span></td>
									<td><span><?php echo $mensagem;?></span></td>															
								</tr>	
							<?php }
						}else{
							//Se for objeto é pq retornou uma mensagem de erro do try/catch
							$mensagem =  $mensagens->getMessage();
							echo $mensagem;
						}										
						?>						
					</tbody>
				</table>
			</div>		
		
		</div>
	</div>
  <br>
</div> <!-- div container -->
<script type="text/javascript">
	function selectTipoSolicitacao(id_categoria, id_tipo_solicitacao){  	
		$('#id_tipo_solicitacao').html('<option>Carregando...</option>');
		$.ajax({
			url: 'ajax/selectTipoSolicitacao.php',
			type:'post',
			data: {
				id_categoria: id_categoria,
				id_tipo_solicitacao: id_tipo_solicitacao
			},  
			success: function(result){
				$('#id_tipo_solicitacao').html(result);
			}		
		});
	}	
</script>
<script>
	function tableAnexo(){
		var id_solicitacao = '<?= $id_solicitacao;?>';
		$.ajax({
			url: 'ajax/tableAnexo.php',
			type: 'POST',
			data: {id_solicitacao: id_solicitacao},
			success: function(result){				
				//console.log(result);
				$('#tbodyAnexos').html(result);
			},
			error: function (error) {
				console.error('Erro na requisição AJAX', error);
			}
		});
	}	
	$(document).ready(function (){
		$('#btnModalAnexos').on('click', function (){		
			$('#tbodyAnexos').empty();
			tableAnexo();					
		});
	});
</script>
<script>
	var m_id_solicitacao = '<?= $m_id_solicitacao;?>';
	var id_categoria = '<?= $id_categoria;?>';
	var id_tipo_solicitacao = '<?= $id_tipo_solicitacao;?>';
	var cliente = '<?= $cliente;?>';
	var situacao = '<?= $situacao;?>';
	var id_responsavel = '<?= $id_responsavel;?>';
	selectTipoSolicitacao(id_categoria, id_tipo_solicitacao);
	document.getElementById('id_categoria').value = id_categoria;
	document.getElementById('cliente').value = cliente;	
	document.getElementById('situacao').value = situacao;	
	document.getElementById('id_responsavel').value = id_responsavel;
	document.title = "Solicitação # "+m_id_solicitacao;
</script>
<?php include('includes/footer.php');?>

