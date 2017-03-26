<?php

namespace bcdbuddy\MaterialForm\Elements;

class Submit extends Button
{
    protected $attributes = [
        "type" => "submit",

    ];
    public function render()
    {
        return '<br/> '. parent::render();
    }
}