<?php

require_once __DIR__ . '/route/Route.php';

class App
{
	const GET = "GET";
	const POST = "POST";
	const PUT = "PUT";
	const DELETE = "DELETE";
	
	/**
	 * @var array
	 */
	private $routes = array();
	
	/**
	 * @var statusCode
	 */
	private $statusCode;
	


	public function get(string $pattern, callable $callable){
		$this->registerRoute(self::GET, $pattern, $callable);
		return $this;
	}
	public function post(string $pattern, callable $callable){
		$this->registerRoute(self::POST, $pattern, $callable);
		return $this;
	}


	
	/**
	 * Check which route to use inside the router
	 *
	 * @throws HttpException
	 */
	public function run(){



		$method = $_SERVER['REQUEST_METHOD'] ?? self::GET;
		$uri = substr($_SERVER['REQUEST_URI'], 10) ?? '/';



		foreach($this->routes as $route){
			if($route->match($method, $uri)){
				return $this->process($route);
			}
		}
		
		throw new Error('No routes available for this uri');
	}
	
	/**
	 * Process route
	 *
	 * @param Route $route
	 * @throws HttpException
	 */
	private function process(Route $route){
		try{
			http_response_code($this->statusCode);
			echo call_user_func_array($route->getCallable(), $route->getArguments());
		}catch(HttpException $e){
			throw $e;
		}catch(\Exception $e){
			throw new Error('There was an error during the processing of your request');
		}
	}
	
	/**
	 * Register a route in the routes array
	 *
	 * @param string $method
	 * @param string $pattern
	 * @param callable $callable
	 */
	private function registerRoute(string $method, string $pattern, callable $callable){
		$this->routes[] = new Route($method, $pattern, $callable);
	}
}