<div id='warehouseItems'>
<?php echo $base->userItemInv($_SESSION['user']['uid']); ?>
</div>
<?php
$base->userResourceInv($_SESSION['user']['uid']);
?>