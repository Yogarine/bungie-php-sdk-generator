<?php
declare(strict_types=1);

namespace Yogarine\OpenAPI\Generator;

enum SchemaType
{
    case Reference;
    case EnumReference;
    case Boolean;
    case Integer;
    case Number;
    case String;
    case Enum;
    case Array;
    case ObjectLiteral;
    case CompositeObject;
    case DictionaryObject;
    case ArrayObject;
}
