<?php
include('db.php');
$sql = "UPDATE map SET currentOwner = -1 ORDER BY RAND() LIMIT 2";