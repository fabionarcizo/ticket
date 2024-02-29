<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/x-icon" href="assets/img/icon.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="assets/js/jquery-3.6.0.min.js"></script>
	<!-- Char JS -->
	<script src="assets/ChartJS/chart.js"></script>
  <!-- Biblioteca DataTables -->
  <link rel="stylesheet" type="text/css" href="assets/dataTables/dataTables.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <script src="assets/dataTables/dataTables.js"></script>	
  <!-- Font awesome DataTables -->  
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>TICKET - LEADER SOLUÇÕES</title>
</head>
<body class="bg-light">
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#"><img src="assets/img/icon.png" height="25"></a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarNav">
	      <ul class="navbar-nav">
	        <li class="nav-item">
	          <a class="nav-link text-primary" href="dashboard.php">Dashboard</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link text-primary" href="novaSolicitacao.php">Nova Solicitação</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link text-primary" href="consultar.php">Consultar Ticket</a>
	        </li>	        
	      </ul>
	    </div>
	    <?php if(!isset($_SESSION)){ session_start();} ?>   
	    <span><i class="fa fa-user-circle-o"></i> <?php echo $_SESSION['nome'].' '.$_SESSION['sobrenome'];?></span>&nbsp;&nbsp;
	    <a class="btn btn-sm btn-primary" href="logout.php">Sair&nbsp;<i class="fa fa-sign-out"></i></a>
	  </div>	  
	</nav>