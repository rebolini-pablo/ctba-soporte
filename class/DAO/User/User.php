<?php
  
  class User extends UserDAO {
    protected $table = 'users';
    
    public $id = null;
    public $type;
    public $email;
    public $password;
  }