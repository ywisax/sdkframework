Console is a cli tool for performing tasks

Usage

<?php echo $_SERVER['argv'][0]; ?> {task} --task=[options]

Where {task} is one of the following:

<?php
/** @var array $tasks */
foreach ($tasks as $task)
{
    ?>
    * <?php echo $task; ?>

<?php
}
?>

For more information on what a task does and usage details execute

<?php echo $_SERVER['argv'][0]; ?> --task={task} --help

