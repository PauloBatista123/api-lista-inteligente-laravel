<?php

use App\Models\JobStatus;

return [
    'model' => JobStatus::class,
    'event_manager' => \Imtigger\LaravelJobStatus\EventManagers\DefaultEventManager::class,
    'database_connection' => null
];
