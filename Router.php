<?php

namespace app\core;
use app\core\exception\NotFoundException;

  /**
   * Summary of Router
   * @author CoderShani
   * @package app\core
   * @copyright (c) 2023
   */

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * Summary of __construct
     * @param \app\core\Request $request
     * @param \app\core\Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Summary of get
     * @param mixed $path
     * @param mixed $callback
     * @return void
     */
    public function get($path, $callback) 
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Summary of post
     * @param mixed $path
     * @param mixed $callback
     * @return void
     */
    public function post($path, $callback) 
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Summary of resolve
     * @return mixed
     */
    public function resolve() 
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if($callback === false) {
            // Application::$app->response->setStatusCode(404);
            // return $this->renderView("_error");
            throw new NotFoundException();
        }

        if(is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        if(is_array($callback)) {
            /** @var \app\core\Controller $controller */
            $controller = new $callback[0];
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    
}