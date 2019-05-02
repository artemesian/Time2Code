<?php
namespace Time2Code\Framework\Router;

/**
 * Class Route
 * Représente une route
 * @package Framework\Router
 */
class Route
{
    /**
     * @var string Nom de route
     */
    private $name;

    /**
     * @var string url de la route
     */

    /**
     * @var array Paramètres associés à l'URL
     */
    private $params = [];

    /**
     * @var callable Middleware à exécuter lorsque la route correspond
     */
    private $callback;

    /**
     * Route constructor.
     * @param string $path
     * @param callable $callback
     * @param string $name
     */
    public function __construct(string $name, callable $callback, array $params)
    {
        $this->name = $name;
        $this->params = $params;
        $this->callback = $callback;
    }

    /**
     * Renvoie le nom de la route
     * @return string|null
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Renvoie le Middleware à exécuter lorsque la route correspond
     * @return callable|null
     */
    public function getCallback(): ?callable
    {
        if (!empty($this->callback && is_callable($this->callback))) {
            return $this->callback;
        }
            return null;
    }

    /**
     * Renvoie les paramètes de la route
     * @return array
     */
    public function getParams(): array
    {
        if (!empty($this->params)) {
            return $this->params;
        }
        return [];
    }
}
