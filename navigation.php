<?php

$page = basename($_SERVER['PHP_SELF']);

?>

<div id="navcontainer">
<ul id="navlist">
<li><a href="index.php"<?php if($page == 'index.php') echo 'id="current"'; ?>>ilri</a></li>
<li><a href="todo.php"<?php if($page == 'todo.php') echo 'id="current"'; ?>>to do</a></li>
<li><a href="people.php" <?php if($page == 'people.php') echo 'id="current"'; ?>>people</a></li>
</ul>
</div>
