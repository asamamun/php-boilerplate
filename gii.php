<?php
// gii.php -- Simple CRUD generator for php-boilerplate

if ($argc < 3) {
    echo "Usage: php gii.php ModelName field:type [field:type...]\n";
    exit(1);
}

$modelName = ucfirst($argv[1]);
$fields = array_slice($argv, 2);

$fieldDefs = [];
foreach ($fields as $field) {
    [$name, $type] = explode(':', $field);
    $fieldDefs[] = ['name' => $name, 'type' => $type];
}

// 1. Generate Model
$modelFile = __DIR__ . "/app/Models/{$modelName}.php";
$modelProps = "";
foreach ($fieldDefs as $f) {
    $modelProps .= "    public \${$f['name']};\n";
}
$modelCode = <<<PHP
<?php
namespace App\Models;

class $modelName {
$modelProps
}
PHP;
file_put_contents($modelFile, $modelCode);
echo "Created Model: $modelFile\n";

// 2. Generate Controller
$controllerName = $modelName . "Controller";
$controllerFile = __DIR__ . "/app/Controllers/{$controllerName}.php";
$controllerCode = <<<PHP
<?php
namespace App\Controllers;

use Core\Controller;

class $controllerName extends Controller {
    public function index() {}
    public function create() {}
    public function store() {}
    public function show(\$id) {}
    public function edit(\$id) {}
    public function update(\$id) {}
    public function destroy(\$id) {}
}
PHP;
file_put_contents($controllerFile, $controllerCode);
echo "Created Controller: $controllerFile\n";

// 3. Generate Views
$viewsDir = __DIR__ . "/app/Views/{$modelName}";
@mkdir($viewsDir, 0777, true);
$viewFiles = ['index.php', 'create.php', 'edit.php', 'show.php'];
foreach ($viewFiles as $v) {
    file_put_contents("$viewsDir/$v", "<!-- $v for $modelName -->\n");
    echo "Created View: $viewsDir/$v\n";
}

// 4. Output route definitions
$lcModel = strtolower($modelName);
echo "\nAdd these routes to index.php:\n";
echo <<<ROUTES
// $modelName CRUD
\$router->get('/$lcModel', '{$controllerName}@index');
\$router->get('/$lcModel/create', '{$controllerName}@create');
\$router->post('/$lcModel', '{$controllerName}@store');
\$router->get('/$lcModel/{id}', '{$controllerName}@show');
\$router->get('/$lcModel/{id}/edit', '{$controllerName}@edit');
\$router->post('/$lcModel/{id}', '{$controllerName}@update');
\$router->post('/$lcModel/{id}/delete', '{$controllerName}@destroy');
ROUTES;
echo "\n";