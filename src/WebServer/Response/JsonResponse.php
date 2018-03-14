<?php

declare(strict_types=1);

namespace Blockchain\WebServer\Response;

use Blockchain\WebServer\Response;
use React\Http\Response as HttpResponse;

final class JsonResponse extends HttpResponse implements Response
{
    /**
     * @param mixed $data
     */
    public function __construct($data)
    {
        parent::__construct(200, ['Content-Type' => 'application/json'], json_encode($data));
    }
}
