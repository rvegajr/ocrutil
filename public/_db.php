<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
// Check PHP version.
$minPhpVersion = '7.4'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    exit($message);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Config\Paths();

// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

/*
PHP Factory Generator is a code generating tool. It will make objects out
of all the tables in a specified MYSQL database in a single file. It creates interfaces to the MYSQL as well.
It makes the functions: Create, CreateUpdate, Update, Retrieve and Delete functions
for every table in a database and stores them in the file.
This file allows a developer to use database tables like other PHP objects
and allows them to not worry about connecting to the MYSQL database
and closing connections. The code is all generated for you.

*/

// the initial variables
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir")
                    rrmdir($dir."/".$object);
                else unlink   ($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}
// the username that has access to the database
$username = 'root';
// password to the username
$password = 'root';
// the url of the database
$host = '127.0.0.1';
// The database to create functions for
$seldatabase = 'ocrutil';
$port=3307;
// The location to store the created files
$file_path = $paths->writableDirectory.'/ocrutildb_helper.php';
rrmdir($file_path);

//connect to the database
$databases = array();
$connection = new mysqli($host, $username, $password, "information_schema", $port);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
// Get all the databases in teh table schema
$query = "SELECT DISTINCT TABLE_SCHEMA FROM TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND ENGINE = 'MyISAM' AND TABLE_SCHEMA <> 'mysql'";
$result = $connection->query($query);
while ($obj = $result->fetch_object()) {
    $databases[] = $obj->TABLE_SCHEMA;
}

// Get all the tables for the selected database
$query = "SELECT DISTINCT TABLE_NAME FROM TABLES WHERE TABLE_SCHEMA = '$seldatabase'";
$result = $connection->query($query);
while ($obj = $result->fetch_object()) {
    $tables[] = $obj->TABLE_NAME;
}

// Start the generated string
$tablestring = '<?php
	//This is PHP Generated Code From AutomatePHPMySQL. Be Careful editing this code, functions may become unstable. If you made a change to your database, recreate this file.';

// Create the classe for each of the tables in the database
foreach ($tables as $tab) {
    $tablestring .= '
	class '.$tab.'Object{';
    $query = "SELECT * FROM COLUMNS WHERE TABLE_NAME = '$tab' AND TABLE_SCHEMA = '$seldatabase'";
    $result = $connection->query($query);
    $all_columns = array();
    while ($obj = $result->fetch_object()) {
        $tablestring .= 'public $'.$obj->COLUMN_NAME.';';
    }
    $tablestring .= '}
	';
}
// Add the connection info to the file
$tablestring .= '
	class '.$seldatabase.'
	{
	private static $username = "'.$username.'";
	private static $password = "'.$password.'";
	private static $database = "'.$seldatabase.'";
	private static $host = "'.$host.'";
	private static $port = "'.$port.'";
	public static function Init()
    {
        $db = \Config\Database::connect();
        ocrutil::$username = $db->username;
        ocrutil::$password = $db->password;
        ocrutil::$database = $db->database;
        ocrutil::$host = $db->hostname;
        ocrutil::$port = $db->port;
    }
';

// Get the info about all the columns in the tables and create arrays for easy reference later
foreach ($tables as $tab) {
    $query = "SELECT * FROM COLUMNS WHERE TABLE_NAME = '$tab' AND TABLE_SCHEMA = '$seldatabase'";
    $result = $connection->query($query);
    $main_columns = array();
    $all_columns = array();
    $key = null;
    while ($obj = $result->fetch_object()) {
        $column = new stdClass();
        $column->name = $obj->COLUMN_NAME;
        if (strpos($obj->COLUMN_TYPE, 'int') !== false) {
            $column->type = 'i';
        } else if (strpos($obj->COLUMN_TYPE, 'dec') !== false || strpos($obj->COLUMN_TYPE, 'flo') !== false) {
            $column->type = 'd';
        } else {
            $column->type = 's';
        }
        if (strpos($obj->COLUMN_KEY, 'PRI') !== false) {
            $key = $column;
            if (strpos($obj->EXTRA, 'auto_increment') !== false) {
                $key->auto = true;
            } else
                $key->auto = false;
        } else {
            $main_columns[] = $column;
        }
        if (strpos($obj->COLUMN_KEY, 'PRI') === false && strpos($obj->EXTRA, 'auto_increment') !== false) {
            throw new Exception('Invalid column, Factory does not support auto increment columns that are not the primary key');
        }
        $all_columns[] = $column;
    }
    $main_column_names = array();
    $main_column_updates = array();
    $main_column_objects = array();
    $main_column_types = array();
    foreach ($main_columns as $col) {
        $main_column_names[] = $col->name;
        $main_column_updates[] = $col->name.'=?';
        $main_column_objects[] = '$object->'.$col->name;
        $main_column_types[] = $col->type;
    }
    $all_column_names = array();
    $all_column_updates = array();
    $all_column_objects = array();
    $all_column_types = array();
    foreach ($all_columns as $col) {
        $all_column_names[] = $col->name;
        $all_column_updates[] = $col->name.'=?';
        $all_column_objects[] = '$object->'.$col->name;
        $all_column_types[] = $col->type;
    }
    // Setup the column names for use in all the functions
    $tablestring .= '
	private static $'.$tab.'_col_names = array(\''.implode('\',\'', $all_column_names).'\');';

    //Setup the Create function
    $tablestring .= '
	public static function Create'.$tab.'Object($object = null)
	{
		if(!empty($object)) {
			$params = get_object_vars($object);
			foreach(array_keys($params) as $par) {
				if(!in_array($par,'.$seldatabase.'::$'.$tab.'_col_names)) return \'Invalid object, , $par column does not exist\';
			}
		}
		ocrutil::Init();
		$connection = new mysqli('.$seldatabase.'::$host, '.$seldatabase.'::$username, '.$seldatabase.'::$password, '.$seldatabase.'::$database, '.$seldatabase.'::$port);
		if (mysqli_connect_errno()) {
			return \'Connection Error: \'.mysqli_connect_error();
		}';
    // Make sure that their is a key on the table and the key is an auto increment key
    if (!empty($key) && $key->auto) {
        $tablestring .= '
			$stmt = $connection->prepare("INSERT INTO '.$tab.' ('.implode(',', $main_column_names).') VALUES (';
        $ques = array();
        for ($i = 0; $i < count($main_column_names); $i++) {
            $ques[] = '?';
        }
        $tablestring .= implode(',', $ques).')");
		$stmt->bind_param("'.implode('', $main_column_types).'",'.implode(',', $main_column_objects).');';
        // Otherwise just add the standard create function
    } else {
        $tablestring .= '
		$stmt = $connection->prepare("INSERT INTO '.$tab.' ('.implode(',', $all_column_names).') VALUES (';
        $ques = array();
        for ($i = 0; $i < count($all_column_names); $i++) {
            $ques[] = '?';
        }
        $tablestring .= implode(',', $ques).')");
		$stmt->bind_param("'.implode('', $all_column_types).'",'.implode(',', $all_column_objects).');';
    }

    $tablestring .= '
		$stmt->execute();
		$error = $stmt->error;
		$connection->close();
		if(!empty($error)) return \'Error: \'.$error;';

    // If there is a auto increment key, return the key
    if (!empty($key) && $key->auto) {
        $tablestring .= '
		$object->'.$key->name.'=$stmt->insert_id;';
    }
    $tablestring .= '
		return $object;
	}
	';

    //Setup the CreateUpdate Function
    $tablestring .= '
	public static function CreateUpdate'.$tab.'Object($object = null)
	{';
    // Disable the function if there is no primary key
    if (empty($key)) {
        $tablestring .= '
		return \'Function not supported. No table primary key\';';
    } else {
        $tablestring .= '
		if(!empty($object)) {
			$params = get_object_vars($object);
			foreach(array_keys($params) as $par) {
				if(!in_array($par,'.$seldatabase.'::$'.$tab.'_col_names)) return \'Invalid object, , $par column does not exist\';
			}
		}
		ocrutil::Init();
		$connection = new mysqli('.$seldatabase.'::$host, '.$seldatabase.'::$username, '.$seldatabase.'::$password, '.$seldatabase.'::$database, '.$seldatabase.'::$port);
		if (mysqli_connect_errno()) {
			return \'Connection Error: \'.mysqli_connect_error();
		}
		';
        // Create a special function in their is an auto increment key
        if (!empty($key) && $key->auto) {
            $tablestring .= '
			$stmt = $connection->prepare("INSERT INTO '.$tab.' ('.implode(',', $main_column_names).') VALUES (';
            $ques = array();
            for ($i = 0; $i < count($main_column_names); $i++) {
                $ques[] = '?';
            }
            $tablestring .= implode(',', $ques).') ON DUPLICATE KEY UPDATE '.$key->name.'=LAST_INSERT_ID('.$key->name.'),'.implode(',', $main_column_updates).'");
				$stmt->bind_param("'.implode('', $main_column_types).implode('', $main_column_types).'",'.implode(',', $main_column_objects).','.implode(',', $main_column_objects).');';
        } else {
            $tablestring .= '
			$stmt = $connection->prepare("INSERT INTO '.$tab.' ('.implode(',', $all_column_names).') VALUES (';
            $ques = array();
            for ($i = 0; $i < count($all_column_names); $i++) {
                $ques[] = '?';
            }
            $tablestring .= implode(',', $ques).') ON DUPLICATE KEY UPDATE '.implode(',', $main_column_updates).'");
			$stmt->bind_param("'.implode('', $all_column_types).implode('', $main_column_types).'",'.implode(',', $all_column_objects).','.implode(',', $main_column_objects).');';
        }
        $tablestring .= '
		$stmt->execute();
		$error = $stmt->error;
		$connection->close();
		if(!empty($error)) return \'Error: \'.$error;';
        if ($key->auto) {
            $tablestring .= '
		$object->'.$key->name.'=$stmt->insert_id;';
        }
        $tablestring .= '
		return $object;';
    }
    $tablestring .= '}
	';

    //Setup the Update Function
    $tablestring .= '
	public static function Update'.$tab.'Object($object)
	{';
    if (empty($key))
        $tablestring .= 'return \'Function not supported. No table primary key\';';
    else {
        $tablestring .= '
		if(empty($object) || empty($object->'.$key->name.')) return \'Missing primary key value\';
		$params = get_object_vars($object);
		foreach(array_keys($params) as $par) {
			if(!in_array($par,'.$seldatabase.'::$'.$tab.'_col_names)) return \'Invalid object, $par column does not exist\';
		}
		ocrutil::Init();
		$connection = new mysqli('.$seldatabase.'::$host, '.$seldatabase.'::$username, '.$seldatabase.'::$password, '.$seldatabase.'::$database, '.$seldatabase.'::$port);
		if (mysqli_connect_errno()) {
			return \'Connection Error: \'.mysqli_connect_error();
		}
		$stmt = $connection->prepare("UPDATE '.$tab.' SET '.implode(',', $main_column_updates).' WHERE '.$key->name.'=?");
		$stmt->bind_param("'.implode('', $main_column_types).$key->type.'",'.implode(',', $main_column_objects).',$object->'.$key->name.');
		$stmt->execute();
		$error = $stmt->error;
		$connection->close();
		if(!empty($error)) return \'Error: \'.$error;
		return $object;';
    }
    $tablestring .= '}
	';

    // Setup th Retrieve Function
    $tablestring .= '
	public static function Retrieve'.$tab.'Object($'.(!empty($key) ? $key->name : 'unsupported').')
	{';
    // Disable the function if their is no key
    if (empty($key))
        $tablestring .= 'return \'Function not supported. No table primary key\';';
    else {
        $tablestring .= '
		ocrutil::Init();
		$connection = new mysqli('.$seldatabase.'::$host, '.$seldatabase.'::$username, '.$seldatabase.'::$password, '.$seldatabase.'::$database, '.$seldatabase.'::$port);
		if (mysqli_connect_errno()) {
			return \'Connection Error: \'.mysqli_connect_error();
		}
		$stmt = $connection->prepare("SELECT '.implode(',', $all_column_names).' FROM '.$tab.' WHERE '.$key->name.'=?");
		$stmt->bind_param("'.$key->type.'",$'.$key->name.');
		$object = new '.$tab.'Object();
		$stmt->bind_result('.implode(',', $all_column_objects).');
		$stmt->execute();
		$stmt->fetch();
		$error = $stmt->error;
		$connection->close();
		if(!empty($error)) return \'Error: \'.$error;
		return $object;';
    }
    $tablestring .= '}
	';

    //Setup the Delete Function
    $tablestring .= '
	public static function Delete'.$tab.'Object($'.(!empty($key) ? $key->name : 'unsupported').')
	{';
    //Disable the function if their is no key
    if (empty($key))
        $tablestring .= 'return \'Function not supported. No table primary key\';';
    else { //, ocrutil::$port
        $tablestring .= '
		ocrutil::Init();
		$connection = new mysqli('.$seldatabase.'::$host, '.$seldatabase.'::$username, '.$seldatabase.'::$password, '.$seldatabase.'::$database, '.$seldatabase.'::$port);
		if (mysqli_connect_errno()) {
			return \'Connection Error: \'.mysqli_connect_error();
		}
		$stmt = $connection->prepare("DELETE FROM '.$tab.' WHERE '.$key->name.'=?");
		$stmt->bind_param("'.$key->type.'",$'.$key->name.');
		$inserted = $stmt->execute();
		$error = $stmt->error;
		$connection->close();
		if(!empty($error)) return \'Error: \'.$error;
		return $inserted;';
    }
    $tablestring .= '}
	';

}
$tablestring .= '
}
?>';

// Write the finished string to the file path
$fh = fopen($file_path, 'w+');
fwrite($fh, $tablestring);
fclose($fh);
echo "Generation Complete";

