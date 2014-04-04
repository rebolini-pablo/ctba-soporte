<?php
  
  class Ticket extends TicketDAO {
    protected $table = 'tickets';
    
    public $id = null;
    public $description;
    public $screenshot;
    public $system_id;
    public $module_id;
    public $created_at;
    public $status;
  }