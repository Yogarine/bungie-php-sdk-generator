<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use JsonException;
use Yogarine\OpenAPI\ObjectInterface;

/**
 * This class in reality only represents a subset of the OpenAPI specification, as used by the Bungie API.
 *
 * It also exposes several extensions to the OpenAPI specification, such as the ability to declare descriptions for
 * integer backed enums.
 *
 * @phpstan-import-type InfoSpec                  from Info
 * @phpstan-import-type ServerSpec                from Server
 * @phpstan-import-type PathItemSpec              from PathItem
 * @phpstan-import-type ComponentsSpec            from Components
 * @phpstan-import-type TagSpec                   from Tag
 * @phpstan-import-type ExternalDocumentationSpec from ExternalDocumentation
 * @phpstan-import-type ReferenceSpec             from Reference
 *
 * @phpstan-type OpenApiSpec array{
 *                               openapi:      string,
 *                               info:         InfoSpec,
 *                               servers:      ServerSpec[],
 *                               paths:        array<string, PathItemSpec|ReferenceSpec>,
 *                               components:   ComponentsSpec,
 *                               tags:         TagSpec[],
 *                               externalDocs: ExternalDocumentationSpec,
 *                           }
 */
readonly class OpenApi implements ObjectInterface
{
    /**
     * @param  string        $openapi
     * @param  Info          $info
     * @param  Server[]      $servers
     * @param  Paths         $paths
     * @param  Components    $components
     * @param  Tag[]         $tags
     * @param  ExternalDocumentation  $externalDocs
     */
    public function __construct(
        public string                $openapi,
        public Info                  $info,
        public array                 $servers,
        public Paths                 $paths,
        public Components            $components,
        public array                 $tags,
        public ExternalDocumentation $externalDocs,
    ) {}

    /**
     * @param  OpenApiSpec  $spec
     * @return static
     *
     * @throws JsonException
     */
    public static function fromSpec(array $spec): static
    {
        return new self(
            $spec['openapi'],
            Info::fromSpec($spec['info']),
            Server::fromSpecs($spec['servers'] ?? []),
            Paths::fromSpec($spec['paths']),
            Components::fromSpec($spec['components']),
            array_map(fn(array $tag) => Tag::fromSpec($tag), $spec['tags']),
            ExternalDocumentation::fromSpec($spec['externalDocs']),
        );
    }
}
