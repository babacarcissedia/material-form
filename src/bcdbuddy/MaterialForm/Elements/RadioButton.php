<?php

namespace bcdbuddy\MaterialForm\Elements;

class RadioButton extends Checkbox
{
    protected $attributes = [
        'type' => 'radio',
    ];

    public function __construct($label, $name, $value = null)
    {
        parent::__construct($label, $name);

        if (is_null($value)) {
            $value = $name;
        }

        $this->setValue($value);
    }
}
