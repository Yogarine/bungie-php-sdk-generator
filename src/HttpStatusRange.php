<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI;

enum HttpStatusRange: string
{
    case Informational = '1XX';
    case Successful    = '2XX';
    case Redirection   = '3XX';
    case ClientError   = '4XX';
    case ServerError   = '5XX';
}
