<?php 
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	$app = new \Slim\App;

	// get all customers
	$app->get('/api/customers', function(Request $request, Response $response){
		// query
		$sql = "SELECT * FROM customers";

		// connect to db
		try{
			// get db object
			$db = new db();
			// connect
			$conn = $db->connect();
			// create statement
			$stmt = $conn->query($sql);
			// store all customers
			$customers = $stmt->fetchAll(PDO::FETCH_OBJ);

			$db = null;
			$conn = null;
			
			// return customers as json object
			echo json_encode($customers);
		}
		catch (PDOException $e){
			// output errors as json
			echo "{error: {'text': ". $e->getMessage()."}}";
		}
	});

	// get single customer
	$app->get('/api/customers/{id}', function (Request $request, Response $response){
		$id = $request->getAttribute('id');
		$sql = "SELECT * FROM customers WHERE id = $id";

		try{
			$db = new db();
			$conn = $db->connect();
			$stmt = $conn->query($sql);
			$customer = $stmt->fetchAll(PDO::FETCH_OBJ);
			$db = null;
			$conn = null;

			echo json_encode($customer);
		}
		catch(PDOException $e){
			echo "{error: {'text': ". $e->getMessage()."}}";
		}
	});
 ?>