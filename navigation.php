<?php

$page = basename($_SERVER['PHP_SELF']);

?>

<div id="navcontainer">
<ul id="navlist">
<li><a href="http://www.ilri.org/" title="Home"?>Home</a></li>
<li><a href="todo.php"<?php if($page == 'todo.php') echo 'id="current"'; ?>>To do</a></li>
<li><a href="people.php" <?php if($page == 'people.php') echo 'id="current"'; ?>>People</a></li>
</ul>
</div>
