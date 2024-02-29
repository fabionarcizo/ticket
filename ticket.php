<?php 
	include('includes/header.php');
	include('includes/conexao.php');
	include('includes/funcao.php');
	if(!isset($_SESSION)){
		session_start();
	}

	$id = $_GET['id'];
	$query = "SELECT * FROM LEBACK_FORM WHERE id='$id'";
	$sql = $conexao->prepare($query);
	if($sql->execute()){
		$consulta = $sql->fetchAll(PDO::FETCH_ASSOC);
		foreach($consulta as $dados){
			$empresa = $dados['empresa'];
			$grupo = $dados['grupo'];
			$cnpj = $dados['cnpj'];
			$nome = $dados['nome'];
			$telefone = $dados['telefone'];
			$email = $dados['email'];
			$aniversario = $dados['aniversario'];
			if($aniversario == '1900-01-01'){
				$aniversario = '';
			}
			$genero = $dados['genero'];
			if($genero == ''){
				$genero = 'Não informado';
			}
			$endereco = $dados['endereco'];
			$cargo = $dados['cargo'];
			$setor = $dados['setor'];
			$participa_clube = $dados['participa_clube'];
			$categoria_interesse = $dados['categoria_interesse'];
			$ciente_parceria = $dados['ciente_parceria'];			
		}
	}
 ?>
	<div class="container">
		<?php if(isset($_SESSION['msg'])){ ?>
			<script type="text/javascript">
				alert("<?= $_SESSION['msg']; ?>");
			</script>
		<?php	unset($_SESSION['msg']);} ?>
		<br>
		<span class="fs-4">Informações do Cliente</span>
		<form action="editarForm.php" method="POST">
			<div class="card rounded-3 shadow-sm">
				<div class="card-body">		
					<div class="row mb-2">			
						<div class="col-sm-3">
							<label for="">Responsavel pelo Ticket<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control-sm" name="empresa" required value="<?= $empresa;?>">
							<select name="responsavel" id="responsavel">
								<option value=""></option>
							</select>
						</div>
						<div class="col-sm-2">
							<label for="">GRUPO</label>
							<input type="text" class="form-control form-control-sm" name="grupo" id="grupo" value="<?= $grupo;?>">
						</div>
						<div class="col-sm-2">
							<label for="">CNPJ<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control-sm" name="cnpj" id="cnpj" required value="<?= $cnpj;?>">
						</div>
						<div class="col-sm-3">
							<label for="">NOME<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control-sm" name="nome" id="nome" required value="<?= $nome;?>">
						</div>
						<div class="col-sm-2">						
							<label>TELEFONE<span class="text-danger">*</span></label>
							<input type="text" class="form-control form-control-sm" name="telefone" id="telefone" required value="<?= $telefone;?>">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-sm-3">						
								<label>E-MAIL<span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-sm" name="email" id="email" required value="<?= $email;?>">						
						</div>						
						<div class="col-sm-2">						
							<label>ANIVERSÁRIO</label>
							<input type="date" class="form-control form-control-sm" name="aniversario" id="aniversario" value="<?= $aniversario;?>">
						</div>
						<div class="col-sm-2">						
							<label>GÊNERO</label>
							<select name="genero" id="genero" class="form-select form-select-sm">
								<option value="Não informado">Não informado</option>
								<option value="Masculino">Masculino</option>
								<option value="Ferminino">Ferminino</option>
							</select>
						</div>
						<div class="col-sm-5">						
							<label>ENDEREÇO</label>
							<input type="text" class="form-control form-control-sm" name="endereco" id="endereco" value="<?= $endereco;?>">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-sm-3">						
							<label>CARGO QUE OCUPA</label>
							<input type="text" class="form-control form-control-sm" name="cargo" id="cargo" value="<?= $cargo;?>">
						</div>
						<div class="col-sm-3">						
							<label>SETOR QUE ATUA</label>
							<input type="text" class="form-control form-control-sm" name="setor" id="setor" value="<?= $setor;?>">
						</div>
						<div class="col-sm-6">						
							<label>PARTICIPA DE OUTRO CLUBE DE VANTAGENS? QUAIS?</label>
							<input type="text" class="form-control form-control-sm" name="participa_clube" id="participa_clube" value="<?= $participa_clube;?>">
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-sm-6">						
							<label>QUAL CATEGORIA DE MAIOR INTERESSE?</label>
							<input type="text" class="form-control form-control-sm" name="categoria_interesse" id="categoria_interesse" value="<?= $categoria_interesse;?>">
						</div>
						<div class="col-sm-6">						
							<label>CIENTE DE QUAL PARCERIA DO LEBACK?</label>
							<input type="text" class="form-control form-control-sm" name="ciente_parceria" id="ciente_parceria" value="<?= $ciente_parceria;?>">
						</div>
					</div>
				</div>				
			</div>
			<br>
			<input type="hidden" name="id" value="<?= $id; ?>">
			<button type="submit" class="btn btn-primary">Salvar</button>			
			<a href="dashboard.php" class="btn btn-secondary">Voltar</a>									
		</form>
		<br>
	</div>
	<script>
		var genero = "<?php echo $genero; ?>";
		document.getElementById("genero").value = genero;
	</script>
<?php include('includes/footer.php');?>