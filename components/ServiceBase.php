<?php

namespace app\components;


use yii\base\InvalidConfigException;
use yii\base\Object;

class ServiceBase extends Object
{
    /**
     * A configuration array: the array must contain a `class` element which is treated as the object class,
     * and the rest of the name-value pairs will be used to initialize the corresponding object properties
     * @var array
     */
    public $model;

    public function init()
    {
        parent::init();

        if (empty($this->model['class'])) {
            throw new InvalidConfigException('Field "model" must be configured like array and it must contain a `class` element');
        }
    }

    /**
     * @return string
     */
    protected function getModelClassName()
    {
        return $this->model['class'];
    }
}