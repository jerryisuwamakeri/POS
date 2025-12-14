<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$emails = [
    'admin@cutietyha.ng',
    'salesone@cutietyha.ng',
    'salestwo@cutiehya.ng',
];

foreach ($emails as $e) {
    $u = User::where('email', $e)->first();
    if ($u) {
        echo "{$e}: id={$u->id}, branch_id={$u->branch_id}, roles=" . implode(',', $u->getRoleNames()->toArray()) . PHP_EOL;
    } else {
        echo "{$e}: NOT FOUND" . PHP_EOL;
    }
}
