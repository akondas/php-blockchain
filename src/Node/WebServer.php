<?php

declare(strict_types=1);

namespace Blockchain\Node;

use Blockchain\Node;
use Blockchain\Node\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

final class WebServer
{
    /**
     * @var Node
     */
    private $node;

    public function __construct(Node $node)
    {
        $this->node = $node;
    }

    public function __invoke(ServerRequestInterface $request): Response
    {
        switch ($request->getMethod().':'.trim($request->getUri()->getPath(), '/')) {
            case 'GET:blocks':
                return new JsonResponse($this->node->blocks());
            case 'POST:mine':
                return new JsonResponse($this->node->mineBlock($request->getBody()->getContents()));
            case 'GET:peers':
                return new JsonResponse($this->node->peers());
            case 'POST:peers/add':
                $data = json_decode($request->getBody()->getContents(), true);
                $this->node->addPeer(new Peer($data['host'], $data['port']));

                return new Response(204);
            default:
                return new Response(404);
        }
    }
}
