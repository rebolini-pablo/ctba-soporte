<?php

  /**
   *
   */
  Router::route('', function () {
    if (!Helper::isLoggedIn()):
      return Response::redirect('/login');
    else:
      return Response::redirect('/tickets');
    endif;
  });

  /**
   * User login
   */
  Router::route('login', function () {
    if ($_POST) {
      $email = $_POST['email'];
      $password = sha1($_POST['password']);
      $usuario = new User;
      $usuario = $usuario->validate($email, $password);

      if ($usuario) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_id'] = $usuario->id;
        $_SESSION['user_email'] = $usuario->email;
        $_SESSION['user_type'] = $usuario->type;

        return array(
          'status' => 'success',
          'message' => 'Bienvenido. Redireccionando ...',
          'redirect' => '/tickets'
        );
      }

      return array(
        'status' => 'error',
        'message' => 'Credenciales erroneas - intentos restantes: 3'
      );

    }

    include('template/include/header.php');
    include('template/login/login.php');
    include('template/include/footer.php');
  });

  Router::route('logout', function () {
    $_SESSION['is_logged_in'] = false;
    $_SESSION['user_id'] = null;
    $_SESSION['user_email'] = null;
    $_SESSION['user_type'] = null;

    session_destroy();

    Response::redirect('/login');
  });

  /**
   * List all tickets on the system
   */
  Router::route('tickets', function () {
    if (!Helper::isLoggedIn())
      return Response::redirect('/login');

    // En un principio, listar todos los tickets alcanza
    // Mas adelante y si fuera necesario se podria
    // Listar unicamente los tickets del usuario logeado
    $ticket = new Ticket;
    $tickets = json_encode($ticket->all());
    include('template/include/header.php');
    include('template/ticket/list.php');
    include('template/include/footer.php');
  });

  /**
   * Set ticket as resolved
   */
  Router::route('ticket/close', function () {
    if (!Helper::isLoggedIn())
      return Response::redirect('/login');

    if ($_POST) {
      $id = (int) $_POST['id'];

      $ticket = new Ticket;
      $ticket = $ticket->find($id);
      $ticket->status = 2;
      if ($ticket->save()) {
        return array(
          'status' => 'success',
          'message' => 'El ticket se ha marcado como resuelto. La página se actualizara en 2 segundos(s)'
        );
      }

      return array(
        'status' => 'error',
        'message' => 'Se ha producido un error'
      );
    }
  });

  /**
   * Create a new ticket
   */
  Router::route('ticket/create', function () {
    if ($_POST) {
      if (empty($_POST['description']) || empty($_POST['system_id']) || empty($_POST['module_id'])) {
        return array(
          'status' => 'error',
          'message' => 'Hay campos obligatorios sin rellenar'
        );
      }

      $ticket = new Ticket();
      $dateTime = new DateTime('now');
      $ticket->description = htmlentities($_POST['description']);
      $ticket->screenshot = Helper::uploadFile('screenshot');
      $ticket->system_id  = (int) $_POST['system_id'];
      $ticket->created_at  = $dateTime->format('Y-m-d H:m:s');
      $ticket->module_id  = (int) $_POST['module_id'];
      $ticket->status  = 0;

      if (!$ticket->create())
        return array('status' => 'error');

      $baseurl = Config::get('app', 'url');
      return array(
        'status' => 'success',
        'message' => 'Su ticket fue creado -' .
                              "<a href='{$baseurl}ticket/{$ticket->getLastInsertID()}'>".
                              'Visualizar</a>'
      );
    }

    include('template/include/header.php');
    include('template/ticket/create.php');
    include('template/include/footer.php');
  });

  /**
   * Get ticket by id
   * @return mixed html template | json response
   */
  Router::route('ticket/(\d+)', function ($id) {
    if (!Helper::isLoggedIn())
      return Response::redirect('/login');

    $ticket = new Ticket;
    $ticket = json_encode($ticket->find($id));
    
    include('template/include/header.php');
    include('template/ticket/view.php');
    include('template/include/footer.php');
  });