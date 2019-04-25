<?php
// vvv DO NOT MODIFY/REMOVE vvv

// check current php version
function check_php_version()
{
  if (version_compare(phpversion(), '7.0', '<')) {
    define(VERSION_MESSAGE, "PHP version 7.0 or higher is required for 2300. Make sure you have installed PHP 7 on your computer and have set the correct PHP path in VS Code.");
    echo VERSION_MESSAGE;
    throw VERSION_MESSAGE;
  }
}
check_php_version();

function config_php_errors()
{
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 0);
  error_reporting(E_ALL);
}
config_php_errors();

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename)
{
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (file_exists($init_sql_filename)) {
      $db_init_sql = file_get_contents($init_sql_filename);
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    } else {
      unlink($db_filename);
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return null;
}

function exec_sql_query($db, $sql, $params = array())
{
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return null;
}
// ^^^ DO NOT MODIFY/REMOVE ^^^

// You may place any of your code here.

$db = open_or_init_sqlite_db('secure/site.sqlite', 'secure/init.sql');

// global constant for image uploading path
const IMAGE_UPLOADS_PATH = "/images";

$title = "AllSwap";

// associative array mapping page 'id' to page title
$pages = array(
  "index" => "Home",
  "account" => "Account Information",
  "qa" => "QA",
  "textbook" => "Textbooks"
);

// An array to deliver messages to the user.
$messages = array();

// Record a message to display to the user.
function record_message($message) {
  global $messages;
  array_push($messages, $message);
}

// Write out any messages to the user.
function print_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo "<br><br><p><strong>" . htmlspecialchars($message) . "</strong></p>\n";
  }
}

function check_login() {
  global $db;

  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];

    $sql = "SELECT * FROM accounts WHERE session = :session;";
    $params = array (
      ':session' => $session
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $account = $records[0];
      return $account['username'];
    }
  }
  return NULL;
}

function log_in($username, $password) {
  global $db;

  if ($username && $password) {
    $sql = "SELECT * FROM accounts WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();

    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $account = $records[0];

      // Check password against hash in DB
      if ( password_verify ($password, $records[0]['password'])) {
        $session = uniqid();
        $sql = "UPDATE accounts SET session = :session WHERE id = :user_id;";
        $params = array(':user_id' => $records[0]['id'], ':session' => $session);
        $result = exec_sql_query($db, $sql, $params);
        if ($result) {
          // Success, session stored in DB

          // Send this back to the user.
          setcookie("session", $session, time()+3600);  /* expire in 1 hour */

          // record_message("Logged in as $username.");
          return $username;
        } else {
          record_message("Log in failed.");
        }
      } else {
        record_message("Invalid username or password.");
      }
    } else {
      record_message("Invalid username or password.");
    }
  } else {
    record_message("No username or password given.");
  }
  return NULL;
}

function log_out() {
  global $current_user;
  global $db;

  if ($current_user) {
    $sql = "UPDATE accounts SET session = :session WHERE username = :username;";
    $params = array (
      ':username' => $current_user,
      ':session' => NULL
    );
    if (!exec_sql_query($db, $sql, $params)) {
      record_message("Log out failed.");
    }
  }
  // Remove the session from the cookie and force it to expire.
  setcookie("session", "", time()-3600);
  $current_user = NULL;
}

// Function to get current user's ID
function get_id() {
  global $db;

  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];

    $sql = "SELECT * FROM accounts WHERE session = :session;";
    $params = array(':session' => $session);
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      // There should only be 1 record as USERNAME is unique.
      $account = $records[0];
      return $account['id'];
    }
  }
  return NULL;
}

// Check if we should login the user
if (isset($_POST['login'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $username = trim($username);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $current_user = log_in($username, $password);
} else {
  // check if logged in
  $current_user = check_login();
}

if (!empty($current_user)) {
  $current_user_id = get_id();
}

?>