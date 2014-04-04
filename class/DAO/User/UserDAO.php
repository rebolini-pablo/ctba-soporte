<?php

class UserDAO extends BaseDAO {
    
    public function __construct() {
      parent::__construct(
        new PDO(
          "mysql:host=".Config::get('database','host').";dbname=".Config::get('database', 'name'),
          Config::get('database', 'user'),
          Config::get('database', 'pass')
        )
      );

      if (! isset($this->table))
        throw new RunTimeException("Missing property: $table");
        
    }

    public function find($id) {
      return $this->getById($id);
    }

    public function create () {
      return $this->insert($this);
    }  

    public function validate($email, $password) {
      return $this->whereRaw(
        "`email` = '{$email}' AND `password` = '{$password}'",
        array($email, $password)
      );
    }
}