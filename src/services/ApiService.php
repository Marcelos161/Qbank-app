<?php
class ApiService {
    private $apiUrl;

    public function __construct() {
        $this->apiUrl = "https://qbankapi-exa7gtbachcrh5d8.brazilsouth-01.azurewebsites.net/api/auth"; // Substitua pelo URL da API
    }

    public function authenticate($cpf, $senha) {
        $data = [
            'cpf' => $cpf,
            'senha' => $senha
        ];

        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($this->apiUrl, false, $context);

        if ($result === FALSE) {
            return json_decode($result, true);
        }

        return json_decode($result, true);
    }
}
