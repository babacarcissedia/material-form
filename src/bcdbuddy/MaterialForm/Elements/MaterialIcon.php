<?php

namespace bcdbuddy\MaterialForm\Elements;


class MaterialIcon extends Element
{
    protected $attributes = [
        "class" => "material-icons"
    ];
    private $name;
    private $prefix;

    function __construct($name, $prefix=false)
    {
        $this->name = $name;
        $this->prefix = $prefix;
    }

    public function render()
    {
        return implode('', [
            '<i ',
            $this->renderAttributes(),
            ($this->prefix) ? 'prefix' : '',
            '">'. $this->name .'</i>'
        ]);
    }
}