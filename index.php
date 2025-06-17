<?php
$dir = __DIR__;
$files = scandir($dir);

echo "<h2>Files in /ecommerce/</h2><ul>";
foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $path = htmlspecialchars($file);
    echo "<li><a href='$path'>$path</a></li>";
}
echo "</ul>";
?>