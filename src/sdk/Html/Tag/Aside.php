<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\BlockElement;
use sdk\Html\Tag;

/**
 * <aside> 标签定义其所处内容之外的内容。aside的内容应该与附近的内容相关。
 */
class Aside extends Tag implements BlockElement
{

    protected $_tagName = 'aside';

}
