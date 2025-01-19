<?php

use Illuminate\Contracts\Console\Kernel;

// Memuat autoload Laravel
require __DIR__ . '/../../../vendor/autoload.php';

// Bootstrap aplikasi Laravel
$app = require __DIR__ . '/../../../bootstrap/app.php';

/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(Kernel::class);

// Fungsi untuk menangani HTTP request dalam mode worker
function handleRequests() use ($kernel) {
    while (true) {
        // Menangani satu request secara langsung
        $kernel->handle(
            $kernel->getArtisan()->resolve('Illuminate\Http\Request', true)
        );
        
        // Tambahkan penundaan agar tidak memakan banyak CPU
        usleep(500000); // 500ms
    }
}

// Panggil fungsi untuk menangani request
handleRequests();
