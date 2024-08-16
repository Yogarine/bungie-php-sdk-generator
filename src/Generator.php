<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI;

use JsonException;
use RuntimeException;
use Yogarine\OpenAPI\Generator\PathGen;
use Yogarine\OpenAPI\Generator\SchemaGen;
use Yogarine\OpenAPI\Generator\ServiceGen;
use Yogarine\OpenAPI\Generator\Type;
use Yogarine\OpenAPI\Spec\OpenApi;
use Yogarine\OpenAPI\Spec\Tag;

/**
 * @phpstan-import-type SchemaSpec   from SchemaGen
 * @phpstan-import-type PathItemSpec from PathGen
 * @phpstan-import-type TagSpec      from Tag
 *
 * @phpstan-type PathsSpec array<string, PathItemSpec>
 */
class Generator
{
    /**
     * @throws JsonException
     */
    public static function main(int $argc, array $argv): int
    {
        $outPath = dirname(__DIR__) . '/out';

        $openApiSpec = json_decode(
            file_get_contents(dirname(__DIR__) . '/Bungie-net/api/openapi.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $openApi = OpenApi::fromSpec($openApiSpec);
        
        foreach ($openApi->tags as $tag) {
            $result = ServiceGen::render($tag, $openApi->paths);
        }

        foreach ($openApi->components->schemas as $identifier => $schema) {
            $fqnParts = Type::fqnParts($identifier);
            $pathParts = [...explode(DIRECTORY_SEPARATOR, $outPath), ...array_slice($fqnParts, 1)];

            $result = SchemaGen::render($identifier, $schema);

            $path = implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
            $dir = dirname($path);
            if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }

            file_put_contents($path, "<?php\n\n" . $result);
        }

        return 0;
    }
}
