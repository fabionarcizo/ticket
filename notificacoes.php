<?php
// Este script pode ser chamado quando uma atividade específica ocorrer no sistema
// Por exemplo, quando uma mensagem é enviada para o usuário

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'usuario', 'senha', 'nome_do_banco_de_dados');

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Insere a notificação no banco de dados
$mensagem = "Você recebeu uma nova mensagem.";
$usuario_id = 1; // ID do usuário para quem a mensagem foi enviada
$sql = "INSERT INTO notificacoes (mensagem, usuario_id) VALUES ('$mensagem', $usuario_id)";

if ($conn->query($sql) === TRUE) {
    echo "Notificação inserida com sucesso.";
} else {
    echo "Erro ao inserir notificação: " . $conn->error;
}

$conn->close();
?>
<?php
// Este script pode ser chamado para recuperar as notificações não lidas do banco de dados para o usuário logado

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'usuario', 'senha', 'nome_do_banco_de_dados');

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$usuario_id = 1; // ID do usuário logado
$sql = "SELECT * FROM notificacoes WHERE usuario_id = $usuario_id AND status = 'nao_lido'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Exibe as notificações
    while($row = $result->fetch_assoc()) {
        echo $row["mensagem"];
    }
} else {
    echo "Não há notificações não lidas.";
}

$conn->close();
?>
<div id="notificacoes">
    <!-- Aqui serão exibidas as notificações -->
</div>
<script>
$(document).ready(function(){
    function carregarNotificacoes() {
        $.ajax({
            url: 'recuperar_notificacoes.php',
            type: 'GET',
            success: function(response) {
                // Exibe as notificações na navbar
                $('#notificacoes').html(response);
            }
        });
    }

    // Chama a função para carregar as notificações quando a página é carregada
    carregarNotificacoes();

    // Chama a função para carregar as notificações a cada 30 segundos
    setInterval(carregarNotificacoes, 30000);
});
</script>