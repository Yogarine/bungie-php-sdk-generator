<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Generator;

/**
 * @phpstan-import-type BooleanSchema from SchemaGen
 * @phpstan-import-type IntegerSchema from SchemaGen
 * @phpstan-import-type NumberSchema from SchemaGen
 * @phpstan-import-type StringSchema from SchemaGen
 * @phpstan-import-type EnumSchema from SchemaGen
 * @phpstan-import-type EnumReference from SchemaGen
 * @phpstan-import-type ArraySchema from SchemaGen
 * @phpstan-import-type ObjectLiteralSchema from SchemaGen
 * @phpstan-import-type CompositeObjectSchema from SchemaGen
 * @phpstan-import-type DictionarySchema from SchemaGen
 * @phpstan-import-type Reference from SchemaGen
 */
class Type
{
    /**
     * @param  BooleanSchema  $schema
     * @return string
     */
    public static function boolean(array $schema): string
    {
        return 'bool';
    }

    public static function integer(array $schema): string
    {
        return 'int';
    }

    public static function number(array $schema): string
    {
        return 'float';
    }

    public static function string(array $schema): string
    {
        return 'string';
    }

    /**
     * @param  EnumSchema  $schema
     * @return string
     */
    public static function enum(array $schema): string
    {
        return 'int';
    }

    /**
     * @param  EnumReference  $schema
     * @return class-string
     */
    public static function enumReference(array $schema): string
    {
        return self::reference($schema['x-enum-reference']);
    }

    /**
     * @param  ArraySchema  $schema
     * @return string
     */
    public static function array(array $schema): string
    {
        return 'array';
    }


    /**
     * @param  ObjectLiteralSchema  $schema
     * @return string
     */
    public static function objectLiteral(array $schema): string
    {
        if (!isset($schema['properties'])) {
            return 'array';
        }

        $type = 'array{';
        foreach ($schema['properties'] as $propertyName => $property) {
            $type .= "{$propertyName}: " . SchemaGen::type($property) . ', ';
        }
        $type .= '}';

        return $type;
    }

    /**
     * @param  CompositeObjectSchema  $schema
     * @return string
     */
    public static function compositeObject(array $schema): string
    {
        $types = [];
        foreach ($schema['allOf'] as $ref) {
            $types[] = self::reference($ref);
        }

        return implode(' & ', $types);
    }

    /**
     * @param  DictionarySchema  $schema
     * @return string
     */
    public static function dictionaryObject(array $schema): string
    {
        return 'array';
    }

    /**
     * @param  ObjectLiteralSchema  $schema
     * @return class-string
     */
    public static function arrayObject(array $schema): string
    {
        $types = [];
        foreach ($schema['allOf'] as $ref) {
            $types[] = self::reference($ref);
        }

        return implode(' & ', $types);
    }

    /**
     * @param  Reference  $schema
     * @return class-string
     */
    public static function reference(array $schema): string
    {
        $ref = $schema['$ref'];
        $parts = explode('/', $ref);
        $identifier = end($parts);

        return self::fqn($identifier);
    }


    /**
     * @param  string  $identifier  {@example "User.Models.GetCredentialTypesForAccountResponse"}
     * @return class-string
     */
    public static function fqn(string $identifier): string
    {
        return '\\' . implode('\\', self::fqnParts($identifier));
    }

    /**
     * @param  string  $identifier  {@example "User.Models.GetCredentialTypesForAccountResponse"}
     * @return string[] {@example ["Bungie", "User", "Models", "GetCredentialTypesForAccountResponse"]}
     */
    public static function fqnParts(string $identifier): array
    {
        return ['Bungie', ...explode('.', $identifier)];
    }
}
