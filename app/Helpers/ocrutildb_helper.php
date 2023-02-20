<?php
//This is PHP Generated Code From AutomatePHPMySQL. Be Careful editing this code, functions may become unstable. If you made a change to your database, recreate this file.
class archive_historyObject{public $id;public $post;public $summary_confidence_score;public $image_resource_name;public $archived_to_resource_name;public $archived_on;public $imported_on;public $processed_on;public $created_at;public $created_by;}

class migrationsObject{public $id;public $version;public $class;public $group;public $namespace;public $time;public $batch;}

class document_historyObject{public $id;public $post;public $summary_confidence_score;public $image_resource_name;public $processed_on;public $created_at;public $created_by;public $ocr_payload;public $ocr_map_resource_name;}

class auth_permissions_usersObject{public $id;public $user_id;public $permission;public $created_at;}

class auth_loginsObject{public $id;public $ip_address;public $user_agent;public $id_type;public $identifier;public $user_id;public $date;public $success;}

class auth_token_loginsObject{public $id;public $ip_address;public $user_agent;public $id_type;public $identifier;public $user_id;public $date;public $success;}

class postsObject{public $post_code;}

class settingsObject{public $id;public $class;public $key;public $value;public $type;public $context;public $created_at;public $updated_at;}

class exception_queueObject{public $id;public $post;public $summary_confidence_score;public $image_resource_name;public $processed_on;public $created_at;public $created_by;}

class document_history_detailObject{public $id;public $document_history_id;public $summary_confidence_score;public $action_taken;public $created_at;public $created_by;}

class auth_remember_tokensObject{public $id;public $selector;public $hashedValidator;public $user_id;public $expires;public $created_at;public $updated_at;}

class auth_identitiesObject{public $id;public $user_id;public $type;public $name;public $secret;public $secret2;public $expires;public $extra;public $force_reset;public $last_used_at;public $created_at;public $updated_at;}

class auth_groups_usersObject{public $id;public $user_id;public $group;public $created_at;}

class usersObject{public $id;public $username;public $status;public $status_message;public $active;public $last_active;public $created_at;public $updated_at;public $deleted_at;}

class ocrutil
{
    private static $username = "root";
    private static $password = "root";
    private static $database = "ocrutil";
    private static $host = "127.0.0.1";
    private static $port = "3307";
    public static function Init()
    {
        $db = \Config\Database::connect();
        ocrutil::$username = $db->username;
        ocrutil::$password = $db->password;
        ocrutil::$database = $db->database;
        ocrutil::$host = $db->hostname;
        ocrutil::$port = $db->port;
    }

    private static $archive_history_col_names = array('id','post','summary_confidence_score','image_resource_name','archived_to_resource_name','archived_on','imported_on','processed_on','created_at','created_by');
    public static function Createarchive_historyObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$archive_history_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO archive_history (post,summary_confidence_score,image_resource_name,archived_to_resource_name,archived_on,imported_on,processed_on,created_at,created_by) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sdsssssss",$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->archived_to_resource_name,$object->archived_on,$object->imported_on,$object->processed_on,$object->created_at,$object->created_by);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdatearchive_historyObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$archive_history_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO archive_history (post,summary_confidence_score,image_resource_name,archived_to_resource_name,archived_on,imported_on,processed_on,created_at,created_by) VALUES (?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),post=?,summary_confidence_score=?,image_resource_name=?,archived_to_resource_name=?,archived_on=?,imported_on=?,processed_on=?,created_at=?,created_by=?");
        $stmt->bind_param("sdssssssssdsssssss",$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->archived_to_resource_name,$object->archived_on,$object->imported_on,$object->processed_on,$object->created_at,$object->created_by,$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->archived_to_resource_name,$object->archived_on,$object->imported_on,$object->processed_on,$object->created_at,$object->created_by);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updatearchive_historyObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$archive_history_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE archive_history SET post=?,summary_confidence_score=?,image_resource_name=?,archived_to_resource_name=?,archived_on=?,imported_on=?,processed_on=?,created_at=?,created_by=? WHERE id=?");
        $stmt->bind_param("sdsssssssi",$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->archived_to_resource_name,$object->archived_on,$object->imported_on,$object->processed_on,$object->created_at,$object->created_by,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrievearchive_historyObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,post,summary_confidence_score,image_resource_name,archived_to_resource_name,archived_on,imported_on,processed_on,created_at,created_by FROM archive_history WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new archive_historyObject();
        $stmt->bind_result($object->id,$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->archived_to_resource_name,$object->archived_on,$object->imported_on,$object->processed_on,$object->created_at,$object->created_by);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deletearchive_historyObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM archive_history WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $migrations_col_names = array('id','version','class','group','namespace','time','batch');
    public static function CreatemigrationsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$migrations_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO migrations (version,class,group,namespace,time,batch) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssii",$object->version,$object->class,$object->group,$object->namespace,$object->time,$object->batch);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdatemigrationsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$migrations_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO migrations (version,class,group,namespace,time,batch) VALUES (?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),version=?,class=?,group=?,namespace=?,time=?,batch=?");
        $stmt->bind_param("ssssiissssii",$object->version,$object->class,$object->group,$object->namespace,$object->time,$object->batch,$object->version,$object->class,$object->group,$object->namespace,$object->time,$object->batch);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function UpdatemigrationsObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$migrations_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE migrations SET version=?,class=?,group=?,namespace=?,time=?,batch=? WHERE id=?");
        $stmt->bind_param("ssssiii",$object->version,$object->class,$object->group,$object->namespace,$object->time,$object->batch,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function RetrievemigrationsObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,version,class,group,namespace,time,batch FROM migrations WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new migrationsObject();
        $stmt->bind_result($object->id,$object->version,$object->class,$object->group,$object->namespace,$object->time,$object->batch);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function DeletemigrationsObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM migrations WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $document_history_col_names = array('id','post','summary_confidence_score','image_resource_name','processed_on','created_at','created_by','ocr_payload','ocr_map_resource_name');
    public static function Createdocument_historyObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$document_history_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO document_history (post,summary_confidence_score,image_resource_name,processed_on,created_at,created_by,ocr_payload,ocr_map_resource_name) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sdssssss",$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by,$object->ocr_payload,$object->ocr_map_resource_name);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdatedocument_historyObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$document_history_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO document_history (post,summary_confidence_score,image_resource_name,processed_on,created_at,created_by,ocr_payload,ocr_map_resource_name) VALUES (?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),post=?,summary_confidence_score=?,image_resource_name=?,processed_on=?,created_at=?,created_by=?,ocr_payload=?,ocr_map_resource_name=?");
        $stmt->bind_param("sdsssssssdssssss",$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by,$object->ocr_payload,$object->ocr_map_resource_name,$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by,$object->ocr_payload,$object->ocr_map_resource_name);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updatedocument_historyObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$document_history_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE document_history SET post=?,summary_confidence_score=?,image_resource_name=?,processed_on=?,created_at=?,created_by=?,ocr_payload=?,ocr_map_resource_name=? WHERE id=?");
        $stmt->bind_param("sdssssssi",$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by,$object->ocr_payload,$object->ocr_map_resource_name,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrievedocument_historyObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,post,summary_confidence_score,image_resource_name,processed_on,created_at,created_by,ocr_payload,ocr_map_resource_name FROM document_history WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new document_historyObject();
        $stmt->bind_result($object->id,$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by,$object->ocr_payload,$object->ocr_map_resource_name);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deletedocument_historyObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM document_history WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $auth_permissions_users_col_names = array('id','user_id','permission','created_at');
    public static function Createauth_permissions_usersObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_permissions_users_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO auth_permissions_users (user_id,permission,created_at) VALUES (?,?,?)");
        $stmt->bind_param("iss",$object->user_id,$object->permission,$object->created_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdateauth_permissions_usersObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_permissions_users_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO auth_permissions_users (user_id,permission,created_at) VALUES (?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),user_id=?,permission=?,created_at=?");
        $stmt->bind_param("ississ",$object->user_id,$object->permission,$object->created_at,$object->user_id,$object->permission,$object->created_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updateauth_permissions_usersObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$auth_permissions_users_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE auth_permissions_users SET user_id=?,permission=?,created_at=? WHERE id=?");
        $stmt->bind_param("issi",$object->user_id,$object->permission,$object->created_at,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrieveauth_permissions_usersObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,user_id,permission,created_at FROM auth_permissions_users WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new auth_permissions_usersObject();
        $stmt->bind_result($object->id,$object->user_id,$object->permission,$object->created_at);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deleteauth_permissions_usersObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM auth_permissions_users WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $auth_logins_col_names = array('id','ip_address','user_agent','id_type','identifier','user_id','date','success');
    public static function Createauth_loginsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_logins_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO auth_logins (ip_address,user_agent,id_type,identifier,user_id,date,success) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssisi",$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdateauth_loginsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_logins_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO auth_logins (ip_address,user_agent,id_type,identifier,user_id,date,success) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),ip_address=?,user_agent=?,id_type=?,identifier=?,user_id=?,date=?,success=?");
        $stmt->bind_param("ssssisissssisi",$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success,$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updateauth_loginsObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$auth_logins_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE auth_logins SET ip_address=?,user_agent=?,id_type=?,identifier=?,user_id=?,date=?,success=? WHERE id=?");
        $stmt->bind_param("ssssisii",$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrieveauth_loginsObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,ip_address,user_agent,id_type,identifier,user_id,date,success FROM auth_logins WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new auth_loginsObject();
        $stmt->bind_result($object->id,$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deleteauth_loginsObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM auth_logins WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $auth_token_logins_col_names = array('id','ip_address','user_agent','id_type','identifier','user_id','date','success');
    public static function Createauth_token_loginsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_token_logins_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO auth_token_logins (ip_address,user_agent,id_type,identifier,user_id,date,success) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssisi",$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdateauth_token_loginsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_token_logins_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO auth_token_logins (ip_address,user_agent,id_type,identifier,user_id,date,success) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),ip_address=?,user_agent=?,id_type=?,identifier=?,user_id=?,date=?,success=?");
        $stmt->bind_param("ssssisissssisi",$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success,$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updateauth_token_loginsObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$auth_token_logins_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE auth_token_logins SET ip_address=?,user_agent=?,id_type=?,identifier=?,user_id=?,date=?,success=? WHERE id=?");
        $stmt->bind_param("ssssisii",$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrieveauth_token_loginsObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,ip_address,user_agent,id_type,identifier,user_id,date,success FROM auth_token_logins WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new auth_token_loginsObject();
        $stmt->bind_result($object->id,$object->ip_address,$object->user_agent,$object->id_type,$object->identifier,$object->user_id,$object->date,$object->success);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deleteauth_token_loginsObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM auth_token_logins WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $posts_col_names = array('post_code');
    public static function CreatepostsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$posts_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO posts (post_code) VALUES (?)");
        $stmt->bind_param("s",$object->post_code);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;
    }

    public static function CreateUpdatepostsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$posts_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO posts (post_code) VALUES (?) ON DUPLICATE KEY UPDATE ");
        $stmt->bind_param("s",$object->post_code,);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function UpdatepostsObject($object)
    {
        if(empty($object) || empty($object->post_code)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$posts_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE posts SET  WHERE post_code=?");
        $stmt->bind_param("s",$object->post_code);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function RetrievepostsObject($post_code)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT post_code FROM posts WHERE post_code=?");
        $stmt->bind_param("s",$post_code);
        $object = new postsObject();
        $stmt->bind_result($object->post_code);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function DeletepostsObject($post_code)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM posts WHERE post_code=?");
        $stmt->bind_param("s",$post_code);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $settings_col_names = array('id','class','key','value','type','context','created_at','updated_at');
    public static function CreatesettingsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$settings_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO settings (class,key,value,type,context,created_at,updated_at) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss",$object->class,$object->key,$object->value,$object->type,$object->context,$object->created_at,$object->updated_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdatesettingsObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$settings_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO settings (class,key,value,type,context,created_at,updated_at) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),class=?,key=?,value=?,type=?,context=?,created_at=?,updated_at=?");
        $stmt->bind_param("ssssssssssssss",$object->class,$object->key,$object->value,$object->type,$object->context,$object->created_at,$object->updated_at,$object->class,$object->key,$object->value,$object->type,$object->context,$object->created_at,$object->updated_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function UpdatesettingsObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$settings_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE settings SET class=?,key=?,value=?,type=?,context=?,created_at=?,updated_at=? WHERE id=?");
        $stmt->bind_param("sssssssi",$object->class,$object->key,$object->value,$object->type,$object->context,$object->created_at,$object->updated_at,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function RetrievesettingsObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,class,key,value,type,context,created_at,updated_at FROM settings WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new settingsObject();
        $stmt->bind_result($object->id,$object->class,$object->key,$object->value,$object->type,$object->context,$object->created_at,$object->updated_at);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function DeletesettingsObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM settings WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $exception_queue_col_names = array('id','post','summary_confidence_score','image_resource_name','processed_on','created_at','created_by');
    public static function Createexception_queueObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$exception_queue_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO exception_queue (post,summary_confidence_score,image_resource_name,processed_on,created_at,created_by) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sdssss",$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdateexception_queueObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$exception_queue_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO exception_queue (post,summary_confidence_score,image_resource_name,processed_on,created_at,created_by) VALUES (?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),post=?,summary_confidence_score=?,image_resource_name=?,processed_on=?,created_at=?,created_by=?");
        $stmt->bind_param("sdsssssdssss",$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by,$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updateexception_queueObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$exception_queue_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE exception_queue SET post=?,summary_confidence_score=?,image_resource_name=?,processed_on=?,created_at=?,created_by=? WHERE id=?");
        $stmt->bind_param("sdssssi",$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrieveexception_queueObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,post,summary_confidence_score,image_resource_name,processed_on,created_at,created_by FROM exception_queue WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new exception_queueObject();
        $stmt->bind_result($object->id,$object->post,$object->summary_confidence_score,$object->image_resource_name,$object->processed_on,$object->created_at,$object->created_by);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deleteexception_queueObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM exception_queue WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $document_history_detail_col_names = array('id','document_history_id','summary_confidence_score','action_taken','created_at','created_by');
    public static function Createdocument_history_detailObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$document_history_detail_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO document_history_detail (document_history_id,summary_confidence_score,action_taken,created_at,created_by) VALUES (?,?,?,?,?)");
        $stmt->bind_param("idsss",$object->document_history_id,$object->summary_confidence_score,$object->action_taken,$object->created_at,$object->created_by);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdatedocument_history_detailObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$document_history_detail_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO document_history_detail (document_history_id,summary_confidence_score,action_taken,created_at,created_by) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),document_history_id=?,summary_confidence_score=?,action_taken=?,created_at=?,created_by=?");
        $stmt->bind_param("idsssidsss",$object->document_history_id,$object->summary_confidence_score,$object->action_taken,$object->created_at,$object->created_by,$object->document_history_id,$object->summary_confidence_score,$object->action_taken,$object->created_at,$object->created_by);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updatedocument_history_detailObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$document_history_detail_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE document_history_detail SET document_history_id=?,summary_confidence_score=?,action_taken=?,created_at=?,created_by=? WHERE id=?");
        $stmt->bind_param("idsssi",$object->document_history_id,$object->summary_confidence_score,$object->action_taken,$object->created_at,$object->created_by,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrievedocument_history_detailObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,document_history_id,summary_confidence_score,action_taken,created_at,created_by FROM document_history_detail WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new document_history_detailObject();
        $stmt->bind_result($object->id,$object->document_history_id,$object->summary_confidence_score,$object->action_taken,$object->created_at,$object->created_by);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deletedocument_history_detailObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM document_history_detail WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $auth_remember_tokens_col_names = array('id','selector','hashedValidator','user_id','expires','created_at','updated_at');
    public static function Createauth_remember_tokensObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_remember_tokens_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO auth_remember_tokens (selector,hashedValidator,user_id,expires,created_at,updated_at) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssisss",$object->selector,$object->hashedValidator,$object->user_id,$object->expires,$object->created_at,$object->updated_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdateauth_remember_tokensObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_remember_tokens_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO auth_remember_tokens (selector,hashedValidator,user_id,expires,created_at,updated_at) VALUES (?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),selector=?,hashedValidator=?,user_id=?,expires=?,created_at=?,updated_at=?");
        $stmt->bind_param("ssisssssisss",$object->selector,$object->hashedValidator,$object->user_id,$object->expires,$object->created_at,$object->updated_at,$object->selector,$object->hashedValidator,$object->user_id,$object->expires,$object->created_at,$object->updated_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updateauth_remember_tokensObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$auth_remember_tokens_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE auth_remember_tokens SET selector=?,hashedValidator=?,user_id=?,expires=?,created_at=?,updated_at=? WHERE id=?");
        $stmt->bind_param("ssisssi",$object->selector,$object->hashedValidator,$object->user_id,$object->expires,$object->created_at,$object->updated_at,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrieveauth_remember_tokensObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,selector,hashedValidator,user_id,expires,created_at,updated_at FROM auth_remember_tokens WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new auth_remember_tokensObject();
        $stmt->bind_result($object->id,$object->selector,$object->hashedValidator,$object->user_id,$object->expires,$object->created_at,$object->updated_at);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deleteauth_remember_tokensObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM auth_remember_tokens WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $auth_identities_col_names = array('id','user_id','type','name','secret','secret2','expires','extra','force_reset','last_used_at','created_at','updated_at');
    public static function Createauth_identitiesObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_identities_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO auth_identities (user_id,type,name,secret,secret2,expires,extra,force_reset,last_used_at,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("issssssisss",$object->user_id,$object->type,$object->name,$object->secret,$object->secret2,$object->expires,$object->extra,$object->force_reset,$object->last_used_at,$object->created_at,$object->updated_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdateauth_identitiesObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_identities_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO auth_identities (user_id,type,name,secret,secret2,expires,extra,force_reset,last_used_at,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),user_id=?,type=?,name=?,secret=?,secret2=?,expires=?,extra=?,force_reset=?,last_used_at=?,created_at=?,updated_at=?");
        $stmt->bind_param("issssssisssissssssisss",$object->user_id,$object->type,$object->name,$object->secret,$object->secret2,$object->expires,$object->extra,$object->force_reset,$object->last_used_at,$object->created_at,$object->updated_at,$object->user_id,$object->type,$object->name,$object->secret,$object->secret2,$object->expires,$object->extra,$object->force_reset,$object->last_used_at,$object->created_at,$object->updated_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updateauth_identitiesObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$auth_identities_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE auth_identities SET user_id=?,type=?,name=?,secret=?,secret2=?,expires=?,extra=?,force_reset=?,last_used_at=?,created_at=?,updated_at=? WHERE id=?");
        $stmt->bind_param("issssssisssi",$object->user_id,$object->type,$object->name,$object->secret,$object->secret2,$object->expires,$object->extra,$object->force_reset,$object->last_used_at,$object->created_at,$object->updated_at,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrieveauth_identitiesObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,user_id,type,name,secret,secret2,expires,extra,force_reset,last_used_at,created_at,updated_at FROM auth_identities WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new auth_identitiesObject();
        $stmt->bind_result($object->id,$object->user_id,$object->type,$object->name,$object->secret,$object->secret2,$object->expires,$object->extra,$object->force_reset,$object->last_used_at,$object->created_at,$object->updated_at);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deleteauth_identitiesObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM auth_identities WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $auth_groups_users_col_names = array('id','user_id','group','created_at');
    public static function Createauth_groups_usersObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_groups_users_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO auth_groups_users (user_id,group,created_at) VALUES (?,?,?)");
        $stmt->bind_param("iss",$object->user_id,$object->group,$object->created_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdateauth_groups_usersObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$auth_groups_users_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO auth_groups_users (user_id,group,created_at) VALUES (?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),user_id=?,group=?,created_at=?");
        $stmt->bind_param("ississ",$object->user_id,$object->group,$object->created_at,$object->user_id,$object->group,$object->created_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function Updateauth_groups_usersObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$auth_groups_users_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE auth_groups_users SET user_id=?,group=?,created_at=? WHERE id=?");
        $stmt->bind_param("issi",$object->user_id,$object->group,$object->created_at,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Retrieveauth_groups_usersObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,user_id,group,created_at FROM auth_groups_users WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new auth_groups_usersObject();
        $stmt->bind_result($object->id,$object->user_id,$object->group,$object->created_at);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function Deleteauth_groups_usersObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM auth_groups_users WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

    private static $users_col_names = array('id','username','status','status_message','active','last_active','created_at','updated_at','deleted_at');
    public static function CreateusersObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$users_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("INSERT INTO users (username,status,status_message,active,last_active,created_at,updated_at,deleted_at) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssissss",$object->username,$object->status,$object->status_message,$object->active,$object->last_active,$object->created_at,$object->updated_at,$object->deleted_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;
    }

    public static function CreateUpdateusersObject($object = null)
    {
        if(!empty($object)) {
            $params = get_object_vars($object);
            foreach(array_keys($params) as $par) {
                if(!in_array($par,ocrutil::$users_col_names)) return 'Invalid object, , $par column does not exist';
            }
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }

        $stmt = $connection->prepare("INSERT INTO users (username,status,status_message,active,last_active,created_at,updated_at,deleted_at) VALUES (?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id),username=?,status=?,status_message=?,active=?,last_active=?,created_at=?,updated_at=?,deleted_at=?");
        $stmt->bind_param("sssisssssssissss",$object->username,$object->status,$object->status_message,$object->active,$object->last_active,$object->created_at,$object->updated_at,$object->deleted_at,$object->username,$object->status,$object->status_message,$object->active,$object->last_active,$object->created_at,$object->updated_at,$object->deleted_at);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        $object->id=$stmt->insert_id;
        return $object;}

    public static function UpdateusersObject($object)
    {
        if(empty($object) || empty($object->id)) return 'Missing primary key value';
        $params = get_object_vars($object);
        foreach(array_keys($params) as $par) {
            if(!in_array($par,ocrutil::$users_col_names)) return 'Invalid object, $par column does not exist';
        }
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("UPDATE users SET username=?,status=?,status_message=?,active=?,last_active=?,created_at=?,updated_at=?,deleted_at=? WHERE id=?");
        $stmt->bind_param("sssissssi",$object->username,$object->status,$object->status_message,$object->active,$object->last_active,$object->created_at,$object->updated_at,$object->deleted_at,$object->id);
        $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function RetrieveusersObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("SELECT id,username,status,status_message,active,last_active,created_at,updated_at,deleted_at FROM users WHERE id=?");
        $stmt->bind_param("i",$id);
        $object = new usersObject();
        $stmt->bind_result($object->id,$object->username,$object->status,$object->status_message,$object->active,$object->last_active,$object->created_at,$object->updated_at,$object->deleted_at);
        $stmt->execute();
        $stmt->fetch();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $object;}

    public static function DeleteusersObject($id)
    {
        ocrutil::Init();
        $connection = new mysqli(ocrutil::$host, ocrutil::$username, ocrutil::$password, ocrutil::$database, ocrutil::$port);
        if (mysqli_connect_errno()) {
            return 'Connection Error: '.mysqli_connect_error();
        }
        $stmt = $connection->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i",$id);
        $inserted = $stmt->execute();
        $error = $stmt->error;
        $connection->close();
        if(!empty($error)) return 'Error: '.$error;
        return $inserted;}

}
?>