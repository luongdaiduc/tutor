<html>
<body>


<form method=post action='update_database.php'>
<b>Update Database</b><br>
MySql Query* 
<p><textarea name='sql' placeholder='MySql Query' cols='50' rows='10'></textarea></p><br>
<input type=submit name=submit value='Update'>
</form>
<hr>
<?php
include_once ("params.php");

if(isset($_POST['sql']) && !empty($_POST['sql']))
{
	$domain_file = (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'domains.php');
	$domain_configs = include $domain_file;
	
	$sql = $_POST['sql'];
	
	foreach ($domain_configs as $domain_config)
	{
		if($domain_config['domain'] != 'melbournetutor.com')
		{
			$mysqli = new mysqli($database_host, $database_username, $database_password, $domain_config['db_name']);
			
			if ($mysqli->connect_errno) {
				echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			}
			
			if ($mysqli->multi_query($sql)) {
				do
				{
					if (!$mysqli->more_results()) {
						break;
					}
					if (!$mysqli->next_result()) {
						echo "Stopped while retrieving result : ".$mysqli->error;
						break;
					}
				} while (true);
			}
		}
		
	}
	
	//update sql file
	$sql_file_content=file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tutors-24-4-2013.sql');
	$sql_file_content.=$sql;
	file_put_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tutors-24-4-2013.sql', $sql_file_content);
	
}

?>

</body>
</html>
