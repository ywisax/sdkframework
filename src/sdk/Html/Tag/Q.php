<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\InlineElement;
use sdk\Html\Tag;

/**
 * <q> 标签定义短的引用
 *
 * @property mixed cite  定义引用的出处或来源（citation）
 */
class Q extends Tag implements InlineElement
{

    protected $_tagName = 'q';

    /**
     * @return null|string|array
     */
    public function getCite()
    {
        return $this->getAttribute('cite');
    }

    /**
     * @param $cite
     */
    public function setCite($cite)
    {
        $this->setAttribute('cite', $cite);
    }

}
