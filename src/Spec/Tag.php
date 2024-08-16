<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;

/**
 * Adds metadata to a single tag that is used by the {@see Operation Operation Object}.
 *
 * It is not mandatory to have a Tag Object per tag defined in the Operation Object instances.
 * 
 * @phpstan-import-type ExternalDocumentationSpec from ExternalDocumentation
 * 
 * @phpstan-type TagSpec array{
 *                           name:        string,
 *                           description: string,
 *                           externalDocs: ExternalDocumentationSpec,
 *                       }
 */
readonly class Tag implements ObjectInterface
{
    /**
     * @param  string                      $name          The name of the tag.
     * @param  string|null                 $description   A description for the tag.
     * @param  ExternalDocumentation|null  $externalDocs  Additional external documentation for this tag.
     */
    public function __construct(
        public string                     $name,
        public string|null                $description = null,
        public ExternalDocumentation|null $externalDocs = null,
    ) {}

    /**
     * @param  array  $spec
     * @return self
     */
    public static function fromSpec(array $spec): self
    {
        return new self(
            name:         $spec['name'],
            description:  $spec['description'] ?? null,
            externalDocs: ExternalDocumentation::fromSpec($spec['externalDocs'] ?? []),
        );
    }
}