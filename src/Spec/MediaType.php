<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\JsonSchema\Schema;
use Yogarine\OpenAPI\ObjectInterface;

/**
 * @phpstan-import-type SchemaSpec    from Schema
 * @phpstan-import-type ReferenceSpec from Reference
 * @phpstan-import-type EncodingSpec  from Encoding
 *
 * @phpstan-type MediaTypeSpec array{
 *                                 schema:    SchemaSpec,
 *                                 example?:  mixed,
 *                                 examples?: array<string, mixed|ReferenceSpec>,
 *                                 encoding?: array<string, EncodingSpec>,
 *                             }
 *
 * Provides schema and examples for a media type.
 */
readonly class MediaType implements ObjectInterface
{
    /**
     * @param  Schema                                      $schema    The schema defining the content of the request,
     *                                                                response, or parameter.
     * @param  mixed                                       $example   Example of the media type.
     * @param  array<string, mixed|Reference<mixed>>|null  $examples  Examples of the media type.
     * @param  array<string, Encoding>|null                $encoding  A map between a property name and its encoding
     *                                                                information.
     */
    public function __construct(
        public Schema $schema,
        public mixed $example = null,
        public ?array $examples = null,
        public ?array $encoding = null,
    ) {}

    /**
     * @param  MediaTypeSpec  $spec
     * @return static
     */
    public static function fromSpec(array $spec): static
    {
        return new self(
            Schema::fromSpec($spec['schema']),
            $spec['example'] ?? null,
            $spec['examples'] ?? null,
            $spec['encoding'] ?? null,
        );
    }
}
