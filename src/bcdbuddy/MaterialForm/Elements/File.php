<?php

namespace bcdbuddy\MaterialForm\Elements;

class File extends Input
{
    /**
     * @var
     */
    private $label;

    function __construct($label, $name)
    {
        parent::__construct($name);
        $this->label = $label;
    }

    protected $attributes = [
        'type' => 'file'
    ];


    public function render()
    {
        return implode('', [
            '<div class="file-field input-field">',
                '<div class="btn">',
                    '<span>'. $this->label .'</span>',
                    parent::render(),
                '</div>',
                '<div class="file-path-wrapper">',
                    '<input type="text" class="file-path validate" placeholder="'. $this->getAttribute("placeholder") .'">',
                '</div>',
            '</div>'
        ]);
    }
}
