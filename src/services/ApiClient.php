<?php

class ApiClient
{
    private $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function makeAuthenticatedRequest($endpoint, $method = 'GET', $data = [])
    {
        // Recupera o token JWT armazenado no cookie
        if (!isset($_COOKIE['jwt_token']) || empty($_COOKIE['jwt_token'])) {
            echo "Erro: Token JWT não encontrado. Faça login novamente.";
            return "Erro: Token JWT não encontrado. Faça login novamente.";
        }

        $jwtToken = $_COOKIE['jwt_token'];

        // Configuração da URL completa
        $url = rtrim($this->apiUrl, '/') . '/' . ltrim($endpoint, '/');

        // Inicia o cURL
        $ch = curl_init($url);

        // Configurações do cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $jwtToken", // Adiciona o token no cabeçalho
            'Content-Type: application/json', // Define o tipo de conteúdo
            'Expect:' // Adiciona cabeçalho para evitar problemas com grandes corpos de requisição
        ]);

        // Desabilitar a verificação SSL (apenas para desenvolvimento local)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignora o certificado SSL autoassinado

        // Configurações adicionais para métodos POST ou PUT
        if ($method === 'POST' || $method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        // Executa a requisição
        $response = curl_exec($ch);

        // Verifica se houve algum erro no cURL
        if (curl_errno($ch)) {
            echo "Erro cURL: " . curl_error($ch);
            curl_close($ch);
            return null;
        }

        // Obtém o código de status HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Verifica o código de status HTTP
        if ($httpCode != 200) {
            echo "Erro: Status HTTP $httpCode. Requisição falhou.";
            curl_close($ch);
            return null;
        }

        // Fecha a conexão cURL
        curl_close($ch);

        // Verifica se a resposta não está vazia e é JSON
        if ($response) {
            $decodedResponse = json_decode($response, true);

            // Verifica se a resposta foi decodificada corretamente
            if ($decodedResponse === null && json_last_error() !== JSON_ERROR_NONE) {
                echo "Erro: Resposta inválida ou não-JSON.";
                return null;
            }

            return $decodedResponse;
        } else {
            echo "Erro: Resposta vazia.";
            return null;
        }
    }
}
