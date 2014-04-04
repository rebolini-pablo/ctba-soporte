<?php
  // (\w+)/(\d+)
  //  str      int

  
  Router::route('', function(){

    include('template/include/header.php');
    include('template/main.php');
    include('template/include/footer.php');
  });

  /**
   * Create a new ticket
   */
  Router::route('create', function () {
    if ($_POST) {
      if (empty($_POST['description']) || empty($_POST['system_id']) || empty($_POST['module_id'])) {
        return array(
          'status' => 'error',
          'message' => 'Hay campos obligatorios sin rellenar'
        );
      }

      $ticket = new Ticket();
      $ticket->description = htmlentities($_POST['description']);
      $ticket->screenshot = Helper::uploadFile('screenshot');
      $ticket->system_id  = (int) $_POST['system_id'];
      $ticket->created_at  = (new DateTime('now'))->format('Y-m-d H:m:s');
      $ticket->module_id  = (int) $_POST['module_id'];
      $ticket->status  = 0;

      if (!$ticket->create())
        return array('status' => 'error');

      return array(
        'status' => 'success',
        'message' => 'Su ticket fue creado -' .
                              "<a href='ticket/{$ticket->getLastInsertID()}'>".
                              'Visualizar</a>'
      );
    }

    include('template/include/header.php');
    include('template/ticket/create.php');
    include('template/include/footer.php');
  });

  Router::route('ticket/(\d+)', function ($id) {
    $ticket = json_encode((new Ticket)->find($id));
    
    include('template/include/header.php');
    include('template/ticket/view.php');
    include('template/include/footer.php');
  });

  Router::route('login', function(){
    if ($_POST) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $usuario = (new User)->validate($email, $password);

      if ($usuario)) {
        /*
array (size=4)
  'id' => string '1' (length=1)
  'email' => string 'rebolini.pablo@gmail.com' (length=24)
  'password' => string '12345678' (length=8)
  'type' => string 'admin' (length=5)
          */
      }
    }

    include('template/include/header.php');
    include('template/login/login.php');
    include('template/include/footer.php');
  });