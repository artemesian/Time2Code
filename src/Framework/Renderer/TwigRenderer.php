<?php
namespace Time2Code\Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    private $twig;
    private $loader;

    public function __construct(string $viewPath)
    {
        $this->loader = new FilesystemLoader($viewPath);
        $this->twig = new Environment($this->loader);
    }

    public function addGlobals(string $name, $value) : void
    {
         $this->twig->addGlobal($name, $value);
    }

    public function addPath(string $namespace, string $path = null):void
    {
        $this->loader->addPath($path, $namespace);
    }

    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.twig', $params);
    }
}
