<?php
namespace Time2Code\Framework\Renderer;

class Renderer
{
    const DEFAULT_NAMESPACE = '__DEFAULT_NAMESPACE';

    private $paths = [];

    private $globals = [];

    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') -1);
    }

    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }


    public function addPath(string $namespace, string $path = null):void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        }
        $this->paths[$namespace] = $path;
    }

    public function render(string $view, array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view) . '.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . "/" . $view . ".php";
        }

        ob_start();
        extract($params);
        extract($this->globals);
        require($path);
        return  ob_get_clean();
    }

    public function globals(string $name, $value) : void
    {
        $this->globals[$name] = $value;
    }
}
