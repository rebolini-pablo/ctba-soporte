<?php 

/**
 *
 */
class Response {
  private $header;

  /**
   * @todo Desacoplar header(), implementando setter setHeader()
   * y delegando el return a un metodo dispatch()
   */
  public static function json($data, $status = 'success') {
    header('Content-Type: application/json');

    //$response = array(
    // 'status' => $status,
    //  'data'  => $data
    //);

    return json_encode($data);
  }

  public static function redirect ($to) {
    $base = Config::get('app', 'url');

    if (substr($to, 0, 1) === '/')
      return header ("Location: {$base}{$to}");
  }
}