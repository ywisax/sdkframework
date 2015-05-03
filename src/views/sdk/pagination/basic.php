<?php

use sdk\Base\Helper\Pagination;

/** @var Pagination $page */
/** @var mixed $firstPage */
/** @var mixed $previousPage */
/** @var mixed $nextPage */
/** @var mixed $lastPage */
/** @var int $totalPages */
/** @var int $currentPage */

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
        <a href="<?php echo $page->url($previousPage) ?>"
           rel="prev"><?php echo __('Previous'); ?></a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>

        <?php if ($i == $currentPage): ?>
            <strong><?php echo $i; ?></strong>
        <?php else: ?>
            <a href="<?php echo $page->url($i) ?>"><?php echo $i; ?></a>
        <?php endif; ?>

    <?php endfor; ?>

    <?php if (false === $nextPage): ?>
        <?php echo __('Next') ?>
    <?php else: ?>
        <a href="<?php echo $page->url($nextPage) ?>" rel="next"><?php echo __('Next'); ?></a>
    <?php endif; ?>

    <?php if (false === $lastPage): ?>
        <?php echo __('Last'); ?>
    <?php else: ?>
        <a href="<?php echo $page->url($lastPage) ?>" rel="last"><?php echo __('Last'); ?></a>
    <?php endif; ?>

</p>
