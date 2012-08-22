<?php
require '../app/vendor/autoload.php';

// Prepare app
$app = new Slim(array(
    'log.level' => 4,
    'log.enabled' => true,
    'log.writer' => new Log_FileWriter(array(
        'path' => '../app/logs',
        'name_format' => 'y-m-d'
    ))
));


$app->post('/', function () use ($app) {
		
	$log = $app->getLog();
	$request = Slim::getInstance()->request();
	$response = $app->response();
	$response['Content-Type'] = 'application/json';
	$body = $request->getBody();
	
	// TODO split files based on hash
	
	try {
		
		// There should never be a case where we receive an empty body from DataSift
		if(strlen($body) === 0 ){	
			$app->response()->status(400);
			$response->body('{"error": 400: Bad Request}');
			return;
		}
		
		// Is this a DataSift test payload?
		if($body=== '{}'){
			$log->debug("DEBUG: DataSift test message recived.");
			$response->body('{"success": true}');
			return;
		}	
			
		$json = json_decode($body, TRUE);
		foreach ( $json['interactions'] as $index => $val )
		{		
			_writeData($json['hash'], json_encode($val));  
			$log->debug("DEBUG: Interaction saved.");
		}

	} catch (Exception $e) {
		    	
	    $log = $app->getLog();
		$log->error("ERROR: " . $e->getMessage());

	}
	
	// Send the expected response to DataSift
	$response->body('{"success": true}');
});

// Run app
$app->run();


	function _writeData($file_name, $data){
			
		try {	
			$myFile = "../app/data/" . $file_name . ".txt";
			$fh = fopen($myFile, 'a') or die("can't open file");
			$stringData = $data . "\n";
			fwrite($fh, $stringData);
			fclose($fh);
				
		} catch (Exception $e) {
		    	
		    $log = $app->getLog();
			$log->error("ERROR: " . $e->getMessage());

		}
	}

/*
	function _getConnection() {
	    $dbhost="127.0.0.1";
	    $dbuser="root";
	    $dbpass="";
	    $dbname="cellar";
	    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    return $dbh;
	}
*/