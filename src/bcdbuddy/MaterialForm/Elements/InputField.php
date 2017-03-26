<?php

namespace bcdbuddy\MaterialForm\Elements;

class InputField extends Input{

    public $label;
    protected $addons = [];

    function __construct($label, $name)
    {
        parent::__construct($name);
        $this->attribute("id", $name);
        $this->label = new Label($label);
        $this->label->attribute("for", $name);
    }

    public function render()
    {
        $result = '<div class="input-field">';
        foreach ($this->addons as $addon) {
            $result .= $addon;
        }
        $result .= parent::render();
        $result .= $this->label;
        $result .= '</div>';
        return $result;
    }

    public function addon ($addon) {
        $this->addons[] = $addon;
    }


    public function icon ($icon_name, $class=false) {
        $icon = new MaterialIcon($icon_name);
        if ($class) {
            $icon->addClass($class);
        }
        $icon->addClass("prefix");
        $this->addon($icon);
        return $this;
    }
    
}