<html>
<body>


<form method=post action=index.php>
<b>Create New Site</b><br>
Domain* 
<p>www.<input type=text name=domain value='' placeholder='Domain'></p><br>
<input type=submit name=submit value=submit>
</form>
<hr>
<?php
include_once ("params.php");

$host = file_get_contents('/etc/hosts');

$nginx = file_get_contents('/etc/nginx/nginx.conf');

if(isset($_POST['domain']) && !empty($_POST['domain']))
{
	$exist_domain = false;
	
	$domain = $_POST['domain'];

	$domain_file = (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'domains.php');
	$domain_configs = include $domain_file;
	
	foreach ($domain_configs as $domain_config)
	{
		if($domain_config['domain'] == $domain)
		{
			$exist_domain = true;
		}
	}
	
	$db_file = (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'db_console_config.php');
	$db_configs = include $db_file;
	
	if($exist_domain)
	{
		echo 'This domain existed.';
	}
	else
	{
		//database name
		$database_name = explode('.', $domain);
		$database_name = $database_name[0];
		
		//local
		$con=mysqli_connect($database_host, $database_username_root, $database_password_root);
		
		//create database
		$sql="GRANT ALL PRIVILEGES ON " .$database_name . ".* TO '" . $database_username . "'@'localhost' WITH GRANT OPTION;";
		$sql.='DROP DATABASE IF EXISTS ' . $database_name . ';';
		$sql.='CREATE DATABASE ' . $database_name . ';';
		$sql.='USE ' . $database_name . ';';
	
 		$sql.=file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tutors-24-4-2013.sql');
 		
 		//insert admin account
 		$sql.="INSERT INTO `accounts` (`email`, `first_name`, `last_name`, `password`, `status`, `role`) VALUES ('admin@" . $domain . "', 'Admin', 'Admin', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');";
 		
 		$sql = explode(';', $sql);
 		
 		$success = true;
 		foreach ($sql as $idx => $query)
 		{ 
 			if($idx != 4 && $query != '')
 			{
 				if (!mysqli_query($con,$query))
 				{
 					$success = false;
 					echo "Error : " . mysqli_error($con) . '<br/> -------------------------';
 				}
 			}
 			
 		}
 		
 		if($success)
 		{
//  		$command = 'mysql -h localhost -u root -p ' . $database_name . ' < ' . dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tutors-24-4-2013.sql';
//  		system($command);
 			
 			$domain_configs[] = array('domain'=>$domain, 'db_name'=>$database_name);
 			
 			$db_configs['db_' . $database_name] = array(
				'connectionString' => 'mysql:host='.$database_host.';dbname=' . $database_name,
				'emulatePrepare' => true,
				'username' => $database_username,
				'password' => $database_password,
				'charset' => 'utf8',
				'class' => 'CDbConnection'
			);
 			
//  		rewrite domains array
 			file_put_contents($domain_file, "<?php return " . var_export($domain_configs,true) . ";");
 			
 			//rewrite db config array for cronjob
 			file_put_contents($db_file, "<?php return " . var_export($db_configs,true) . ";");
 			
 			//rewrite host file 192.155.80.158
 			$host .= '192.155.80.158 www.' . $domain . ' ' . $domain . ' 
192.155.80.158 admin.' . $domain . '
';
 			
 			file_put_contents('/etc/hosts', $host);
 			
 			//rewrite nginx config
 			$nginx = substr($nginx, 0, strlen($nginx)-3);
 			
 			$nginx .= '
	        server {
	                server_name .' . $domain .';
	                listen 192.155.80.158;
	                root /home/melbournetutor/public_html/frontend;
	                index index.php index.html;
	                access_log /var/log/virtualmin/melbournetutor.org_access_log;
                	error_log /var/log/virtualmin/melbournetutor.org_error_log;
	              #fastcgi_param GATEWAY_INTERFACE CGI/1.1;
	                #fastcgi_param SERVER_SOFTWARE nginx;
	                fastcgi_param QUERY_STRING $query_string;
	                fastcgi_param REQUEST_METHOD $request_method;
	                fastcgi_param CONTENT_TYPE $content_type;
	                fastcgi_param CONTENT_LENGTH $content_length;
	                fastcgi_param SCRIPT_FILENAME /home/melbournetutor/public_html/frontend$fastcgi_script_name;
	                fastcgi_param SCRIPT_NAME $fastcgi_script_name;
	                fastcgi_param REQUEST_URI $request_uri;
	                fastcgi_param DOCUMENT_URI $document_uri;
	                fastcgi_param DOCUMENT_ROOT /home/melbournetutor/public_html/frontend;
	                fastcgi_param SERVER_PROTOCOL $server_protocol;
	                fastcgi_param REMOTE_ADDR $remote_addr;
	                fastcgi_param REMOTE_PORT $remote_port;
	                fastcgi_param SERVER_ADDR $server_addr;
	                fastcgi_param SERVER_PORT $server_port;
	                fastcgi_param SERVER_NAME $server_name;
	                fastcgi_param  PATH_INFO        $fastcgi_path_info;
	                location / {
	                        try_files $uri $uri/ /index.php?$args;
	                }
	
	                location ~ \.php$ {
	                        try_files $uri =404;
	                        fastcgi_pass localhost:9000;
	                }
	
	        }
 			server {
                server_name admin.' . $domain . ';
                listen 192.155.80.158;
                root /home/melbournetutor/public_html/backend;
                index index.php index.html;
                access_log /var/log/virtualmin/melbournetutor.org_access_log;
                error_log /var/log/virtualmin/melbournetutor.org_error_log;
              #fastcgi_param GATEWAY_INTERFACE CGI/1.1;
                #fastcgi_param SERVER_SOFTWARE nginx;
                fastcgi_param QUERY_STRING $query_string;
                fastcgi_param REQUEST_METHOD $request_method;
                fastcgi_param CONTENT_TYPE $content_type;
                fastcgi_param CONTENT_LENGTH $content_length;
                fastcgi_param SCRIPT_FILENAME /home/melbournetutor/public_html/backend$fastcgi_script_name;
                fastcgi_param SCRIPT_NAME $fastcgi_script_name;
                fastcgi_param REQUEST_URI $request_uri;
                fastcgi_param DOCUMENT_URI $document_uri;
                fastcgi_param DOCUMENT_ROOT /home/melbournetutor/public_html/backend;
                fastcgi_param SERVER_PROTOCOL $server_protocol;
                fastcgi_param REMOTE_ADDR $remote_addr;
                fastcgi_param REMOTE_PORT $remote_port;
                fastcgi_param SERVER_ADDR $server_addr;
                fastcgi_param SERVER_PORT $server_port;
                fastcgi_param SERVER_NAME $server_name;
                fastcgi_param  PATH_INFO        $fastcgi_path_info;
                location / {
                        try_files $uri $uri/ /index.php?$args;
                }

                location ~ \.php$ {
                        try_files $uri =404;
                        fastcgi_pass localhost:9000;
                }

	        }';
 			
 			$nginx .= '
 						}';
 		
 			file_put_contents('/etc/nginx/nginx.conf', $nginx);
 				
 			echo 'Adding a new site successfully.';

 		}
	}
}

?>

<h3><strong>Added Sites</strong></h3>
<hr/>
<ul style="list-style-type: decimal;">
	<?php 
		$domain_file = (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'domains.php');
		$domains = include $domain_file;
		
		foreach ($domains as $domain_name)
		{
			if($domain_name['domain'] != 'melbournetutor.com')
			{
				echo '<li><a href="http://www.' . $domain_name['domain'] . '" target="_blank">' . $domain_name['domain'] . '</a></li>';
			}
			
		}
	?>
</ul>
</body>
</html>
