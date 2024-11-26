<?php
// Função para fazer a requisição à API e obter as contas do cliente
require_once '../src/services/ApiClient.php';


$apiClient = new ApiClient('https://localhost:7266/api/');

$contas = $apiClient->makeAuthenticatedRequest('conta', 'GET');
var_dump($contas);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas do Cliente</title>
</head>

<body>
    <div>
    <h1>Contas do Cliente</h1>
        <?php if (is_array($contas) && !empty($contas)): ?>
            <ul>
                <li>
                    <strong>Conta ID:</strong> <?php echo $contas['contaID']; ?> <br>
                    <strong>Número da Conta:</strong> <?php echo $contas['numeroConta']; ?> <br>
                    <strong>Saldo:</strong> <?php echo $contas['saldo']; ?> <br>
                    <strong>Tipo:</strong> <?php echo $contas['tipo']; ?> <br>

                    <strong>Transações Origem:</strong><br>
                    <?php foreach ($contas['transacoesOrigem'] as $transacao): ?>
                        <ul>
                            <li>Transação ID: <?php echo $transacao['transacaoID']; ?>, Valor: <?php echo $transacao['valor']; ?>, Tipo: <?php echo $transacao['Tipo']; ?></li>
                        </ul>
                    <?php endforeach; ?>

                    <strong>Transações Destino:</strong><br>
                    <?php foreach ($contas['transacoesDestino'] as $transacao): ?>
                        <ul>
                            <li>Transação ID: <?php echo $transacao['transacaoID']; ?>, Valor: <?php echo $transacao['valor']; ?>, Tipo: <?php echo $transacao['Tipo']; ?></li>
                        </ul>
                    <?php endforeach; ?>
                </li>
                <hr>
            </ul>
        <?php else: ?>
            <p>Não foram encontradas contas para este cliente.</p>
        <?php endif; ?>
    </div>
    <div>
    <h1>Criar Conta para Cliente</h1>

<!-- Formulário para criar conta -->
    <form action="../src/controllers/criarConta.php" method="POST">
        <label for="numero_conta">Número da Conta:</label><br>
        <input type="text" id="numero_conta" name="numero_conta" required><br><br>

        <label for="saldo">Saldo Inicial:</label><br>
        <input type="number" id="saldo" name="saldo" required><br><br>

        <label for="tipo">Tipo de Conta:</label><br>
        <select id="tipo" name="tipo" required>
            <option value="Corrente">Corrente</option>
            <option value="Poupança">Poupança</option>
        </select><br><br>

        <button type="submit">Criar Conta</button>
    </form>
    </div>
</body>
</html>
