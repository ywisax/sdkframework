<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\InlineElement;
use sdk\Html\Tag;

/**
 * <label> 标签为 input 元素定义标注（标记）。
 *
 * @property mixed for   规定label绑定到哪个表单元素
 * @property mixed form  规定label字段所属的一个或多个表单
 */
class Label extends Tag implements InlineElement
{

    protected $_tagName = 'label';

    /**
     * @return null|string|array
     */
    public function getFor()
    {
        return $this->getAttribute('for');
    }

    /**
     * @param $for
     */
    public function setFor($for)
    {
        $this->setAttribute('for', $for);
    }

    /**
     * @return null|string|array
     */
    public function getForm()
    {
        return $this->getAttribute('form');
    }

    /**
     * @param $form
     */
    public function setForm($form)
    {
        $this->setAttribute('form', $form);
    }

}
