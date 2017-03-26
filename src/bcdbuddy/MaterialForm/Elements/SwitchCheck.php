<?php

namespace bcdbuddy\MaterialForm\Elements;


class SwitchCheck extends Checkbox
{
    private $label1;
    private $label2;

    public function __construct($label1, $label2, $name, $checked = true)
    {
        if ($checked) {
            $this->attribute("checked", "checked");
        }
        $this->attribute("name", $name);
        $this->label1 = $label1;
        $this->label2 = $label2;
    }

    public function render()
    {
        return implode('', [
             '<div class="switch">',
                '<label>',
                    $this->label2,
                    '<input ',
                    $this->renderAttributes(),
                    '>',
                    '<span class="lever"></span>',
                    $this->label1,
                '</label>',
            '</div>'
        ]);
    }
}