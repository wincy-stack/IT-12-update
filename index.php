<?php

// Vercel only has a writable /tmp, so make sure Laravel's storage dirs exist there.
foreach ([
    '/tmp/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
] as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Hand off to Laravel's normal front controller.
require __DIR__ . '/../public/index.php';
