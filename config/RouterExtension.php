<?php

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouterExtension extends AbstractExtension
{
    private $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('url', [$this, 'generateUrl']),
        ];
    }

    public function generateUrl($name, $params = [])
    {
        return $this->router->generate($name, $params);
    }
}