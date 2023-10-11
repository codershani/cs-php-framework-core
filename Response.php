<?php

namespace app\core;

/**
 * Summary of Response
 * @author CoderShani
 * @package app\core
 * @copyright (c) 2023
 */
class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        return header('Location: ' . $url);
    }
}