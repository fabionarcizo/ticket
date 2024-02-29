<?php 
	function sql($conexao, $query, $tipo){
		$sql = $conexao->prepare($query);
		if($tipo == 'select'){
			try{
				if($sql->execute()){
					$consulta = $sql->fetchAll(PDO::FETCH_ASSOC);
					return $consulta;            
				}
			}catch(Exception $e){
				return $e;
			}
		}
		if($tipo == 'insert'){
			try{
			if($sql->execute()){            
				$resultado = 1;        
				return $resultado;
			}
			}catch(Exception $e){
			return $e;
			}
		}
		#INSTRUÇÕES DE USO
		//Atribuir retorno da função a uma variavel
		/*$insert = sql($conexao, $query, 'insert');
		if(gettype($insert) != 'object'){
			//Se não for objeto é pq ocorreu tudo bem   
		}else{
			//Se for objeto é pq retornou uma mensagem de erro do try/catch
			$mensagem =  $insert->getMessage();
		}   */     
	}

	function verifica_area_ti($conexao, $id_tipo_solicitacao){
		$query = "SELECT area_ti FROM SOLICITACOES_TIPOS WHERE id_tipo_solicitacao = '$id_tipo_solicitacao'";
		$sql = $conexao->prepare($query);
		if($sql->execute()){			
			$consulta = $sql->fetchAll(PDO::FETCH_ASSOC);
			if(count($consulta) > 0){
				foreach($consulta as $dados){
					$area_ti = $dados['area_ti'];
				}
			}else{
				$area_ti = 0;	
			}			
		}else{
			$area_ti = 0;
		}
		return $area_ti;
	}

	function redirect($link){
		echo '<script>window.location.href = "'.$link.'";</script>';
	}
	
	function verifica_online($link){		
		if(!isset($_SESSION['online']) and $_SESSION['online'] != 1){	
			redirect($link);
		}
	}
	function alert($mensagem, $tipo){
		echo '<script>alert("'.$tipo.' '.$mensagem.'");</script>';
	}

	function datahorabr($data){
		$data = date('d/m/Y H:m:s', strtotime($data));
	  
		return($data);
	}

	function databr($data){
		if($data == '' or is_null($data)){
			return($data);	
		}else{		
			$data = date('d/m/Y', strtotime($data));	  
			return($data);
		}
	}

	function hora_min($hora){
		$hora = substr($hora, 0, 4);
	}

	function selectSetor($conexao){    
    $query = "SELECT * from USUARIOS_PHP_SETORES WHERE status = '1' order by setor asc";
    $sql = $conexao->prepare($query);
    if($sql->execute()){
        $consulta = $sql->fetchAll(PDO::FETCH_ASSOC);        
        foreach($consulta as $dados){
          $option = '';
          $id_setor = $dados['id_setor'];        
          $setor = $dados['setor'];            
          $option = '<option value = "'.$id_setor.'">'.$setor.'</option>';            
          echo $option;       
        }  
    }else{
        $mensagem = $sql->errorInfo();
				$mensagem = $mensagem[2];
				$option =  '<option> '.$mensagem.' </option>';
				$option =  '<option>Erro ao consultar banco de dados!</option>';
				echo $option;
    }      
	}

	function selectCliente($conexao){    
    $query = "SELECT * from CLIENTE_CREDOR WHERE IND_SITUACAO_CREDOR = 'A' order by RAZAO_SOCIAL_CREDOR asc";
    $sql = $conexao->prepare($query);
    if($sql->execute()){
        $consulta = $sql->fetchAll(PDO::FETCH_ASSOC);        
        foreach($consulta as $dados){
          $option = '';
          $cod_cliente_credor = trim($dados['COD_CLIENTE_CREDOR']);        
          $razao_social = trim($dados['RAZAO_SOCIAL_CREDOR']);            
          $option = '<option value = "'.$cod_cliente_credor.'">'.$razao_social.'</option>';            
          echo $option;       
        }  
    }else{
        $mensagem = $sql->errorInfo();
				$mensagem = $mensagem[2];
				$option =  '<option> '.$mensagem.' </option>';
				$option =  '<option>Erro ao consultar banco de dados!</option>';
				echo $option;
    }      
	}

	function selectResponsavel($conexao){    
    $query = "SELECT * from USUARIOS_PHP WHERE status = '1' AND setor = '1'  order by nome asc";
    $sql = $conexao->prepare($query);
    if($sql->execute()){
        $consulta = $sql->fetchAll(PDO::FETCH_ASSOC);        
        foreach($consulta as $dados){
          $option = '';
          $id_user = trim($dados['id_user']);        
          $nome = $dados['nome'].' '.$dados['sobrenome'];            
          $option = '<option value = "'.$id_user.'">'.$nome.'</option>';            
          echo $option;       
        }  
    }else{
        $mensagem = $sql->errorInfo();
				$mensagem = $mensagem[2];
				$option =  '<option> '.$mensagem.' </option>';
				$option =  '<option>Erro ao consultar banco de dados!</option>';
				echo $option;
    }      
	}

	function selectCategoria($conexao){    
    $query = "SELECT * from SOLICITACOES_CATEGORIAS WHERE status = '1'";
    $sql = $conexao->prepare($query);
    if($sql->execute()){
        $consulta = $sql->fetchAll(PDO::FETCH_ASSOC);        
        foreach($consulta as $dados){
          $option = '';
          $id_categoria = $dados['id_categoria'];        
          $categoria = $dados['categoria'];            
          $option = '<option value = "'.$id_categoria.'">'.$categoria.'</option>';            
          echo $option;       
        }  
    }else{
        $mensagem = $sql->errorInfo();
				$mensagem = $mensagem[2];
				$option =  '<option> '.$mensagem.' </option>';
				$option =  '<option>Erro ao consultar banco de dados!</option>';
				echo $option;
    }      
	}

	function selectTipoSolicitacao($conexao){    
    $query = "SELECT * from SOLICITACOES_TIPOS WHERE status = '1'";
    $sql = $conexao->prepare($query);
    if($sql->execute()){
        $consulta = $sql->fetchAll(PDO::FETCH_ASSOC);        
        foreach($consulta as $dados){
          $option = '';
          $id_tipo_solicitacao = $dados['id_tipo_solicitacao'];        
          $tipo_solicitacao = $dados['tipo_solicitacao'];            
          $option = '<option value = "'.$id_tipo_solicitacao.'">'.$tipo_solicitacao.'</option>';            
          echo $option;       
        }  
    }else{
        $mensagem = $sql->errorInfo();
				$mensagem = $mensagem[2];
				$option =  '<option> '.$mensagem.' </option>';
				$option =  '<option>Erro ao consultar banco de dados!</option>';
				echo $option;
    }      
	}

	function textoSetor($conexao, $id_setor){
		$query = "SELECT setor FROM USUARIOS_PHP_SETORES WHERE id_setor = '$id_setor'";
		$sql = $conexao->prepare($query);
		if($sql->execute()){
			$consulta = $sql->fetchAll(PDO::FETCH_ASSOC);
			if($consulta > 0){
				foreach($consulta as $dados){
					$setor = $dados['setor'];
				}			
			}else{
				$setor = "Setor não encontrado!";
			}			
		}else{
			$setor = "Erro ao consultar setor!";
		}
		return $setor;
	}

	function virgula($valor){
		if(!empty($valor) or !is_null($valor) or $valor !=''){
			$valor = str_replace(".", ",", $valor);
			return $valor;
		}  
		
	}
	function ponto($valor){
		if(!empty($valor) or !is_null($valor) or $valor !=''){
			$valor = str_replace(",", ".", $valor);
			return $valor;
		}  
		
	}
	