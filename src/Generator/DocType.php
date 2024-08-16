<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Generator;

/**
 * @phpstan-import-type EnumSchema from SchemaGen
 * @phpstan-import-type EnumReference from SchemaGen
 * @phpstan-import-type ArraySchema from SchemaGen
 * @phpstan-import-type ObjectLiteralSchema from SchemaGen
 * @phpstan-import-type CompositeObjectSchema from SchemaGen
 * @phpstan-import-type DictionarySchema from SchemaGen
 * @phpstan-import-type Reference from SchemaGen
 */
class DocType extends Type
{
    /**
     * @param ArraySchema $schema
     * @return string
     *
     * @throws \JsonException
     */
    public static function array(array $schema): string
    {
        return SchemaGen::docType($schema['items']) . '[]';
    }

    /**
     * @param DictionarySchema $schema
     * @return string
     *
     * @throws \JsonException
     */
    public static function dictionaryObject(array $schema): string
    {
        return SchemaGen::docType($schema['additionalProperties']) . '[]';
    }
}
