<?php
require_once PROJECT_ROOT_PATH . './helpers/utils.php';

abstract class Database
{
  protected static $connection = null;

  function __construct()
  {
    self::$connection = self::connection();
  }

  protected static function connection()
  {
    try {
      if (self::$connection == NULL) {
        self::$connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

        if (mysqli_connect_errno()) {
          throw new Exception("Could not connect to database.");
        }
      }
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  protected static function select($query = "", $params = [])
  {
    try {
      // echo $query, "QUERY";
      $stmt = self::executeStatement($query, $params);
      $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      // echo $result;
      $stmt->close();

      return $result;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    return false;
  }

  protected static function insert($query = "", $params = [])
  {
    try {
      // echo $query;
      $stmt = self::executeStatement($query, $params);
      $result = serialize($stmt);
      $result = ['insert_id' => $stmt->insert_id, 'error' => $stmt->error];
      // print_r($stmt);

      $stmt->close();

      // echo $result, "RESULT2";
      return $result;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    return false;
  }

  private static function executeStatement($query = "", $params = [])
  {
    try {
      self::connection();

      $stmt = self::$connection->prepare($query);
      // print_r(self::$connection);
      if ($stmt === false) {
        throw new Exception("Unable to do prepared statement: " . $query);
      }

      if (count($params)) {
        $stmt->bind_param(...$params);
      }

      $stmt->execute();

      return $stmt;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  protected static function executeMultiQuery($query)
  {
    self::connection();

    $con = self::$connection;
    /* execute multi query */
    $response = null;
    try {
      $con->multi_query($query);
      do {
        /* store the result set in PHP */
        if ($result = $con->store_result()) {
          $response = $result->fetch_assoc();
          while ($row = $result->fetch_row()) {
            printf("%s\n", $row[0]);
          }
        }
        /* print divider */
        if ($con->more_results()) {
          printf("-----------------\n");
        }
      } while ($con->next_result());
      return $response;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}