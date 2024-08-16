<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;
use Yogarine\OpenAPI\Referable;

/**
 * Describes a single response from an API Operation, including design-time,
 * static links to operations based on the response.
 *
 * @phpstan-type ResponseSpec array{
 *                                description: string,
 *                                headers?:    array<string, HeaderSpec|Reference<Header>>,
 *                                content?:    array<string, MediaTypeSpec>,
 *                                links?:      array<string, LinkSpec|Reference<Link>>,
 *                            }
 */
readonly class Response implements ObjectInterface
{
    use Referable;

    /**
     * @param  string                                        $description  A description of the response.
     * @param  array<string, Header|Reference<Header>>|null  $headers      Maps a header name to its definition.
     * @param  array<string, MediaType>|null                 $content      A map containing descriptions of potential
     *                                                                     response payloads.
     * @param  array<string, Link|Reference<Link>>|null      $links        A map of operations links that can be
     *                                                                     followed from the response.
     */
    public function __construct(
        public string $description,
        public ?array $headers = null,
        public ?array $content = null,
        public ?array $links   = null,
    ) {}

    /**
     * @param  ResponseSpec  $spec
     * @return Response|Reference<static>
     */
    public static function fromSpec(array $spec): Response|Reference
    {
        return self::tryFromReferenceSpec($spec) ?? new Response(
            description: $spec['description'],
            headers:     Header::fromSpecArray($spec['headers'] ?? null),
            content:     MediaType::fromSpecArray($spec['content'] ?? null),
            links:       Link::fromSpecArray($spec['links'] ?? null),
        );
    }
}
