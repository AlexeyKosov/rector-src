<div>
    <?php
        for ($i = 5; $i <= count($items); $i++) {
            echo $items[$i];
        }
    ?>
</div>
-----
<div>
    <?php 
$itemsCount = count($items);
for ($i = 5; $i <= $itemsCount; $i++) {
            echo $items[$i];
        }
?>
</div>
