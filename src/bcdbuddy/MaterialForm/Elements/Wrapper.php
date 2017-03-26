<?php

namespace bcdbuddy\MaterialForm\Elements;

class Wrapper extends Element
{
    protected $elements = [];
    protected $helpBlock;

    public function __construct()
    {
        $this->elements = func_get_args();
    }

    public function render()
    {
        $this->beforeRender();

        $html = '<div';
        $html .= $this->renderAttributes();
        $html .= '>';

        foreach ($this->elements as $control) {
            $html .= $control;
        }

        $html .= $this->renderHelpBlock();

        $html .= '</div>';

        return $html;
    }

    public function helpBlock($text)
    {
        if (isset($this->helpBlock)) {
            return;
        }
        $this->helpBlock = new HelpBlock($text);

        return $this;
    }

    protected function renderHelpBlock()
    {
        if ($this->helpBlock) {
            return $this->helpBlock->render();
        }

        return '';
    }

    private function beforeRender()
    {
    }

    public function __call($method, $params)
    {
        $params = count($params) ? $params : [$method];
        $params = array_merge([$method], $params);
        call_user_func_array([$this, 'attribute'], $params);

        return $this;
    }
}