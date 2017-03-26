<?php

namespace bcdbuddy\MaterialForm\Elements;

class Button extends Element
{
    protected $addons = [];
    protected $attributes = [
        'type' => 'button',
        'class' => 'btn'
    ];

    protected $value;

    public function __construct($value)
    {
        $this->value($value);
    }

    public function render()
    {
        $addons = "";
        foreach ($this->addons as $addon) {
            $addons .= $addon;
        }
        return sprintf('<button %s>%s %s</button>',$this->renderAttributes(), $addons, $this->value);
    }

    public function value($value)
    {
        $this->value = $value;
    }

    public function icon ($icon_name, $class='right') {
        $icon = new MaterialIcon($icon_name);
        $icon->addClass($class);
        $this->addon($icon);
        return $this;
    }

    public function addon ($addon) {
        $this->addons[] = $addon;
    }
}
