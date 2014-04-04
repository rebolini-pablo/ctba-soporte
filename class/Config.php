<?php

  /**
   *
   */
  class Config {
  
    /**
     * Return requested configuration
     */
    public static function get($filename, $variable = null) {
      $path = __DIR__ . "/../config/{$filename}.php";
      
      if (!file_exists($path))
        throw new Exception('Undefined Config Filename');
        
        $file = include($path);      
        
        if (!isset($file[$filename][$variable]))
          throw new Exception('Undefined Config Variable: '. $variable);

        if ($variable === null)
          return $file[$filename];

        return $file[$filename][$variable];
    }
  
  }
  
