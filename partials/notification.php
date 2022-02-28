<?php

    function notification( $message )
    {
        if ($message): ?>
        <div class="message">
            <?= $message?>
        </div>
    <?php
        endif;
    }
?>

