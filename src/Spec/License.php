<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;

/**
 * License information for the exposed API.
 *
 * @phpstan-type LicenseSpec array{
 *                               name:       string,
 *                               identifier: ?string,
 *                               url:        string,
 *                           }
 */
readonly class License implements ObjectInterface
{
    /**
     * @param  string                                      $name        The license name used for the API.
     * @param  ($url        is null ? string|null : null)  $identifier  An {@link https://spdx.org/licenses/ SPDX}
     *                                                                  license expression for the API.
     * @param  ($identifier is null ? string|null : null)  $url         A URL to the license used for the API.
     */
    public function __construct(
        public string $name,
        public string|null $identifier,
        public string|null $url,
    ) {}

    /**
     * @param  LicenseSpec  $spec
     * @return static
     */
    public static function fromSpec(array $spec): static
    {
        return new self(
            $spec['name'],
            $spec['identifier'] ?? null,
            $spec['url'],
        );
    }
}
