<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ExcerptTextExtentionExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('excerpt', [$this, 'formatExcerpt']),
        ];
    }

    // cut a text at the 200th character
    public function formatExcerpt($text, $maxlen = 200, $elipsis = "...")
    {
        // strlen($text) returns the lenght of $text
        if(strlen($text) < $maxlen) {
            return $text;
        }

        return substr($text, 0, $maxlen - strlen($elipsis)).$elipsis; // (text, start at 0, 200 - 3 + ...)
    }
}
