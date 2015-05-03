<?php

/** @var string $task */
/** @var string $description */
/** @var array $tags */

?>

Usage
=======
php minion.php --task=<?php echo $task; ?> [--option1=value1] [--option2=value2]

Details
=======
<?php foreach ($tags as $tagName => $tagContent): ?>
    <?php echo ucfirst($tagName) ?>: <?php echo $tagContent ?>

<?php endforeach; ?>

Description
===========
<?php echo $description; ?>


