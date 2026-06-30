<?php
echo "<h2>Looking for main website file...</h2>";

$parent_dir = __DIR__ . '/../';
$files = scandir($parent_dir);

echo "<h3>Files in parent directory (/laundry-website/):</h3>";
echo "<ul>";
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "<li>$file</li>";
    }
}
echo "</ul>";

echo "<h3>Try these links:</h3>";
echo "<ul>";
echo "<li><a href='../index.html'>../index.html</a></li>";
echo "<li><a href='../index.php'>../index.php</a></li>";
echo "<li><a href='../home.html'>../home.html</a></li>";
echo "<li><a href='../home.php'>../home.php</a></li>";
echo "<li><a href='../'>../ (parent directory)</a></li>";
echo "</ul>";
?>