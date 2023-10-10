<?php

namespace app\core;
use app\core\middlewares\BaseMiddleware;

/**
 * Summary of controller
 * @author CoderShani
 * @package app\core
 * @copyright (c) 2023
 */
class Controller
{

    public string $layout = 'main';
    public string $action = '';

    /**
     * Summary of middlewares
     * @var \app\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Summary of render
     * @param mixed $view
     * @param mixed $params
     * @return array|string
     */
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middlewares)
    {
        $this->middlewares[] = $middlewares;
    }

    /**
     * Summary of getMiddlewares
     * @return \app\core\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}