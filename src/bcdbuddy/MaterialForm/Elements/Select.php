<?php

namespace bcdbuddy\MaterialForm\Elements;

class Select extends InputField
{
    protected $options;
    protected $selected;
    protected $icons;
    protected $icon_class;

    public function __construct($label, $name, $options = [], $icons = false)
    {
        parent::__construct($label, $name);
        $this->setOptions($options);
        $this->icons = $icons;
        $this->attributes = array_merge($this->attributes, [
            "class" => ($this->icons)? "icons": ""
        ]);
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
            $result .= sprintf('<select %s>', $this->renderAttributes());
                $result .= '<option value="" disabled selected>'. $this->label_string .'</option>';
                $result .= $this->renderOptions();
            $result .= '</select>';
        $result .= '</div>';

        return $result;
    }

    protected function renderOptions()
    {
        list($values, $labels) = $this->splitKeysAndValues($this->options);

        $tags = array_map(function ($value, $label, $icon) {
            if (is_array($label)) {
                return $this->renderOptGroup($value, $label, $icon);
            }
            return $this->renderOption($value, $label, $icon);
        }, $values, $labels, $this->icons);

        return implode($tags);
    }

    protected function renderOptGroup($label, $options, $icons)
    {
        list($values, $labels) = $this->splitKeysAndValues($options);

        $options = array_map(function ($value, $label, $icon) {
            return $this->renderOption($value, $label, $icon);
        }, $values, $labels, $icons);

        return implode([
            sprintf('<optgroup label="%s">', $label),
            implode($options),
            '</optgroup>',
        ]);
    }

    protected function renderOption($value, $label, $icon)
    {
        return implode([
            sprintf('<option %s class="%s" value="%s"%s>', $this->renderDataIcon($icon), $this->icon_class, $value, $this->isSelected($value) ? ' selected' : ''),
            $label,
            '</option>',
        ]);
    }

    private function renderDataIcon($icon)
    {
        if ($this->icons) {
            return sprintf(' data-icon="%s"', $icon);
        }
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


    public function iconClass($class = "left") {
        $this->icon_class = $class. " circle";
        return $this;
    }

    public function left () {
        $this->icon_class = "left circle";
        return $this;
    }

    public function right () {
        $this->icon_class = "right circle";
        return $this;
    }

}
