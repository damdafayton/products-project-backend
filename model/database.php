<?php
abstract class Database
{
  protected $connection = null;

  function __construct()
  {
    try {
      $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

      if (mysqli_connect_errno()) {
        throw new Exception("Could not connect to database.");
      }
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  protected function select($query = "", $params = [])
  {
    try {
      $stmt = $this->executeStatement($query, $params);
      $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      $stmt->close();

      return $result;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    return false;
  }

  protected function createOrInsert($query = "", $params = [])
  {
    try {
      $stmt = $this->executeStatement($query, $params);
      $result = $stmt->get_result();
      $stmt->close();

      return $result;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    return false;
  }

  private function executeStatement($query = "", $params = [])
  {
    try {
      $stmt = $this->connection->prepare($query);

      if ($stmt === false) {
        throw new Exception("Unable to do prepared statement: " . $query);
      }

      if ($params) {
        $stmt->bind_param($params[0], $params[1]);
      }

      $stmt->execute();

      return $stmt;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  protected function executeMultiQuery($query)
  {
    $con = $this->connection;
    /* execute multi query */
    try {
      $con->multi_query($query);
      do {
        /* store the result set in PHP */
        if ($result = $con->store_result()) {
          while ($row = $result->fetch_row()) {
            printf("%s\n", $row[0]);
          }
        }
        /* print divider */
        if ($con->more_results()) {
          printf("-----------------\n");
        }
      } while ($con->next_result());
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}