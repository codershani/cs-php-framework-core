<?php

namespace app\core\form;
use app\core\Model;

/**
 * Summary of Form
 * @author CoderShani
 * @package app\core\form
 * @copyright (c) 2023
 */
class Form
{

    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        return '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }
}