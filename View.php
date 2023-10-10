<?php

namespace app\core;

class View
{
    public string $title = '';

    /**
     * Summary of renderView
     * @param mixed $view
     * @param mixed $params
     * @return array|string
     */
    public function renderView($view, $params = []) 
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
        // include_once Application::$ROOT_DIR . "/views/$view.php";
    }

    /**
     * Summary of renderContent
     * @param mixed $viewContent
     * @return array|string
     */
    public function renderContent($viewContent) 
    {
        $layoutContent = $this->layoutContent();
        // $viewContent = $this->renderOnlyView($view);
        return str_replace('{{content}}', $viewContent, $layoutContent);
        // include_once Application::$ROOT_DIR . "/views/$view.php";
    }

    /**
     * Summary of layoutContent
     * @return bool|string
     */
    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    /**
     * Summary of renderOnlyView
     * @param mixed $view
     * @param mixed $params
     * @return bool|string
     */
    protected function renderOnlyView($view, $params = [])
    {
        foreach($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}