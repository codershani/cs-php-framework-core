<?php

namespace app\core\form;
use app\core\Model;

/**
 * Summary of Field
 * @author CoderShani
 * @package app\core\form
 * @copyright (c) 2023
 */
class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public const TYPE_FILES = 'file';
    public string $type;
    
    /**
     * Summary of __construct
     * @param \app\core\Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }
    
    
    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function filesField()
    {
        $this->type = self::TYPE_FILES;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf('
                <input type="%s" name="%s" value="%s" id="%s" class="form-control%s">
                ',
                    $this->type,
                    $this->attribute,
                    $this->model->{$this->attribute},
                    $this->attribute,
                    $this->model->hasError($this->attribute) ? ' is-invalid' : '',
                );
    }
}