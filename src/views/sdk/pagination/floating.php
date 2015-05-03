<?php

/**
 * First Previous 1 2 3 ... 22 23 24 25 26 [27] 28 29 30 31 32 ... 48 49 50 Next Last
 */

use sdk\Base\Helper\Pagination;

/** @var Pagination $page */
/** @var integer $totalPages */
/** @var integer $currentPage */
/** @var integer $previousPage */
/** @var integer $nextPage */
/** @var integer $firstPage */
/** @var integer $lastPage */

$countOut = ( ! empty($config['count_out'])) ? (int) $config['count_out'] : 3;

// NumberHelper of page links on each side of current page
$countIn = ( ! empty($config['count_in'])) ? (int) $config['count_in'] : 5;

// Beginning group of pages: $n1...$n2
$n1 = 1;
$n2 = min($countOut, $totalPages);

// Ending group of pages: $n7...$n8
$n7 = max(1, $totalPages - $countOut + 1);
$n8 = $totalPages;

// Middle group of pages: $n4...$n5
$n4 = max($n2 + 1, $currentPage - $countIn);
$n5 = min($n7 - 1, $currentPage + $countIn);
$useMiddle = ($n5 >= $n4);

// Point $n3 between $n2 and $n4
$n3 = (int) (($n2 + $n4) / 2);
$useN3 = ($useMiddle && (($n4 - $n2) > 1));

// Point $n6 between $n5 and $n7
$n6 = (int) (($n5 + $n7) / 2);
$useN6 = ($useMiddle && (($n7 - $n5) > 1));

// Links to display as [page => content]
$links = [];

// Generate links data in accordance with calculated numbers
for ($i = $n1; $i <= $n2; $i++)
{
    $links[$i] = $i;
}

if ($useN3)
{
    $links[$n3] = '&hellip;';
}

for ($i = $n4; $i <= $n5; $i++)
{
    $links[$i] = $i;
}

if ($useN6)
{
    $links[$n6] = '&hellip;';
}

for ($i = $n7; $i <= $n8; $i++)
{
    $links[$i] = $i;
}
?>
<p class="pagination">

    <?php if (false === $firstPage): ?>
        <?php echo __('First'); ?>
    <?php else: ?>
        <a href="<?php echo $page->url($firstPage) ?>" rel="first"><?php echo __('First'); ?></a>
    <?php endif; ?>

    <?php if (false === $previousPage): ?>
        <?php echo __('Previous'); ?>
    <?php else: ?>
        <a href="<?php echo $page->url($previousPage) ?>" rel="prev"><?php echo __('Previous'); ?></a>
    <?php endif; ?>

    <?php foreach ($links as $number => $content): ?>

        <?php if ($number === $currentPage): ?>
            <strong><?php echo $content; ?></strong>
        <?php else: ?>
            <a href="<?php echo $page->url($number) ?>"><?php echo $content; ?></a>
        <?php endif ?>

    <?php endforeach; ?>

    <?php if (false === $nextPage): ?>
        <?php echo __('Next'); ?>
    <?php else: ?>
        <a href="<?php echo $page->url($nextPage) ?>" rel="next"><?php echo __('Next'); ?></a>
    <?php endif ?>

    <?php if (false === $lastPage): ?>
        <?php echo __('Last'); ?>
    <?php else: ?>
        <a href="<?php echo $page->url($lastPage) ?>" rel="last"><?php echo __('Last'); ?></a>
    <?php endif; ?>

</p>
