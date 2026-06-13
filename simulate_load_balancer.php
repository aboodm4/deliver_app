<?php

// array of available server instances (nodes)
$servers = [
    "http://127.0.0.1:8000/api/node-status",
    "http://127.0.0.1:8001/api/node-status",
    "http://127.0.0.1:8002/api/node-status"
];

echo "Starting Real HTTP Load Balancer Simulation...\n";
echo "Sending requests using Round-Robin algorithm:\n\n";

// We simulate 6 tasks coming from clients
for ($taskIndex = 1; $taskIndex <= 6; $taskIndex++) {
    // Simple Round-Robin algorithm to select a server
    $serverIndex = ($taskIndex - 1) % count($servers);
    $selectedServer = $servers[$serverIndex];

    // Simulate real HTTP Request
    $response = @file_get_contents($selectedServer);

    if ($response !== false) {
        echo "Request {$taskIndex}: {$response}\n";
    } else {
        echo "Request {$taskIndex}: Failed! Is the server on {$selectedServer} running?\n";
    }

    usleep(500000); // Wait 0.5s between tasks to simulate time passing
}

echo "\nSimulation Finished.\n";
