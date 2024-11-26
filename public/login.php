<?php
require_once '../src/services/ApiService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    $apiService = new ApiService();
    $response = $apiService->authenticate($cpf, $senha);

    if ($response && isset($response['token'])) {
        setcookie('jwt_token', $response['token'], time() + (86400 * 7), "/");
    }
}
