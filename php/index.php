<?

$mysqlhost = getenv('OPENSHIFT_MYSQL_DB_HOST');
$mysqlport = getenv('OPENSHIFT_MYSQL_DB_PORT');
$mysqlusername = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
$mysqlpasswd = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
$postgrehost = getenv('OPENSHIFT_POSTGRESQL_DB_HOST');
$postgreport = getenv('OPENSHIFT_POSTGRESQL_DB_PORT');
$postgreusername = getenv('OPENSHIFT_POSTGRESQL_DB_USERNAME');
$postgrepasswd = getenv('OPENSHIFT_POSTGRESQL_DB_PASSWORD');

$db = getenv('OPENSHIFT_APP_NAME');



if $mysqlhost {

	$mysqli=mysqli_connect("$mysqlhost","$mysqlusername","$mysqlpasswd","$db", $port);
	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }

	/* Select queries return a resultset */
	if ($result = $mysqli->query("SELECT * FROM test LIMIT 10")) {
	    printf("Select returned %d rows. Everything is normal\n", $result->num_rows);
	    /* free result set */
	    $result->close();
	} else {
		printf("Failed check mysql cartridge migration!!!! %s\n", $mysqli->error);
	}
}

if $postgrehost {
	$dbconn = pg_connect("host=$postgrehost user=$postgreusername password=$postgrepasswd dbname=$db port=$postgreport")
	  or die('Could not connect: ' . pg_last_error());

	/* Select queries return a resultset */
	$result = pg_query("SELECT * FROM test LIMIT 10") or die('Failed check postgresql cartridge migration!!!!: ' . pg_last_error());

	printf("Select returned %d rows. Everything is normal\n", $result->num_rows);
	// Free resultset
	pg_free_result($result);

	// Closing connection
	pg_close($dbconn);
}

?>
