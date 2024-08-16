<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;

/**
 * An object representing a Server.
 *
 * @phpstan-import-type ServerVariableSpec from ServerVariable
 *
 * @phpstan-type ServerSpec array{
 *                              url:         string,
 *                              description: string,
 *                              variables?:  array<string, ServerVariableSpec>,
 *                          }
 */
readonly class Server implements ObjectInterface
{
    /**
     * @param  string                              $url          A URL to the target host. This URL supports Server
     *                                                           Variables and MAY be relative, to indicate that the
     *                                                           host location is relative to the location where the
     *                                                           OpenAPI document is being served. Variable
     *                                                           substitutions will be made when a variable is named in
     *                                                           `{`brackets`}`.
     * @param  string|null                         $description  An optional string describing the host designated by
     *                                                           the URL.
     *                                                           {@link https://spec.commonmark.org/ CommonMark syntax}
     *                                                           MAY be used for rich text representation.
     * @param  array<string, ServerVariable>|null  $variables    A map between a variable name and its value. The value
     *                                                           is used for substitution in the server's URL template.
     */
    public function __construct(
        public string   $url,
        public ?string  $description = null,
        public ?array   $variables   = null,
    ) {}

    /**
     * @param  ServerSpec[]  $specs
     * @return static[]
     */
    public static function fromSpecs(array $specs): array
    {
        return array_map(static fn (array $spec): Server => self::fromSpec($spec), $specs);
    }

    /**
     * @param  ServerSpec  $spec
     * @return static
     */
    public static function fromSpec(array $spec): static
    {
        return new self(
            $spec['url'],
            $spec['description'],
            isset($spec['variables']) ? array_map(
                static fn (array $serverVariableSpec) => ServerVariable::fromSpec($serverVariableSpec),
                $spec['variables']
            ) : null,
        );
    }
}
