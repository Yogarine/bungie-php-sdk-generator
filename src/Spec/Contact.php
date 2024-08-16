<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;

/**
 * Contact information for the exposed API.
 *
 * @phpstan-type ContactSpec array{
 *                               name:  string,
 *                               url:   string,
 *                               email: string,
 *                           }
 *
 * @extends ObjectInterface<self>
 */
readonly class Contact implements ObjectInterface
{
    /**
     * @param  string|null  $name   The identifying name of the contact person/organization.
     * @param  string|null  $url    The URL pointing to the contact information.
     * @param  string|null  $email  The email address of the contact person/organization.
     */
    public function __construct(
        public ?string $name  = null,
        public ?string $url   = null,
        public ?string $email = null,
    ) {}

    /**
     * @param  ContactSpec  $spec
     * @return self
     */
    public static function fromSpec(array $spec): self
    {
        return new self(
            name:  $spec['name'],
            url:   $spec['url'],
            email: $spec['email'],
        );
    }
}
