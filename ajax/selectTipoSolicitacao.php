<?php 
//error_reporting(0);
include('../includes/conexao.php');
include('../includes/funcao.php');

if(isset($_POST['id_categoria'])){
    $id_categoria = $_POST['id_categoria'];
    $id_tipo_solicitacao_form = $_POST['id_tipo_solicitacao'];
    //$id_categoria = $_GET['id_categoria'];
    $query = "SELECT * from SOLICITACOES_TIPOS WHERE id_categoria = '$id_categoria'";
    $sql = $conexao->prepare($query);
    try{    
        if($sql->execute()){
            if($id_categoria == ''){
                echo '<option value=""></option>';
            }else{
                echo '<option value="">Selecione o tipo de solicitação...</option>';
            }            
            $consulta = $sql->fetchAll(PDO::FETCH_ASSOC);        
            foreach($consulta as $dados){
            $option = '';
            $id_tipo_solicitacao = $dados['id_tipo_solicitacao'];        
            $tipo_solicitacao = $dados['tipo_solicitacao'];
            if($id_tipo_solicitacao_form == $id_tipo_solicitacao){
                $option = '<option value = "'.$id_tipo_solicitacao.'" selected >'.$tipo_solicitacao.'</option>';
            }else{
                $option = '<option value = "'.$id_tipo_solicitacao.'">'.$tipo_solicitacao.'</option>';            
            }   
            
            echo $option;       
            }  
        }
    }catch(Exception $mensagem){
        $mensagem = $sql->errorInfo();
        $mensagem = $mensagem[2];
        $option =  '<option> '.$mensagem.' </option>';
        $option =  '<option>Erro ao consultar banco de dados!</option>';
        echo $option;
    }      

}else{
    $mensagem = "Falha ao carregar lista!";
    $option =  '<option> '.$mensagem.' </option>';
    echo $option;
}//Fim isset
?>