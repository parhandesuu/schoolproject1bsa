<?php

$allRoutes = collect(Route::getRoutes()->getRoutesByName())->keys()->toArray();
$files = File::allFiles(resource_path('views'));
$errors = [];

foreach($files as $file) {
    // Only check blade files
    if (str_ends_with($file->getFilename(), '.blade.php')) {
        $content = file_get_contents($file->getPathname());
        
        // Find all route('name', ...) usages
        preg_match_all('/route\(\s*[\'"]([^\'"]+)[\'"]/', $content, $matches);
        if(!empty($matches[1])) {
            foreach($matches[1] as $route) {
                // If route does not exist in registered routes, mark it as error
                if(!in_array($route, $allRoutes)) {
                    $errors[] = [
                        'file' => $file->getRelativePathname(), 
                        'route' => $route
                    ];
                }
            }
        }
    }
}
echo json_encode(['all_views_route_errors' => array_unique($errors, SORT_REGULAR)], JSON_PRETTY_PRINT);
