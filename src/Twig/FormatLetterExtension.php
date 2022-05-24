<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FormatLetterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('formatLetter', [$this, 'formatLetter'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function formatLetter($text, $letter='n')
    {
        $pattern = "/". $letter . "/"; // letter /n/ search patter
        $text = preg_replace($pattern, "<strong>" . mb_strtoupper($letter) . "</strong>", $text );

        return $text;
    }
}
