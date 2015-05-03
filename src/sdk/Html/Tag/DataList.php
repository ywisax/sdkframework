<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\InlineElement;
use sdk\Html\Tag;

/**
 * datalist标签，定义选项列表。请与 input 元素配合使用该元素，来定义 input 可能的值。
 */
class DataList extends Tag implements InlineElement
{

    protected $_tagName = 'datalist';

}
