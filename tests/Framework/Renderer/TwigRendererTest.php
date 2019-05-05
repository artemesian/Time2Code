<?php
namespace Test\Framework\Renderer;

use PHPUnit\Framework\TestCase;
use Time2Code\Framework\Renderer\TwigRenderer;

class TwigRendererTest extends TestCase
{
    /**
     * Renderer
     * @var TwigRenderer
     */
    private $renderer;

    public function setUp(): void
    {
        $this->renderer = new TwigRenderer(__DIR__ . '/views');
    }

    public function testRendererWithTheRightPath()
    {
        $this->renderer->addPath('exo', __DIR__ . '/views');
        $content = $this->renderer->render('@exo/demo');
        $this->assertEquals('Exercice pour la démo', $content);
    }

    public function testRendererWithTheDefaultPath()
    {
        $this->renderer->addPath(__DIR__ . '/views');
        $content  = $this->renderer->render('demo');
        $this->assertEquals('Exercice pour la démo', $content);
    }

    public function testRendererWithParams()
    {
        $this->renderer->addPath('testparams', __DIR__ . '/views');
        $content = $this->renderer->render('@testparams/demoparams', ['param' => 'paramètres']);
        $this->assertEquals('Test demo params : paramètres', $content);
    }

    public function testRendererWithGlobalParams()
    {
        $this->renderer->addPath('testglobal', __DIR__ . '/views');
        $this->renderer->addGlobals('param', 'paramètres');
        $content = $this->renderer->render('@testglobal/demoparams');
        $this->assertEquals('Test demo params : paramètres', $content);
    }

}