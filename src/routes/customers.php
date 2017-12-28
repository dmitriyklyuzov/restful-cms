<?php 
	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;

	$app = new \Slim\App;

	// enable CORS
	$app->options('/{routes:.+}', function ($request, $response, $args) {
		return $response;
	});

	$app->add(function ($req, $res, $next) {
		$response = $next($req, $res);
		return $response
				->withHeader('Access-Control-Allow-Origin', '*')
				->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
				->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
	});

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

	// add customer
	$app->post('/api/customers/add', function (Request $request, Response $response){
		// capture form data
		$firstName = $request->getParam('first_name');
		$lastName = $request->getParam('last_name');
		$phone = $request->getParam('phone');
		$email = $request->getParam('email');
		$address = $request->getParam('address');
		$city = $request->getParam('city');
		$state = $request->getParam('state');

		$sql = "INSERT INTO customers (first_name, last_name, phone, email, address, city, state)
				VALUES (:first_name, :last_name, :phone, :email, :address, :city, :state)";

		try{
			$db = new db();
			$conn = $db->connect();
			// prepare stmt
			$stmt = $conn->prepare($sql);
			// bind params
			$stmt->bindParam(':first_name', $firstName);
			$stmt->bindParam(':last_name', $lastName);
			$stmt->bindParam(':phone', $phone);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':address', $address);
			$stmt->bindParam(':city', $city);
			$stmt->bindParam(':state', $state);
			// execute stmt
			$stmt->execute();
			// echo msg
			echo "{notice: {'text': 'Customer Added'}}";

			$db = null;
			$conn = null;
		}
		catch(PDOException $e){
			echo "{error: {'text': ". $e->getMessage()."}}";
		}
	});

	// update customer
	$app->put('/api/customers/update/{id}', function (Request $request, Response $response){
		// get id
		$id = $request->getAttribute('id');

		// capture form data
		$firstName = $request->getParam('first_name');
		$lastName = $request->getParam('last_name');
		$phone = $request->getParam('phone');
		$email = $request->getParam('email');
		$address = $request->getParam('address');
		$city = $request->getParam('city');
		$state = $request->getParam('state');

		$sql = "UPDATE customers
				SET first_name = :first_name,
					last_name = :last_name,
					phone = :phone,
					email = :email,
					address = :address,
					city = :city,
					state = :state
				WHERE id = $id";

		try{
			$db = new db();
			$conn = $db->connect();
			// prepare stmt
			$stmt = $conn->prepare($sql);
			// bind params
			$stmt->bindParam(':first_name', $firstName);
			$stmt->bindParam(':last_name', $lastName);
			$stmt->bindParam(':phone', $phone);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':address', $address);
			$stmt->bindParam(':city', $city);
			$stmt->bindParam(':state', $state);
			// execute stmt
			$stmt->execute();
			$db = null;
			$conn = null;
			echo "{notice: {'text': 'Customer Updated'}}";
		}
		catch(PDOException $e){
			echo "{error: {'text': ". $e->getMessage()."}}";
		}
	});

	// delete customer
	$app->delete('/api/customers/delete/{id}', function (Request $request, Response $response){
		$id = $request->getAttribute('id');
		$sql = "DELETE FROM customers WHERE id = $id";

		try{
			$db = new db();
			$conn = $db->connect();
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$db = null;
			$conn = null;
			echo "{notice: {'text': 'Customer Deleted'}}";
		}
		catch(PDOException $e){
			echo "{error: {'text': ". $e->getMessage()."}}";
		}
	});

 ?>