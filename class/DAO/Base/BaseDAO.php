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
      $this->connection->setAttribute(
        PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
      );   

      if (! isset($this->table))
        throw new RunTimeException("Missing property: $table");   

      if (! isset($this->model))
        throw new RunTimeException("Missing property: $model");      

    }
  
    public function query($query) {
      $this->statement = $this->connection->prepare($query);
    }
    
    public function bind($param, $value) {
      $this->statement->bindValue($param, $value);
    }
    
    public function execute() {
      if ($this->statement->execute())
        return true;

      return $this->statement->debugDumpParams();
    }
    
    public function single() {
      $this->statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->model);
      return $this->statement->fetch();    
    }

    public function fetchAll() {
      return $this->statement->fetchAll(PDO::FETCH_CLASS, $this->model);
    }

    public function getAll() {
      $this->query("SELECT * FROM {$this->table}");
      $this->execute();

      return $this->fetchAll();      
    }

    public function getLastInsertID () {
      return $this->last_inserted_id;
    }

    public function getById($id) {
      $this->query("SELECT * FROM {$this->table} WHERE id = :id");
      $this->bind(':id', (int) $id);
      $this->execute();

      return $this->single();
    }

    public function insert($object) {
      $keys = Helper::getPublicProperties(
        $object
      );

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


    public function update($object) {
      $keys = Helper::getPublicProperties(
        $object
      );

      // Transform null properties in Null values
      foreach ($keys as $k) {
        if ($object->{$k} === null)
          $result[$k] = 'NULL';
        else 
          $result[$k] = $object->{$k};
      }

      // Prepare bind values...
      $bind = array_map(function ($b) {
        return "`{$b}` = :{$b}";  
      }, array_keys($result));

      $this->query("UPDATE {$this->table} SET ".
          implode(', ', $bind) .
        " WHERE `id` = :id;"
      );
           
      foreach (array_keys($result) as $prop) {
        $bind = ":{$prop}";
        $this->bind($bind, $object->{$prop});
      }

      $result = $this->execute();
      $this->last_inserted_id = $this->id;

      return $result;
    }



    public function whereRaw ($whereQuery, array $bind) {
      $this->query("SELECT * FROM {$this->table} WHERE $whereQuery");
      $this->execute($bind);

      return $this->single();
    }
  }

