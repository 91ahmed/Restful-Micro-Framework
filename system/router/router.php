<?php
	
	namespace System\Router;

	use App\Middlewares;

	class Router
	{
		private $controller;
		private $action;
		private $routes = array();
		private $url;
		private $method;
		
		public function __construct ()
		{
			$this->url = $this->getUrl();
			$this->method = $_SERVER['REQUEST_METHOD'];
		}
		
		public function get ($route, $pattern, $middleware = null)
		{
			if ($route == '' || $route == '/') {
				$route = '/';
			} else {
				$route = trim($route, '/');
			}

			if ($route === $this->url) {
				if ($this->method === 'GET') {
					$this->routes[] = $route;
					$this->middleware($middleware);
					$this->parsePattern($pattern);
				}
			}
		}
		
		public function post ($route, $pattern, $middleware = null)
		{
			if ($route == '' || $route == '/') {
				$route = '/';
			} else {
				$route = trim($route, '/');
			}

			if ($route === $this->url) {
				if ($this->method === 'POST') {
					$this->routes[] = $route;
					$this->middleware($middleware);
					$this->parsePattern($pattern);
				}
			}
		}
		
		private function parsePattern ($pattern)
		{
			if (is_callable($pattern)) {
				$pattern();
			} else {
				$pattern = explode('@', $pattern, 2);
				$this->controller = $pattern[0];
				$this->action = $pattern[1];
			}

			$this->dispatch();
		}

		private function middleware ($middleware) 
		{
			$md = new Middlewares();

			if (is_string($middleware)) 
			{
				if (!array_key_exists($middleware, $md->container)) {
					$this->notFoundMiddleware($middleware);
				} else {
					return new $md->container[$middleware];
				}
			} 
			elseif (is_array($middleware))
			{
				foreach ($middleware as $key => $value) {
					if (!isset($md->container[$value])) {
						$this->notFoundMiddleware($value);
					} else {
						$key = new $md->container[$value];
					}
				}
			}
		}

		private function notFoundMiddleware ($value)
		{
			exit('Middleware <strong><u>'.$value.'</u></strong> not found.');
			return false;
		}

		private function dispatch ()
		{
			if (!empty($this->controller) && !empty($this->action)) 
			{
				$controller = '\\App\\Controller\\' . ucfirst($this->controller);
				$action = $this->action;

				if (!class_exists($controller)) {
					exit('Controller Not Found');
				} elseif (!method_exists($controller, $action)) {
					exit('Action Not Found');
				} else {
					$object = new $controller();
					$object->$action();	
				}
			}		
		}
		
		/**
		 *	Get application URL
		 *
		 *	@return string
		 */
		private function getUrl (): string
		{
			$route = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
			$route = trim(str_replace($this->rootDir(), '', $route),'/');
			
			if ($route == '') {
				$route = '/';
			}
			
			return $route;
		}

		/**
		 *	Get root directory
		 *
		 *	@return string
		 */
		private function rootDir (): string
		{
			$dir = trim(ROOT, DIRECTORY_SEPARATOR);
			$dir = explode(DIRECTORY_SEPARATOR, $dir);
			$dir = end($dir);
			
			return $dir;
		}

		public function __destruct ()
		{
			if (count($this->routes) < 1) 
			{
				header('HTTP/1.1 404 Not Found', true, 404);
				exit('404 Page Not Found');
			}
		}
	}
?>