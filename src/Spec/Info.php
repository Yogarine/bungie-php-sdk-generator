<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Spec;

use Yogarine\OpenAPI\ObjectInterface;

/**
 * The Info object Provides metadata about the API.
 *
 * The metadata MAY be used by the clients if needed, and MAY be presented in
 * editing or documentation generation tools for convenience.
 *
 * @phpstan-import-type ContactSpec from Contact
 * @phpstan-import-type LicenseSpec from License
 *
 * @phpstan-type InfoSpec array{
 *                            title:           string,
 *                            summary?:        string,
 *                            description?:    string,
 *                            termsOfService?: string,
 *                            contact?:        ContactSpec,
 *                            license?:        LicenseSpec,
 *                            version:         string,
 *                        }
 */
readonly class Info implements ObjectInterface
{
    /**
     * @param  string       $title           The title of the API.
     * @param  string       $version         The version of the OpenAPI document.
     * @param  string|null  $summary         A short summary of the API.
     * @param  string|null  $description     A description of the API.
     * @param  string|null  $termsOfService  A URL to the Terms of Service for the API.
     * @param  Contact|null $contact         The contact information for the exposed API.
     * @param  License|null $license         The license information for the exposed API.
     */
    public function __construct(
        public string   $title,
        public string   $version,
        public ?string  $summary = null,
        public ?string  $description = null,
        public ?string  $termsOfService = null,
        public ?Contact $contact = null,
        public ?License $license = null,
    ) {}

    /**
     * @param InfoSpec $spec
     * @return static
     */
    public static function fromSpec(array $spec): static
    {
        return new self(
            $spec['title'],
            $spec['version'],
            $spec['summary']        ?? null,
            $spec['description']    ?? null,
            $spec['termsOfService'] ?? null,
            $spec['contact'] ? Contact::fromSpec($spec['contact']) : null,
            $spec['license'] ? License::fromSpec($spec['license']) : null,
        );
    }
}
