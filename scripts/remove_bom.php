<?php
// Remove UTF-8 BOM and leading whitespace before <?php in all .php files under current directory
$root = __DIR__ . '/..';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
$changed = 0;
foreach ($it as $file) {
    if (!$file->isFile()) continue;
    $path = $file->getPathname();
    if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) !== 'php') continue;
    $orig = file_get_contents($path);
    $new = $orig;
    // Remove UTF-8 BOM
    if (substr($new, 0, 3) === "\xEF\xBB\xBF") {
        $new = substr($new, 3);
    }
    // Remove leading whitespace/newlines before <?php
    $new = preg_replace('/^\s+(<\?php)/s', '$1', $new);
    if ($new !== $orig) {
        file_put_contents($path, $new);
        echo "Fixed: $path\n";
        $changed++;
    }
}
if ($changed === 0) {
    echo "No files changed.\n";
} else {
    echo "Total files changed: $changed\n";
}
