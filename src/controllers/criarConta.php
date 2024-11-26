<?php
// Inclua a classe ApiClient
include '../services/ApiClient.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $numeroConta = $_POST['numero_conta'];
    $saldo = $_POST['saldo'];
    $tipo = $_POST['tipo'];

    // Dados para a criação da conta
    $data = [
        'NumeroConta' => $numeroConta,
        'Saldo' => $saldo,
        'Tipo' => $tipo,
    ];

    $apiClient = new ApiClient('https://localhost:7266/api/');

    // Envia a requisição para a API para criar a conta
    $response = $apiClient->makeAuthenticatedRequest('conta', 'POST', $data);

    return $response;
}