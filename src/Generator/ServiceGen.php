<?php

declare(strict_types=1);

namespace Yogarine\OpenAPI\Generator;

use RuntimeException;
use Yogarine\OpenAPI\Spec\Paths;
use Yogarine\OpenAPI\Spec\Tag;

class ServiceGen
{
    /**
     * @param  Tag    $tag
     * @param  Paths  $paths
     * @return string
     */
    public static function render(Tag $tag, Paths $paths): string
    {
        $tagName   = $tag->name;
        $namespace = "Bungie";
        $name      = $tagName;

        $methods = '';
        foreach ($paths as $route => $pathItem) {
            $summaryParts = explode('.', $pathItem->summary);
            if ($summaryParts[0] !== $tagName) {
                continue;
            }

            $methods .= PathGen::render($route, $pathItem);
        }

        if (!ob_start()) {
            throw new RuntimeException('Failed to start output buffering');
        }

        require dirname(__DIR__, 2) . '/res/templates/service.inc.php';

        $result = ob_get_clean();
        if (false === $result) {
            throw new RuntimeException('Failed to render template');
        }

        return $result;
    }
}
