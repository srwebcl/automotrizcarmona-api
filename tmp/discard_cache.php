<?php
use Illuminate\Support\Facades\DB;
DB::statement('DISCARD ALL');
echo "Postgres cache discarded.\n";
