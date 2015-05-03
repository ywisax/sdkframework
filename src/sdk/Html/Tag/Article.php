<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\BlockElement;
use sdk\Html\Tag;

/**
 * <article> 标签规定独立的自包含内容
 */
class Article extends Tag implements BlockElement
{

    protected $_tagName = 'article';

}
