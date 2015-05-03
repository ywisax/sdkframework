<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\BlockElement;
use sdk\Html\Tag;

/**
 * legend 元素为 fieldset 元素定义标题（caption）。
 */
class Legend extends Tag implements BlockElement
{

    protected $_tagName = 'legend';

}
