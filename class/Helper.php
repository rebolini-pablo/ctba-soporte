<?php

class Helper {
  public static function asset ($path) {
    return Config::get('app', 'url') . 'assets/' . $path;
  }

  public static function uploadFile ($fieldName) {
    if ($_FILES[$fieldName]['size'] === 0)
      return null;

    $path = Config::get('app', 'upload_dir');
    $filename = basename($_FILES[$fieldName]['name']);

    if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $path . $filename))
      throw new Exception("Unable to upload file: {$filename}");

    return $filename;          
  }

  public static function isJson($string) {
    if (is_string($string)) {
      json_decode($string);
      return (json_last_error() == JSON_ERROR_NONE);
    }

    return false;
  }
}