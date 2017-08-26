<?php
$html .= "<footer>
			<div class='stats'><h1>Newest User</h1>:<br /> {$base->lastRegisteredUser()}</div>
			<div class='stats'><h2>There are a total of ".$base->userCount()." Registered users</h2></div>
</footer>";

?>