<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('base64_encode_resource', [$this, 'base64EncodeResource']),
        ];
    }

    public function base64EncodeResource($resource)
    {
        if (is_resource($resource)) {
            // Lire le contenu de la ressource dans une chaîne
            $contents = stream_get_contents($resource);
            return base64_encode($contents);
        }
        return '';
    }
}
