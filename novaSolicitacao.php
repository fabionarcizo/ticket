<?php 
	include('includes/header.php');
	include('includes/funcao.php');
	include('includes/conexao.php');
	if(!isset($_SESSION)){
		session_start();
	}
	$link = 'logout.php';
	verifica_online($link);
    //var_dump($_SESSION);
	$setor = textoSetor($conexao, $_SESSION['setor']);
?>
<div class="container">
	<br>
	<span class="fs-4 text-secondary">Nova Solicitação</span>
	<form action="sql/insertSolicitacao.php" method="POST">
		<div class="card shadow-sm rounded-3">
			<div class="card-body">		
				<div class="row mb-2">			
					<div class="col-sm-4">
						<label for="solicitante">SOLICITANTE</label>
						<input type="text" class="form-control form-control-sm" name="solicitante" id="solicitante" readonly value="<?php echo $_SESSION['nome'].' '.$_SESSION['sobrenome']; ?>" >
					</div>
					<div class="col-sm-2">
						<label for="setor">SETOR</label>
						<input type="text" class="form-control form-control-sm" name="" id="" readonly value="<?= $setor; ?>">
					</div>
					<div class="col-sm-6">
						<label for="cliente">CLIENTE</span></label>
						<select name="cliente" id="cliente" class="form-select form-select-sm">
							<option value="">Selecione...</option>
                            <option value="00000">Todos</option>
							<?php selectCliente($conexao); ?>
						</select>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-sm-6">						
						<label for="titulo">TÍTULO<span class="text-danger">*</span></label>
						<input type="text" maxlength="50" class="form-control form-control-sm" name="titulo" id="titulo" required>
					</div>
					<div class="col-sm-2">
						<label for="id_categoria">CATEGORIA<span class="text-danger">*</span></label>
						<select class="form-select form-select-sm" name="id_categoria" id="id_categoria" onchange="selectTipoSolicitacao(this.value, 0)" required>
							<option value="">Selecione...</option>
							<?php selectCategoria($conexao); ?>
						</select>
					</div>
					<div class="col-sm-4">						
						<label for="id_tipo_solicitacao">TIPO DE SOLICITAÇÃO<span class="text-danger">*</span></label>
						<select class="form-select form-select-sm" name="id_tipo_solicitacao" id="id_tipo_solicitacao" required>
							<option value=""></option>							
						</select>
					</div>
											
				</div>
				<div class="row mb-2">
					<div class="col-sm-12">						
						<label for="descricao">DESCRIÇÃO<span class="text-danger">*</span></label>
						<textarea name="descricao" id="descricao" cols="30" rows="3" class="form-control" style="resize: none;" required></textarea>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-sm-4">
						<span class="text-danger">*</span><span> Campos de preenchimento obrigatório.</span>
					</div>
					<div class="col-sm-6">
						<span class=""> Dúvidas sobre qual categoria usar? </span><a href="#" id="btnModalCategorias" data-bs-toggle="modal" data-bs-target="#modalCategoria" >Clique aqui</a>
					</div>                    
				</div>
				<!-- <div class="row mb-2">
						<div class="col-sm-4">
								<label for="anexos">INSERIR ANEXOS</label>
								<input type="file" multiple class="form-control form-control-sm" name="anexos" id="anexos" >
						</div>
				</div> -->
                					
			</div>           			
		</div>
		<br>
		<button type="submit" class="btn btn-sm btn-primary shadow-sm">Salvar</button>
        <input type="hidden" name="id_solicitante" value="<?= $_SESSION['id_user']; ?>" >
		<input type="hidden" name="setor" value="<?= $_SESSION['setor']; ?>">  		
		<a href="dashboard.php" class="btn btn-sm btn-secondary shadow-sm">Voltar</a>									
	</form>	
  <br>
  <!-- Modal -->
  <!-- Modal Categorias -->  
	<div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-scrollable">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalCategoriaLabel">Qual categoria usar?</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-sm table-hover table-bordered" id="tabelaAnexos" >
						<thead align="center">
							<tr>
								<th>Categoria</th>
								<th>Solicitação</th>																
								<th>Nível</th>
								<th>Primeiro Atendimento</th>
								<th>Prazo final</th>
							</tr>
						</thead>
						<tbody id="tbodyCategorias" align="center">								
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
  <!-- Fim Modal Categorias -->
  <!-- Fim Modal -->
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
	function modalCategoria(){		
		$.ajax({
			url: 'ajax/modalCategorias.php',
			type: 'GET',
			data: {},
			success: function(result){				
				//console.log(result);
				$('#tbodyCategorias').html(result);
			},
			error: function (error) {
				console.error('Erro na requisição AJAX', error);
			}
		});
	}	
	$(document).ready(function (){
		$('#btnModalCategorias').on('click', function (){		
			$('#tbodyCategorias').empty();
			modalCategoria();					
		});
	});
</script>
<?php include('includes/footer.php');?>