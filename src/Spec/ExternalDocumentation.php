<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;

/**
 * Allows referencing an external resource for extended documentation.
 * 
 * @phpstan-type ExternalDocumentationSpec array{url: string, description?: string}
 *
 * @extends ObjectInterface<self>
 */
class ExternalDocumentation implements ObjectInterface
{
    /**
     * @param  string       $url          The URL for the target documentation.
     * @param  string|null  $description  A description of the target documentation.
     */
    public function __construct(
        public string      $url,
        public string|null $description = null,
    ) {}

    /**
     * @param  ExternalDocumentationSpec  $spec
     * @return self
     */
    public static function fromSpec(array $spec): self
    {
        return new self(
            url:         $spec['url'],
            description: $spec['description'] ?? null,
        );
    }
}
