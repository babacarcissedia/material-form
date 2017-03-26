<?php

namespace bcdbuddy\MaterialForm\Elements;

class TextArea extends InputField
{
    protected $attributes = [
        'name' => '',
        'rows' => 10,
        'cols' => 50,
        "class" => "materialize-textarea"
    ];

    protected $value;

    public function render()
    {
        $result = '<div class="input-field">';
        foreach ($this->addons as $addon) {
            $result .= $addon;
        }
        $result .= implode([
            sprintf('<textarea%s>', $this->renderAttributes()),
            $this->value,
            '</textarea>',
        ]);
        $result .= $this->label;
        $result .= '</div>';
        return $result;
    }

    public function rows($rows)
    {
        $this->setAttribute('rows', $rows);

        return $this;
    }

    public function cols($cols)
    {
        $this->setAttribute('cols', $cols);

        return $this;
    }

    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    public function placeholder($placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);

        return $this;
    }

    public function defaultValue($value)
    {
        if (! $this->hasValue()) {
            $this->value($value);
        }

        return $this;
    }

    protected function hasValue()
    {
        return isset($this->value);
    }
}
