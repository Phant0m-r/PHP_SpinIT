<pre>
    <?php
    function showVardump()
    {
        if ($_GET) {
            var_dump($_GET);
        } else {
            var_dump($_POST);
        }
    }
    ?>
</pre>