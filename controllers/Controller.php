<?php

namespace Controllers;


class Controller
{

    protected $container;

    public function __construct(&$container = null)
    {
        $this->container = $container;
    }

    public function setContainer(&$container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
}