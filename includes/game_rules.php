<?php

/* all these need to be behind a signin gate simply because there's an issue where things are showing up as already defined; i'm sure i've got an extra include or required somewhere, but i've yet to find it */




define('TIERID', 30);
define('HEPID', 31);
/* Rest of the Rules */
define("MAPMAX", 64);
define("MISSION_RATIO",512);
define('TECHLEV', $base->getSpecificUpgrade('technology', $_SESSION['user']['uid']));


?>