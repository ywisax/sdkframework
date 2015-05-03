<?php

use sdk\Html\Tag\A;
use sdk\Html\Tag\Li;
use sdk\Html\Tag\Span;

/** @var integer $currentPage */
/** @var integer $previousPage */
/** @var integer $nextPage */
/** @var integer $lastPage */
/** @var integer $totalPages */
/** @var sdk\Base\Helper\Pagination $page */

?>
<div class="pagination pagination-centered">
    <ul>
        <?php
        if (false !== $previousPage)
        {
            echo new Li([], new A([
                'href'      => $page->url($previousPage),
                'class'     => 'previous',
                'data-page' => $previousPage
            ], __('&laquo;')));
        }

        if ($totalPages < 8)
        {
            /* « Previous  1 2 3 4 5 6 7 8 9 10 11 12  Next » */
            for ($i = 1; $i <= $totalPages; $i++)
            {
                $liAttributes = [];
                $aAttributes = ['data-page' => $i];
                if ($i == $currentPage)
                {
                    $liAttributes['class'] = 'active';
                }
                else
                {
                    $aAttributes['href'] = $page->url($i);
                }
                echo new Li($liAttributes, new A($aAttributes, $i));
            }
        }
        elseif ($currentPage < 4)
        {
            /* « Previous  1 2 3 4 5 6 7 8 9 10 … 25 26  Next » */
            for ($i = 1; $i <= 5; $i++)
            {
                $liAttributes = [];
                $aAttributes = ['data-page' => $i];
                if ($i == $currentPage)
                {
                    $liAttributes['class'] = 'active';
                }
                else
                {
                    $aAttributes['href'] = $page->url($i);
                }
                echo new Li($liAttributes, new A($aAttributes, $i));
            }

            echo new Li(['class' => 'disabled'], new Span([], '&hellip;'));
            echo new Li([], new A([
                'href'      => $page->url($lastPage - 1),
                'data-page' => $lastPage - 1
            ], $lastPage - 1));
            echo new Li([], new A([
                'href'      => $page->url($lastPage),
                'data-page' => $lastPage,
            ]), $lastPage);
        }
        elseif ($currentPage > $totalPages - 3)
        {
            /* « Previous  1 2 … 17 18 19 20 21 22 23 24 25 26  Next » */
            echo new Li([], new A([
                'href'      => $page->url(1),
                'data-page' => 1,
            ], 1));
            echo new Li([], new A([
                'href'      => $page->url(2),
                'data-page' => 2,
            ], 1));
            echo new Li(['class' => 'disabled'], new Span([], '&hellip;'));
            for ($i = $totalPages - 4; $i <= $totalPages; $i++)
            {
                $liAttributes = [];
                $aAttributes = ['data-page' => $i];
                if ($i == $currentPage)
                {
                    $liAttributes['class'] = 'active';
                }
                else
                {
                    $aAttributes['href'] = $page->url($i);
                }
                echo new Li($liAttributes, new A($aAttributes, $i));
            }
        }
        else
        {
            /* « Previous  1 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26  Next » */
            echo new Li([], new A([
                'href'      => $page->url(1),
                'data-page' => 1,
            ], 1));
            echo new Li(['class' => 'disabled'], new Span([], '&hellip;'));
            //for ($i = $currentPage - 5; $i <= $currentPage + 5; $i++)
            for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++)
            {
                $liAttributes = [];
                $aAttributes = ['data-page' => $i];
                if ($i == $currentPage)
                {
                    $liAttributes['class'] = 'active';
                }
                else
                {
                    $aAttributes['href'] = $page->url($i);
                }
                echo new Li($liAttributes, new A($aAttributes, $i));
            }
            echo new Li(['class' => 'disabled'], new Span([], '&hellip;'));
            echo new Li([], new A([
                'href'      => $page->url($lastPage),
                'data-page' => $lastPage,
            ]), $lastPage);
        }

        if (false !== $nextPage)
        {
            echo new Li([], new A([
                'href'      => $page->url($nextPage),
                'class'     => 'next',
                'data-page' => $nextPage
            ], __('&raquo;')));
        }
        ?>
    </ul>
</div>
