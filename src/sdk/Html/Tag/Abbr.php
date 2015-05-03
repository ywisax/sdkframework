<?php

namespace sdk\Html\Tag;

use sdk\Html\Element\InlineElement;
use sdk\Html\Tag;

/**
 * 指示简称或缩写，比如 "WWW" 或 "NATO"
 */
class Abbr extends Tag implements InlineElement
{

    protected $_tagName = 'abbr';

}
