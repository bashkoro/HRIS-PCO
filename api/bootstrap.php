<?php

// Bootstrap for Vercel deployment
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Initialize database for serverless environment
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath)) {
    try {
        touch($dbPath);

        // Run migrations and seeders
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->call('migrate:fresh', ['--force' => true]);
        $kernel->call('db:seed', ['--class' => 'HRISSeeder', '--force' => true]);
        $kernel->call('db:seed', ['--class' => 'HakKeuanganSeeder', '--force' => true]);
        $kernel->call('db:seed', ['--class' => 'BuktiPotongPajakSeeder', '--force' => true]);
    } catch (Exception $e) {
        // Silently handle database initialization errors
        error_log('Database initialization failed: ' . $e->getMessage());
    }
}

return $app;