<?php 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


class CustomCorsMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // Verifique se é uma solicitação de opções
        if ($request->getMethod() === 'OPTIONS') {
            return $this->handlePreflightRequest($request);
        }

        // Adicione os cabeçalhos CORS à resposta
        $response = $handler->handle($request);
        return $this->addCorsHeaders($response);
    }

    private function handlePreflightRequest(Request $request): Response
    {
        // Crie uma resposta vazia para a solicitação de opções
        return new Response();
    }

    private function addCorsHeaders(Response $response): Response
    {
        // Adicione os cabeçalhos CORS à resposta
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }
}