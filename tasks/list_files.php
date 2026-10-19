<?php // Task 4: list files in a directory (default: this folder; use ?dir=name for a sub-folder)
$base = realpath(__DIR__);
$dir = realpath($base . '/' . ($_GET['dir'] ?? '')) ?: $base;
if (strpos($dir, $base) !== 0) $dir = $base; // prevent directory traversal
echo "<h3>Files in: " . htmlspecialchars($dir) . "</h3><table border='1' cellpadding='6'><tr><th>Name</th><th>Size (bytes)</th><th>Modified</th></tr>";
foreach (scandir($dir) as $f) {
    if ($f === '.' || $f === '..' || is_dir("$dir/$f")) continue;
    echo '<tr><td>' . htmlspecialchars($f) . '</td><td>' . filesize("$dir/$f") . '</td><td>' . date('d-m-Y H:i', filemtime("$dir/$f")) . '</td></tr>';
}
echo '</table>';
