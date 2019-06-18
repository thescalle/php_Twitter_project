<?php


abstract class ControllerBase
{
    /**
     * @var \CityModel
     */
    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }

    protected function render(String $template, Array $params = []) {

        if($template === '404') {
            header("HTTP/1.0 404 Not Found");
        }

        ob_start();
        include __DIR__ . '/../view/' . $template . '.php';
        ob_end_flush();
        die();
    }

    protected function redirect($location) {
        header("Location: $location");
        die();
    }
}