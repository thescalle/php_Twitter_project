<?php
session_start();
// demarage de la session, vus que c'est de ce fichier que tout pars,
// elle est automatiquement load partout



require_once __DIR__ . '/src/App.php';
require_once __DIR__ . '/Routing.php';



$app = new App();
$routing = new Routing($app);
$routing->setup();

return $app;