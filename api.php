<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input'); // Recebe os dados em JSON do corpo da requisição
    $dadosFazendas = json_decode($json, true); // Decodifica o JSON para um array associativo

    // Obtém o IP do servidor que enviou a requisição
    $ipRemetente = $_SERVER['REMOTE_ADDR'];

    // Verifica se os dados foram decodificados corretamente
    if (is_array($dadosFazendas)) {
        $arquivo =  $_SERVER['DOCUMENT_ROOT'] . '/servers/'.$ipRemetente . '.json'; // Nome do arquivo baseado no IP

        // Lê os dados existentes no arquivo JSON, se houver
        $dadosExistentes = [];
        if (file_exists($arquivo)) {
            $conteudoExistente = file_get_contents($arquivo);
            $dadosExistentes = json_decode($conteudoExistente, true) ?? [];
        }

        // Adiciona os novos dados ao array existente
        $dadosAtualizados = array_merge($dadosExistentes, $dadosFazendas);

        // Grava os dados atualizados no arquivo JSON
        file_put_contents($arquivo, json_encode($dadosAtualizados, JSON_PRETTY_PRINT));

        echo "Dados recebidos e salvos com sucesso no arquivo: $arquivo";
    } else {
        http_response_code(400); // Resposta com código HTTP 400 (Bad Request)
        echo "Erro: Dados inválidos recebidos!";
    }
} else {
    http_response_code(405); // Resposta com código HTTP 405 (Method Not Allowed)
    echo "Método não permitido! Use POST.";
}
