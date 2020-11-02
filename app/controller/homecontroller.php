<?php
	
	namespace App\Controller;

	use GuzzleHttp\Client;
	use Firebase\JWT\JWT;
	use System\Http\HttpResponse;
	use System\Http\HttpRequest;
	use App\Model\User;

	class HomeController
	{
		public function index () 
		{	
			// Get data from database
			$users = User::query()->all()->get();
			
			$data = [
				[
					'id' => 1,
					'name' => 'ahmed',
					'email' => 'ahmed@gmail.com',
				],
				[
					'id' => 2,
					'name' => 'muhammed',
					'email' => 'muhammed@gmail.com',	
				]
			];

			// Return Response
			$res = (new HttpResponse())
				->type('json')
				->status(200)
				->header('Content-Type', 'application/json')
				->send($data);
			
		}

		public function guzzle ()
		{
			$client = new Client(['base_uri' => 'http://localhost:8080/Restful-Micro-Framework/']);
			$response = $client->request('GET');

			//echo $response->getBody();
			//echo $response->getStatusCode(); // 200
			//echo $response->getReasonPhrase(); // OK
			//echo $response->getProtocolVersion(); // 1.1

			//var_dump($response);
		}

		public function JwtwebToken ()
		{
			$key = "md8yb8ew9d87b87b3978wdybubdy";
			$payload = array(
			    "iss" => "http://example.org",
			    "aud" => "http://example.com",
			    "iat" => 1356999524,
			    "nbf" => 1357000000,
			    "email" => 'ahmedh12491@gmail.com',
			);

			/**
			 * IMPORTANT:
			 * You must specify supported algorithms for your application. See
			 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
			 * for a list of spec-compliant algorithms.
			 */
			$jwt = JWT::encode($payload, $key);
			$decoded = JWT::decode($jwt, $key, array('HS256'));

			$decoded = (array) $decoded;

			var_dump($decoded);
		}

	}
?>