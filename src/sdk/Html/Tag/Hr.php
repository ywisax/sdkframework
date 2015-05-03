<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\BlockElement;
use sdk\Html\Tag;

/**
 * hr标签，HTML 页面中创建一条水平线
 *
 * @package sdk\Html\Tag
 */
class Hr extends Tag implements BlockElement
{

    protected $_tagName = 'hr';

    /**
     * @var bool 是否成对标签
     */
    protected $_tagClosed = false;

}
