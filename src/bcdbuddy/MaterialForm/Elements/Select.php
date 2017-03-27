<?php

namespace bcdbuddy\MaterialForm\Elements;

class Select extends InputField
{
    protected $options;
    protected $selected;

    public function __construct($label, $name, $options = [])
    {
        parent::__construct($label, $name);
        $this->setOptions($options);
    }

    public function select($option)
    {
        $this->selected = $option;

        return $this;
    }

    protected function setOptions($options)
    {
        $this->options = $options;
    }

    public function options($options)
    {
        $this->setOptions($options);

        return $this;
    }

    public function render()
    {
        $result = '<div class="input-field">';
            foreach ($this->addons as $addon) {
                $result .= $addon;
            }
            $result .= sprintf('<select%s>', $this->renderAttributes());
                $result .= '<option value="" disabled selected>'. $this->label_string .'</option>';
                $result .= $this->renderOptions();
            $result .= '</select>';
            $result .= $this->label;
        $result .= '</div>';

        return $result;
    }

    protected function renderOptions()
    {
        list($values, $labels) = $this->splitKeysAndValues($this->options);

        $tags = array_map(function ($value, $label) {
            if (is_array($label)) {
                return $this->renderOptGroup($value, $label);
            }
            return $this->renderOption($value, $label);
        }, $values, $labels);

        return implode($tags);
    }

    protected function renderOptGroup($label, $options)
    {
        list($values, $labels) = $this->splitKeysAndValues($options);

        $options = array_map(function ($value, $label) {
            return $this->renderOption($value, $label);
        }, $values, $labels);

        return implode([
            sprintf('<optgroup label="%s">', $label),
            implode($options),
            '</optgroup>',
        ]);
    }

    protected function renderOption($value, $label)
    {
        return implode([
            sprintf('<option value="%s"%s>', $value, $this->isSelected($value) ? ' selected' : ''),
            $label,
            '</option>',
        ]);
    }

    protected function isSelected($value)
    {
        return in_array($value, (array) $this->selected);
    }

    public function addOption($value, $label)
    {
        $this->options[$value] = $label;

        return $this;
    }

    public function defaultValue($value)
    {
        if (isset($this->selected)) {
            return $this;
        }

        $this->select($value);

        return $this;
    }

    public function multiple()
    {
        $name = $this->attributes['name'];
        if (substr($name, -2) != '[]') {
            $name .= '[]';
        }

        $this->setName($name);
        $this->setAttribute('multiple', 'multiple');

        return $this;
    }
}
