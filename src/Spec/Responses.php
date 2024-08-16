<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use ArrayObject;
use Yogarine\OpenAPI\HttpStatusCode;
use Yogarine\OpenAPI\HttpStatusRange;
use Yogarine\OpenAPI\ObjectInterface;

/**
 * A container for the expected responses of an operation.
 *
 * The container maps an HTTP response code to the expected response.
 *
 * The documentation is not necessarily expected to cover all possible HTTP response codes because they may not be known
 * in advance. However, documentation is expected to cover a successful operation response and any known errors.
 *
 * The default MAY be used as a default response object for all HTTP codes that are not covered individually by the
 * Responses Object.
 *
 * The Responses Object MUST contain at least one response code, and if only one response code is provided it SHOULD be
 * the response for a successful operation call.
 *
 * @phpstan-import-type ResponseSpec  from Response
 * @phpstan-import-type ReferenceSpec from Reference
 *
 * @phpstan-type DefaultResponse null|Response|Reference<Response>
 * @phpstan-type StatusResponses array<value-of<HttpStatusCode|HttpStatusRange>, Response|Reference<Response>>
 * @phpstan-type ResponsesSpec   array<'default'|'1XX'|'2XX'|'3XX'|'4XX'|'5XX'|string, ResponseSpec|ReferenceSpec>
 *
 * @template-extends ArrayObject<value-of<HttpStatusCode|HttpStatusRange>, Response|Reference<Response>>
 */
class Responses extends ArrayObject implements ObjectInterface
{
    /**
     * @param  DefaultResponse  $default    The documentation of responses other than the ones declared for specific
     *                                      HTTP response codes. Use this field to cover undeclared responses.
     * @param  StatusResponses  $responses  Any {@see HttpStatusCode HTTP status code} can be used as the array key, but
     *                                      only one key per code, to describe the expected response for that HTTP
     *                                      status code. To define a range of response codes, the array key MAY contain
     *                                      a @see HttpStatusRange}. For example,
     *                                      {@see HttpStatusRange::Successful `2XX`} represents all response codes
     *                                      between `[200-299]`. Only the following range definitions are allowed:
     *                                      {@see HttpStatusRange::Informational `1XX`},
     *                                      {@see HttpStatusRange::Successful `2XX`},
     *                                      {@see HttpStatusRange::Redirection `3XX`},
     *                                      {@see HttpStatusRange::ClientError `4XX`}, and
     *                                      {@see HttpStatusRange::ServerError `5XX`}. If a response is defined using an
     *                                      explicit {@see HttpStatusCode code}, the explicit {@see HttpStatusCode code}
     *                                      definition takes precedence over the {@see HttpStatusRange range} definition
     *                                      for that code.
     */
    public function __construct(public readonly null|Response|Reference $default, array $responses)
    {
        parent::__construct($responses);
    }

    /**
     * @param  ResponsesSpec  $spec
     * @return static
     */
    public static function fromSpec(array $spec): static
    {
        $default = isset($spec['default']) ? Response::fromSpec($spec['default']) : null;
        unset($spec['default']);
        
        return new self($default, static::responsesFromResponsesSpec($spec));
    }

    /**
     * @param  array  $responsesSpec
     * @return StatusResponses
     */
    protected static function responsesFromResponsesSpec(array $responsesSpec): array
    {
        $array = [];
        foreach ($responsesSpec as $code => $responseSpec) {
            $status = is_numeric($code) ? HttpStatusCode::from((int) $code) : HttpStatusRange::from($code);
            $array[$status->value] = Response::fromSpec($responseSpec);
        }

        return $array;
    }
}
