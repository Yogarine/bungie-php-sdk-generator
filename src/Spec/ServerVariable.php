<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;

/**
 * An object representing a Server Variable for server URL template substitution.
 *
 * @phpstan-type ServerVariableSpec array{
 *                                      default:      string,
 *                                      enum?:        string[],
 *                                      description?: string,
 *                                  }
 */
readonly class ServerVariable implements ObjectInterface
{
    /**
     * @param  string       $default      The default value to use for substitution, which SHALL be sent if an alternate
     *                                    value is not supplied. Note this behavior is different from the Schema
     *                                    Object's treatment of default values, because in those cases parameter values
     *                                    are optional. If the enum is defined, the value MUST exist in the enum's
     *                                    values.
     * @param  string|null  $description  An optional description for the server variable.
     *                                    {@link https://spec.commonmark.org/ CommonMark} syntax MAY be used for rich
     *                                    text representation.
     * @param  string[]     $enum         An enumeration of string values to be used if the substitution options are
     *                                    from a limited set.
     */
    public function __construct(
        public string   $default,
        public ?string  $description = null,
        public ?array   $enum = null,
    ) {}

    /**
     * @param  ServerVariableSpec  $spec
     * @return static
     */
    public static function fromSpec(array $spec): static
    {
        return new self(
            $spec['default'],
            $spec['description'] ?? null,
            $spec['enum'] ?? null,
        );
    }
}
