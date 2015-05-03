<?php

use sdk\Base\Debug;
use sdk\Base\Sdk;

/** @var string $class */
/** @var mixed $code */
/** @var mixed $message */
/** @var mixed $file */
/** @var mixed $line */
/** @var mixed $trace */

// Unique error identifier
$errorID = uniqid('error');

?>
<style type="text/css">
    #sdk-error {
        background: #ddd;
        font-size: 1em;
        font-family: sans-serif;
        text-align: left;
        color: #111;
    }

    #sdk-error h1,
    #sdk-error h2 {
        margin: 0;
        padding: 1em;
        font-size: 1em;
        font-weight: normal;
        background: #911;
        color: #fff;
    }

    #sdk-error h1 a,
    #sdk-error h2 a {
        color: #fff;
    }

    #sdk-error h2 {
        background: #222;
    }

    #sdk-error h3 {
        margin: 0;
        padding: 0.4em 0 0;
        font-size: 1em;
        font-weight: normal;
    }

    #sdk-error p {
        margin: 0;
        padding: 0.2em 0;
    }

    #sdk-error a {
        color: #1b323b;
    }

    #sdk-error pre {
        overflow: auto;
        white-space: pre-wrap;
    }

    #sdk-error table {
        width: 100%;
        display: block;
        margin: 0 0 0.4em;
        padding: 0;
        border-collapse: collapse;
        background: #fff;
    }

    #sdk-error table td {
        border: solid 1px #ddd;
        text-align: left;
        vertical-align: top;
        padding: 0.4em;
    }

    #sdk-error table tr.collapsed td {
        border: none;
    }

    #sdk-error table th {
        padding: 10px;
        text-align: left;
        font-weight: bold;
        font-size: 18px;
    }

    #sdk-error .environment-table {
        border: 1px solid #000;
    }

    #sdk-error div.content {
        padding: 0.4em 1em 1em;
        overflow: hidden;
    }

    #sdk-error pre.source {
        margin: 0 0 1em;
        padding: 0.4em;
        background: #fff;
        border: none;
        line-height: 1.2em;
    }

    #sdk-error pre.source span.line {
        display: block;
    }

    #sdk-error pre.source span.highlight {
        background: #f0eb96;
    }

    #sdk-error pre.source span.line span.number {
        color: #666;
    }

    .js .collapsed {
        display: none;
    }
</style>
<script type="text/javascript">
    document.documentElement.className = document.documentElement.className + ' js';
    function toggle(elem) {
        elem = document.getElementById(elem);
        var display = null;
        if (elem.style && elem.style['display'])
        // Only works with the "style" attr
            display = elem.style['display'];
        else if (elem.currentStyle)
        // IE浏览器
            display = elem.currentStyle['display'];
        else if (window.getComputedStyle)
        // 其他浏览器
            display = document.defaultView.getComputedStyle(elem, null).getPropertyValue('display');

        elem.style.display = display == 'table-row' ? 'none' : 'table-row';
        return false;
    }
</script>
<div id="sdk-error">
    <h1><span class="type"><?php echo $class ?> [ <?php echo $code ?> ]:</span> <span
            class="message"><?php echo htmlspecialchars((string) $message, ENT_QUOTES, Sdk::$charset, true); ?></span>
    </h1>

    <div id="<?php echo $errorID ?>" class="content">
        <p><span class="file"><?php echo Debug::path($file) ?> [ <?php echo $line ?> ]</span></p>
        <?php echo Debug::source($file, $line) ?>

        <table cellspacing="0">
            <thead>
            <tr>
                <th><?php echo __('File') ?></th>
                <th><?php echo __('Call') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (Debug::trace($trace) as $i => $step): ?>
                <tr>
                    <td>
                        <?php if ($step['file']): $sourceId = $errorID . 'source' . $i; ?>
                            <a href="#<?php echo $sourceId ?>"
                               onclick="return toggle('<?php echo $sourceId ?>')"><?php echo Debug::path($step['file']) ?>
                                [ <?php echo $step['line'] ?> ]</a>
                        <?php else: ?>
                            {<?php echo __('PHP internal call') ?>}
                        <?php endif ?>
                    </td>
                    <td>
                        <?php echo $step['function'] ?>(<?php if ($step['args']): $argsId = $errorID . 'args' . $i; ?>
                            <a href="#<?php echo $argsId ?>"
                               onclick="return toggle('<?php echo $argsId ?>')"><?php echo __('arguments') ?></a><?php endif ?>
                        )
                    </td>
                </tr>
                <?php if (isset($argsId)): ?>
                    <tr id="<?php echo $argsId ?>" class="collapsed">
                        <td colspan="2">
                            <table cellspacing="0">
                                <?php foreach ($step['args'] as $name => $arg): ?>
                                    <tr>
                                        <td><code><?php echo $name ?></code></td>
                                        <td>
                                            <pre><?php echo Debug::dump($arg) ?></pre>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </td>
                    </tr>
                <?php endif ?>
                <?php if (isset($sourceId)): ?>
                    <tr id="<?php echo $sourceId ?>" class="collapsed">
                        <td colspan="2">
                            <?php echo $step['source'] ?>
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <h2><a href="#<?php echo $envId = $errorID . 'environment' ?>"
           onclick="return toggle('<?php echo $envId ?>')"><?php echo __('Environment') ?></a></h2>

    <table class="environment-table">
        <tbody>
            <tr id="<?php echo $envId ?>" class="content collapsed">
                <td>
                    <?php $included = get_included_files() ?>
                    <h3><a href="#<?php echo $envId = $errorID . 'environment_included' ?>"
                           onclick="return toggle('<?php echo $envId ?>')"><?php echo __('Included files') ?></a>
                        (<?php echo count($included) ?>)</h3>

                    <div id="<?php echo $envId ?>" class="collapsed">
                        <table cellspacing="0">
                            <?php foreach ($included as $file): ?>
                                <tr>
                                    <td><code><?php echo Debug::path($file) ?></code></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                    <?php $included = get_loaded_extensions() ?>
                    <h3><a href="#<?php echo $envId = $errorID . 'environment_loaded' ?>"
                           onclick="return toggle('<?php echo $envId ?>')"><?php echo __('Loaded extensions') ?></a>
                        (<?php echo count($included) ?>)</h3>

                    <div id="<?php echo $envId ?>" class="collapsed">
                        <table cellspacing="0">
                            <?php foreach ($included as $file): ?>
                                <tr>
                                    <td><code><?php echo Debug::path($file) ?></code></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                    <?php foreach (
                        [
                            '_SESSION',
                            '_GET',
                            '_POST',
                            '_FILES',
                            '_COOKIE',
                            '_SERVER'
                        ] as $var
                    ): ?>
                        <?php
                        if (empty($GLOBALS[$var]) || ! is_array($GLOBALS[$var]))
                        {
                            continue;
                        }
                        ?>
                        <h3><a href="#<?php echo $envId = $errorID . 'environment' . strtolower($var) ?>"
                               onclick="return toggle('<?php echo $envId ?>')">$<?php echo $var ?></a></h3>
                        <div id="<?php echo $envId ?>" class="collapsed">
                            <table cellspacing="0">
                                <?php foreach ($GLOBALS[$var] as $key => $value): ?>
                                    <tr>
                                        <td>
                                            <code><?php echo htmlspecialchars((string) $key, ENT_QUOTES, Sdk::$charset, true); ?></code>
                                        </td>
                                        <td>
                                            <pre><?php echo Debug::dump($value) ?></pre>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </div>
                    <?php endforeach ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
