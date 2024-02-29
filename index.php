<?php
if(!isset($_SESSION)){
  session_start();
}
include('includes/conexao.php');


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <!-- Biblioteca DataTables -->
  <link rel="stylesheet" type="text/css" href="assets/dataTables/dataTables.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <script src="assets/dataTables/dataTables.js"></script>
  <!-- Font awesome DataTables -->  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="assets/css/login.css" rel="stylesheet">
  <title>LEADER SOLUÇÕES</title>
</head>


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="assets/css/login.css" rel="stylesheet">
  </head>
  <body class="bg-light">
  <?php 
    $form = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    if(!empty($form['SendLogin'])){
      $query = "SELECT TOP 1 * FROM USUARIOS_PHP WHERE usuario = :usuario AND acesso_ticket = '1' ORDER BY id_user ASC";
      $sql = $conexao->prepare($query);
      $sql->bindParam(':usuario', $form['usuario'], PDO::PARAM_STR );
      $sql->execute();

      if(($sql) AND ($sql->rowCount() !=0)){
        $dados = $sql->fetch(PDO::FETCH_ASSOC);        
        
        if($form['senha'] == $dados['senha']){
                    
          $_SESSION['id_user'] = $dados['id_user'];
          $_SESSION['nome'] = $dados['nome'];
          $_SESSION['sobrenome'] = $dados['sobrenome'];
          $_SESSION['perfil'] = $dados['perfil'];          
          $_SESSION['admin'] = $dados['admin'];
          $_SESSION['nome_usuario'] = $dados['nome_usuario'];
          $_SESSION['cod_funcionario'] = $dados['cod_funcionario'];
          $_SESSION['setor'] = $dados['setor'];
          $_SESSION['online'] = 1;

          header("Location: dashboard.php");
        }else{
          $_SESSION['msg'] = "<p style='color: #ff0000; font-weight: bold;'>Erro: Usuário ou senha inválida!</p>";
        }
      }else{
        $_SESSION['msg'] = "<p style='color: #ff0000; font-weight: bold;'>Erro: Usuário ou senha inválida!</p>";
      }
    }
  ?> 
  <main class="form-signin">
  <form action="" method="POST" autocomplete="off">        
    <div class="row" align="center">
      <div class="col-sm-12">
        <img class="" src="assets/img/logo.png" alt="" width="" height="110">        
      </div>      
      <div class="col-sm-12 mt-2"><span class="text-primary fs-4">..::&nbsp;&nbsp;&nbsp;TICKET&nbsp;&nbsp;&nbsp;::..</span></div>
    </div>
    <br>
    <div class="form-floating">        
      <input type="text" class="form-control" name="usuario" id="floatingInput" placeholder="Usuário" autocomplete="on" value="<?php if(isset($form['usuario'])){ echo $form['usuario']; } ?>">
      <label for="floatingInput">Usuário</label>
    </div>
    <br>
    <div class="form-floating">
      <input type="password" class="form-control" name="senha" id="floatingPassword" placeholder="Senha" value="<?php if(isset($form['senha'])){ echo $form['senha']; } ?>">
      <label for="floatingPassword">Senha</label>
    </div>
    <br>      
    <button class="w-100 btn btn-lg btn-outline-primary" value="Enviar" name="SendLogin" type="submit">Entrar</button> 
    <br>
    <br>
    <div align="center">
    <?php 
      if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
      }
    ?>
    </div>  
    </form>
  </main>    
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
