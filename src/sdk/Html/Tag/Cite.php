<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\InlineElement;
use sdk\Html\Tag;

/**
 * 通常表示它所包含的文本对某个参考文献的引用，比如书籍或者杂志的标题
 */
class Cite extends Tag implements InlineElement
{

    protected $_tagName = 'cite';

}
