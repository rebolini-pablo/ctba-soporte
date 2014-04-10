<?php

class TicketDAO extends BaseDAO {
    
    public function __construct() {
      parent::__construct(
        new PDO(
          "mysql:host=".Config::get('database','host').";dbname=".Config::get('database', 'name'),
          Config::get('database', 'user'),
          Config::get('database', 'pass')
        )
      );


        
    }

    public function all() {
      return $this->getAll();
    }

    public function find($id) {
      return $this->getById($id);
    }

    public function create () {
      return $this->insert($this);
    }

    public function save() {
      // If id is defined then update
      if ($this->id !== null) {
        return $this->update($this);
      }

      // else insert it...
      return $this->insert($this);
    }
}