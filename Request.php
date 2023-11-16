<?php

namespace app\core;

  /**
   * Summary of Request
   * @author CoderShani
   * @package app\core
   * @copyright (c) 2023
   */

class Request
{

    private array $routeParams = [];

    /**
     * Summary of getMethod
     * @return string
     */
    public function getMethod() 
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Summary of getUrl
     * @return mixed
     */
    public function getUrl() 
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function isGet() 
    {
        return $this->getMethod() === 'get';
    }

    public function isPost() 
    {
        return $this->getMethod() === 'post';
    }

    /**
     * Summary of getBody
     * @return array
     */
    public function getBody()
    {
        $data = [];
        if($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $data;
    }

    public function setRouteParams($params) {
        $this->routeParams = $params;
        return $this;
    }

    public function getRouteParams() {
        return $this->routeParams;
    }

}