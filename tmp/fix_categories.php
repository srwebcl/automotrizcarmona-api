<?php

use App\Models\VehicleModel;

foreach (VehicleModel::all() as $model) {
    if (is_string($model->category) && !str_starts_with($model->category, '[')) {
        echo "Converting category for model {$model->name}: {$model->category} -> [" . $model->category . "]\n";
        $model->category = [$model->category];
        $model->save();
    }
}
