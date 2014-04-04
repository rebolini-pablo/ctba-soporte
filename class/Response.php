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
}