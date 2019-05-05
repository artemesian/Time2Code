<?php
namespace Time2Code\Framework\Renderer;

/**
 * Interface RendererInterface
 * Définit les méhode à utiliser dans le système de Rendu des vues
 * @package Time2Code\Framework\Renderer
 *
 */
interface RendererInterface
{
    /**
     * Ajoute un chemin vers les vues dans une variable d'instance
     * @param string $path
     * @param string $namespace
     */
    public function addPath(string $namespace, string $path = null):void;

    /**
     * Affiche la view passée en paramètre et lui injecte les paramètres dans le tableau $params
     * sous forme de variables
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string;

    /**
     * Ajoute une variable d'instance dans le renderer, qui sera utilisé comme variable globale
     * accéssible dans toutes les vues
     * @param string $value
     * @param $name
     */
    public function addGlobals(string $name, $value) : void;
}
