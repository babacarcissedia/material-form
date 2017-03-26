<?php

namespace bcdbuddy\MaterialForm\Elements;


class IconInputField extends InputField
{

    function __construct($label, $name, $icon)
    {
        parent::__construct($label, $name);
        if ($icon) {
            $this->addon(new MaterialIcon($icon));
        }
    }
}