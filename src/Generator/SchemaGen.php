<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Generator;

use RuntimeException;

/**
 * @phpstan-type SchemaSpec                ObjectSchemaSpec|ArraySchemaSpec|EnumReferenceSpec|EnumSchemaSpec|StringSchemaSpec|NumberSchemaSpec|IntegerSchemaSpec|BooleanSchemaSpec
 * @phpstan-type BooleanSchemaSpec         array{
 *                                             type:         'boolean',
 *                                             description?: string,
 *                                         }
 * @phpstan-type IntegerSchemaSpec         array{
 *                                             type:         'integer',
 *                                             description?: string,
 *                                             format?:      string,
 *                                         }
 * @phpstan-type NumberSchemaSpec          array{
 *                                             type:         'number',
 *                                             description?: string,
 *                                             format:       'double'|'float',
 *                                             nullable?:    bool,
 *                                         }
 * @phpstan-type StringSchemaSpec          array{
 *                                             type:         'string',
 *                                             description?: string,
 *                                             format?:      string,
 *                                             nullable?:    bool,
 *                                         }
 * @phpstan-type EnumReferenceSpec         array{
 *                                             type:               'integer',
 *                                             description?:       string,
 *                                             format?:            string,
 *                                             x-enum-reference:   ReferenceSpec,
 *                                             x-enum-is-bitmask?: bool,
 *                                         }
 * @phpstan-type EnumSchemaSpec            array{
 *                                             enum:               string[],
 *                                             type:               'integer',
 *                                             description?:       string,
 *                                             format?:            string,
*                                              x-enum-is-bitmask?: bool,
 *                                             x-enum-values:      array{
 *                                                 numericValue:       string,
 *                                                 identifier:         string,
 *                                             },
 *                                         }
 * @phpstan-type ArraySchemaSpec           array{
 *                                             type:                 'array',
 *                                             items:                SchemaSpec,
 *                                             description?:         string,
 *                                             x-mapped-definition?: string,
 *                                         }
 * @phpstan-type ArrayObjectSchemaSpec     array{
 *                                             type:                    'object',
 *                                             properties:              array<string, SchemaSpec>,
 *                                             additionalProperties:    SchemaSpec,
 *                                             description?:            string,
 *                                             x-dictionary-key?:       string,
 *                                             x-mobile-manifest-name?: string,
 *                                         }
 * @phpstan-type ObjectSchemaSpec          ObjectLiteralSchemaSpec|CompositeObjectSchemaSpec|DictionarySchemaSpec|ArrayObjectSchemaSpec
 * @phpstan-type ObjectLiteralSchemaSpec   array{
 *                                             type:                    'object',
 *                                             properties?:             array<string, SchemaSpec>,
 *                                             description?:            string,
 *                                             x-mobile-manifest-name?: string,
 *                                         }
 * @phpstan-type CompositeObjectSchemaSpec array{
 *                                             type:         'object',
 *                                             allOf?:       ReferenceSpec[],
 *                                             description?: string,
 *                                         }
 * @phpstan-type DictionarySchemaSpec      array{
 *                                             type:                 'object',
 *                                             additionalProperties: SchemaSpec,
 *                                             description?:         string,
 *                                             x-dictionary-key?:    SchemaSpec,
 *                                         }
 */
class SchemaGen
{
    /**
     * @param string $identifier
     * @param SchemaSpec $schema
     * @return string
     *
     * @throws \JsonException
     */
    public static function render(string $identifier, array $schema): string
    {
        $fqnParts  = Type::fqnParts($identifier);
        $nsParts   = array_slice($fqnParts, 0, -1);
        $name      = end($fqnParts);
        $namespace = implode('\\', $nsParts);

        if (!ob_start()) {
            throw new RuntimeException('Failed to start output buffering');
        }

        $schemaType = self::schemaType($schema);
        switch ($schemaType) {
            case SchemaType::Enum:
                if (isset($schema['enum'])) {
                    require dirname(__DIR__, 2) . '/res/templates/components/schema/enum.inc.php';
                } else {
                    trigger_error("Non-enum integer schema: `{$identifier}`");
                }
                break;
            case SchemaType::ObjectLiteral:
                require dirname(__DIR__, 2) . '/res/templates/components/schema/class.inc.php';
                break;
            case SchemaType::ArrayObject:
                require dirname(__DIR__, 2) . '/res/templates/components/schema/array_object.inc.php';
                break;
            case SchemaType::DictionaryObject:
            case SchemaType::Array:
                break;
            default:
                trigger_error("Unsupported schema type `{$schemaType->name}` (`{$schema['type']}`) for `$identifier`");
        }

        $result = ob_get_clean();

        if (false === $result) {
            throw new RuntimeException('Failed to render template');
        }

        return $result;
    }

    /**
     * @param SchemaSpec $schema
     * @return string
     *
     * @throws \JsonException
     */
    public static function docType(array $schema): string
    {
        return match (self::schemaType($schema)) {
            SchemaType::Array => DocType::array($schema),
            SchemaType::DictionaryObject => DocType::dictionaryObject($schema),
            default => self::type($schema),
        };
    }

    /**
     * @param SchemaSpec $schema
     * @return string
     *
     * @throws \JsonException
     */
    public static function type(array $schema): string
    {
        return match (self::schemaType($schema)) {
            SchemaType::Reference        => Type::reference($schema),
            SchemaType::EnumReference    => Type::EnumReference($schema),
            SchemaType::Boolean          => Type::boolean($schema),
            SchemaType::Integer          => Type::integer($schema),
            SchemaType::Number           => Type::number($schema),
            SchemaType::String           => Type::string($schema),
            SchemaType::Enum             => Type::enum($schema),
            SchemaType::Array            => Type::array($schema),
            SchemaType::ObjectLiteral    => Type::objectLiteral($schema),
            SchemaType::CompositeObject  => Type::compositeObject($schema),
            SchemaType::DictionaryObject => Type::dictionaryObject($schema),
            SchemaType::ArrayObject      => Type::arrayObject($schema),
        };
    }

    /**
     * @param SchemaSpec $schema
     * @return SchemaType
     *
     * @throws \JsonException
     */
    public static function schemaType(array $schema): SchemaType
    {
        return match (true) {
            self::isReference($schema) => SchemaType::Reference,
            self::isEnumReference($schema) => SchemaType::EnumReference,
            self::isBoolean($schema) => SchemaType::Boolean,
            self::isInteger($schema) => SchemaType::Integer,
            self::isNumber($schema) => SchemaType::Number,
            self::isString($schema) => SchemaType::String,
            self::isEnum($schema) => SchemaType::Enum,
            self::isArray($schema) => SchemaType::Array,
            self::isObjectLiteral($schema) => SchemaType::ObjectLiteral,
            self::isCompositeObject($schema) => SchemaType::CompositeObject,
            self::isDictionary($schema) => SchemaType::DictionaryObject,
            self::isArrayObject($schema) => SchemaType::ArrayObject,
            default => self::unknownSchemaType($schema),
        };
    }

    /**
     * @throws \JsonException
     */
    public static function unknownSchemaType(array $schema): SchemaType
    {
        throw new RuntimeException(
            "Unknown schema type `{$schema['type']}`: " . json_encode($schema, JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is ReferenceSpec ? true : false)
     */
    public static function isReference(array $schema): bool
    {
        return isset($schema['$ref']);
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is EnumReferenceSpec ? true : false)
     */
    public static function isEnumReference(array $schema): bool
    {
        return isset($schema['x-enum-reference']);
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is BooleanSchemaSpec ? true : false)
     */
    public static function isBoolean(array $schema): bool
    {
        return $schema['type'] === 'boolean';
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is IntegerSchemaSpec ? true : false)
     */
    public static function isInteger(array $schema): bool
    {
        return $schema['type'] === 'integer' && !isset($schema['enum']) && !isset($schema['x-enum-reference']);
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is NumberSchemaSpec ? true : false)
     */
    public static function isNumber(array $schema): bool
    {
        return $schema['type'] === 'number';
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is StringSchemaSpec ? true : false)
     */
    public static function isString(array $schema): bool
    {
        return $schema['type'] === 'string';
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is EnumSchemaSpec ? true : false)
     */
    public static function isEnum(array $schema): bool
    {
        return isset($schema['enum']);
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is ArraySchemaSpec ? true : false)
     */
    public static function isArray(array $schema): bool
    {
        return 'array' === $schema['type'];
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is ObjectLiteralSchemaSpec ? true : false)
     */
    public static function isObjectLiteral(array $schema): bool
    {
        return $schema['type'] === 'object' && ! isset($schema['allOf']) && ! isset($schema['additionalProperties']);
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is CompositeObjectSchemaSpec ? true : false)
     */
    public static function isCompositeObject(array $schema): bool
    {
        return $schema['type'] === 'object' && isset($schema['allOf']);
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is DictionarySchemaSpec ? true : false)
     */
    public static function isDictionary(array $schema): bool
    {
        return $schema['type'] === 'object' && isset($schema['additionalProperties']) && ! isset($schema['properties']);
    }

    /**
     * @param  SchemaSpec  $schema
     * @return ($schema is ArrayObjectSchemaSpec ? true : false)
     */
    public static function isArrayObject(array $schema): bool
    {
        return 'object' === $schema['type'] && isset($schema['properties'], $schema['additionalProperties']);
    }

    /**
     * @param  ObjectLiteralSchemaSpec  $schema
     * @return array<string, SchemaSpec>
     */
    public static function properties(array $schema): array
    {
        return $schema['properties'] ?? [];
    }
}
