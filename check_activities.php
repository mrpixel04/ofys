<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$activities = DB::table('activities')->get();

if ($activities->isEmpty()) {
    echo "No activities found in the table.\n";
} else {
    echo "Found " . $activities->count() . " activities.\n";
    foreach ($activities as $activity) {
        echo "ID: {$activity->id}, Name: {$activity->name}, Type: {$activity->activity_type}\n";
    }
}