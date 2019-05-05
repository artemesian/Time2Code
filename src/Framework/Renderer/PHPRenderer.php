<?php
namespace Time2Code\Framework\Renderer;

/**
 * Class PHPRenderer
 * Gère le rendu des vues en utilisant PHP
 * @package Time2Code\Framework\Renderer
 */
class PHPRenderer implements RendererInterface
{
    /**
     * Représente le chemin par défaut des vues
     * @const
     */
    const DEFAULT_NAMESPACE = '__DEFAULT_NAMESPACE';

    /**
     * Stock les différents chemin vers les repertoires contenant les vues
     * @var array
     */
    private $paths = [];

    /**
     * Stock les variables qui seront utilisé dans toutes les vues, notament le Router
     * @var array
     */
    private $globals = [];


    public function __construct(?string $defautPath = null)
    {
        if (!is_null($defautPath)) {
            $this->addPath($defautPath);
        }
    }

    /**
     * @param string $view
     * @return bool
     */
    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }

    /**
     * @param string $view
     * @return string
     */
    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') -1);
    }

    /**
     * @param string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }

    /**
     * Ajoute un chemin vers les vues dans une variable d'instance
     * @param string $namespace
     * @param string|null $path
     */
    public function addPath(string $namespace, string $path = null):void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        }
        $this->paths[$namespace] = $path;
    }

    /**
     * Affiche la view passée en paramètre et lui injecte les paramètres dans le tableau $params
     * @param string $view
     * @param array $params
     * @return string
     */
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

    /**
     * Ajoute une variable d'instance dans le renderer, qui sera utilisé comme variable globale
     * @param string $name
     * @param $value
     */
    public function addGlobals(string $name, $value) : void
    {
        $this->globals[$name] = $value;
    }
}
