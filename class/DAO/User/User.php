<?php
  
  class User extends UserDAO {
    protected $table = 'users';
    protected $model = 'User';

    public $id = null;
    public $type;
    public $email;
    public $password;
  }