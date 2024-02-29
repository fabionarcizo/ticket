<?php 
	include('includes/header.php');
	include('includes/conexao.php');
	include('includes/funcao.php');
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_GET['s']) AND $_GET['s'] == 1){
		var_dump($_SESSION);
	}
	
	$link = 'logout.php';
	verifica_online($link);

	if($_SESSION['setor'] == '1'){
		include('dashboard/ti.php'); 	
	}else{
		include('dashboard/colaborador.php');
	}
	include('includes/footer.php');