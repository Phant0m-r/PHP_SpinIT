<?php

    function notification( string $message = null )
    {
        if ($message): ?>
        <div class="message">
            <?= $message?>
        </div>
    <?php
        endif;
    }
?>

