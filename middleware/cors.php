<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

return function (Request $request, RequestHandlerInterface $handler) {
    $response = $handler->handle($request);

    // Adiciona os cabeçalhos CORS
    $response = $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', '*')
        ->withHeader('Access-Control-Allow-Methods', '*');

    // Verifica se a requisição é uma requisição de opções (preflight)
    if ($request->getMethod() === 'OPTIONS') {
        return $response->withStatus(200);
    }

    return $response;
};