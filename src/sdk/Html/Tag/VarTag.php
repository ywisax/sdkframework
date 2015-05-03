<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\InlineElement;
use sdk\Html\Tag;

/**
 * 标签表示变量的名称，或者由用户提供的值
 */
class VarTag extends Tag implements InlineElement
{

    protected $_tagName = 'var';

}
