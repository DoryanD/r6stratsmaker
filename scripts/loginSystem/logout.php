
<?php
include_once "../classes/Defines.php";
    session_start();
    session_unset();
    session_destroy();

    echo INDEX_PAGE_LOCATION;
?>