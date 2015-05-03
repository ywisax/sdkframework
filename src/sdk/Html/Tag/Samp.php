<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\InlineElement;
use sdk\Html\Tag;

/**
 * <samp> 标签表示一段用户应该对其没有什么其他解释的文本字符。要从正常的上下文抽取这些字符时，通常要用到这个标签
 */
class Samp extends Tag implements InlineElement
{

    protected $_tagName = 'samp';

}
