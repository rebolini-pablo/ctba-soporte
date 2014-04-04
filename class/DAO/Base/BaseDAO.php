<?php
  
  /**
   *
   */
  class BaseDAO {
    
    /**
     *
     */
    private $connection;
    
    /**
     *
     */
    private $statement;

    /**
     *
     */
    private $last_inserted_id = null;
    
    
    public function __construct(PDO $conn) {
      $this->connection = $conn;       
    }
  
    public function query($query) {
      $this->statement = $this->connection->prepare($query);
    }
    
    public function bind($param, $value) {
      $this->statement->bindValue($param, $value);
    }
    
    public function execute() {
      return $this->statement->execute();
    }
    
    public function single() {
      return $this->statement->fetch(\PDO::FETCH_ASSOC);    
    }

    public function getById($id) {
      $this->query("SELECT * FROM {$this->table} WHERE id = :id");
      $this->bind(':id', (int) $id);
      $this->execute();

      return $this->single();
    }

    public function insert($object) {
      
      // Get public properties
      $keys = array_map(function ($k) {
        return $k->name;
      }, (new ReflectionClass($object))->getProperties(
        ReflectionProperty::IS_PUBLIC
      ));

      // Transform null properties in Null values
      foreach ($keys as $k) {
        if ($object->{$k} === null)
          $result[$k] = 'NULL';
        else 
          $result[$k] = $object->{$k};
      }

      // Prepare bind values...
      $bind = array_map(function ($b) {
        return ":{$b}";  
      }, array_keys($result));

      $this->query("INSERT INTO {$this->table} (".
          implode(',', array_keys($result)) .
        ") VALUES (" .
          implode(',', $bind) .
        ");"
      );
      
      foreach ($bind as $bind) {
        $prop = str_replace(':', '', $bind);
        $this->bind($bind, $object->{$prop});
      }

      $result = $this->execute();
      $this->last_inserted_id = $this->connection->lastInsertId();

      return $result;
    }

    public function getLastInsertID () {
      return $this->last_inserted_id;
    }

    public function whereRaw ($whereQuery, array $bind) {
      $this->query("SELECT * FROM {$this->table} WHERE $whereQuery");
      $this->execute($bind);

      return $this->single();
    }
  }

