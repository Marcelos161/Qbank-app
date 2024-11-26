<?php
require_once '../src/services/ApiClient.php';


$apiClient = new ApiClient('https://localhost:7266/api/');

$response = $apiClient->makeAuthenticatedRequest('conta', 'GET');

var_dump($response);
