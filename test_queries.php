<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\DB::listen(function($query) {
    if ($query->time > 10) {
        // file_put_contents('slow_queries.log', $query->time . 'ms - ' . $query->sql . "\n", FILE_APPEND);
    }
});
// Let's test the query fetching vehicle models
$start = microtime(true);
\App\Models\VehicleModel::with('brand')->get();
$end = microtime(true);
echo "Models query took: " . ($end - $start) . " seconds\n";

$start = microtime(true);
\App\Models\VehicleVersion::with('vehicleModel.brand')->get();
$end = microtime(true);
echo "Versions query took: " . ($end - $start) . " seconds\n";

