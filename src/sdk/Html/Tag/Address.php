<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\BlockElement;
use sdk\Html\Tag;

/**
 * address标签，定义文档或文章的作者/拥有者的联系信息。
 *
 * @package sdk\Html\Tag
 */
class Address extends Tag implements BlockElement
{

    protected $_tagName = 'address';

}
