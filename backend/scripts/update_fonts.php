<?php

declare(strict_types=1);

$directory = __DIR__ . '/../public';

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    $content = file_get_contents($path);
    $original = $content;

    // 1. Replace all heavy font weights with font-normal
    $content = preg_replace('/\bfont-(black|bold|semibold|medium)\b/', 'font-normal', $content);

    // 2. Adjust small text to use font-light
    $content = preg_replace_callback('/class="([^"]*)"/', function ($matches) {
        $classes = $matches[1];
        
        // If the element has a small text class
        if (preg_match('/\btext-(xs|sm|\[\d+px\])\b/', $classes)) {
            // If it now has font-normal (from step 1 or previously), change to font-light
            if (preg_match('/\bfont-normal\b/', $classes)) {
                $classes = preg_replace('/\bfont-normal\b/', 'font-light', $classes);
            } else if (!preg_match('/\bfont-(light|thin|extralight)\b/', $classes)) {
                // If it had no font weight explicitly set, add font-light
                $classes .= ' font-light';
            }
        }
        
        return 'class="' . $classes . '"';
    }, $content);

    if ($content !== $original) {
        file_put_contents($path, $content);
        echo "Updated: " . $file->getFilename() . "\n";
    }
}

echo "Font update complete.\n";
