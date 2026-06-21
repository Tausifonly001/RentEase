<?php
declare(strict_types=1);

namespace RentEase\Support;

class ImageOptimizer
{
    private string $cacheDir;
    private string $sourceDir;

    public function __construct()
    {
        $this->sourceDir = __DIR__ . '/../../../assets/images';
        $this->cacheDir = __DIR__ . '/../../../storage/cache/images';
        if (!is_dir($this->cacheDir)) {
            @mkdir($this->cacheDir, 0755, true);
        }
    }

    public function serveWebP(string $imagePath): void
    {
        $ext = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        $allowed = ['png', 'jpg', 'jpeg', 'gif'];
        if (!in_array($ext, $allowed, true)) {
            $this->serveFallback($imagePath);
            return;
        }

        $webpPath = $this->getWebPCachePath($imagePath);
        $acceptsWebP = !empty($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'image/webp');

        if ($acceptsWebP && file_exists($webpPath)) {
            $this->sendImage($webpPath, 'image/webp');
            return;
        }

        if ($acceptsWebP && extension_loaded('gd')) {
            $this->convertToWebP($imagePath, $webpPath);
            if (file_exists($webpPath)) {
                $this->sendImage($webpPath, 'image/webp');
                return;
            }
        }

        $this->serveFallback($imagePath);
    }

    private function getWebPCachePath(string $sourcePath): string
    {
        $hash = md5_file($sourcePath) ?: md5($sourcePath);
        $name = pathinfo($sourcePath, PATHINFO_FILENAME);
        return $this->cacheDir . '/' . $name . '_' . $hash . '.webp';
    }

    private function convertToWebP(string $source, string $dest): void
    {
        $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));
        $img = null;

        if ($ext === 'png') {
            $img = @imagecreatefrompng($source);
            if ($img) {
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
            }
        } elseif (in_array($ext, ['jpg', 'jpeg'], true)) {
            $img = @imagecreatefromjpeg($source);
        }

        if ($img) {
            @imagewebp($img, $dest, 82);
            imagedestroy($img);
            @chmod($dest, 0644);
        }
    }

    private function serveFallback(string $path): void
    {
        if (!file_exists($path)) {
            http_response_code(404);
            exit;
        }
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = $ext === 'png' ? 'image/png' : ($ext === 'gif' ? 'image/gif' : 'image/jpeg');
        $this->sendImage($path, $mime);
    }

    private function sendImage(string $path, string $mime): void
    {
        $stat = stat($path);
        $etag = '"' . ($stat ? md5_file($path) : md5($path)) . '"';
        $mtime = $stat ? $stat['mtime'] : time();

        header('Content-Type: ' . $mime);
        header('Cache-Control: public, max-age=31536000, immutable');
        header('ETag: ' . $etag);
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $mtime) . ' GMT');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');

        if (!empty($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) === $etag) {
            http_response_code(304);
            exit;
        }

        readfile($path);
        exit;
    }
}
