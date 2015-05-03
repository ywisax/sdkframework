<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\InlineElement;
use sdk\Html\Tag;

/**
 * br标签
 */
class Br extends Tag implements InlineElement
{

    protected $_tagName = 'br';

    /**
     * @var bool 是否成对标签
     */
    protected $_tagClosed = false;

}
