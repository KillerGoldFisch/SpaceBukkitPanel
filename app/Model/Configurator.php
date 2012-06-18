<?php
class Configurator extends AppModel {

    public $name = 'Configurator';

    public $useTable = false; // This model does not use a database table


    //Save database

    function saveDb($type, $host = 'localhost', $login, $password, $database) {

        $config = APP.'Config/database.php'; 
        $template = APP.'Config/database.php.default';

        $old = array();

        $old['type']        = '%type%';
        $old['username']    = '%login%';
        $old['password']    = '%password%';
        $old['database']    = '%database%';
        $old['host']        = '%host%';

        $new = array();

        $new['type']        = $type;
        $new['username']    = $login;
        $new['password']    = $password;
        $new['database']    = $database;
        $new['host']        = $host;

        $new_file = implode(file($template));     
     
        $str = str_replace($old,$new,$new_file);

        //now, TOTALLY rewrite the file
        $fp=fopen($config,'w');

        fwrite($fp,$str,strlen($str));  

        return $str;   

    }

    //Generate configuration.php token

    function saveCore() {

        $config = APP.'webroot/configuration.php'; 

        $old = array();

        $old['token']        = '%*TOKEN*%';

        $new = array();

        $c = uniqid (rand(), true);

        $md5c = md5($c);

        $new['token']        = $md5c;

        $new_file = implode(file($config));     
     
        $str = str_replace($old,$new,$new_file);

        //now, TOTALLY rewrite the file
        $fp=fopen($config,'w');

        fwrite($fp,$str,strlen($str));  

        return $str;   

    }
    //Save config

    function saveVars($new) {

      $file       = APP . 'webroot/vars.php';
      include $file;

      $contents   = file_get_contents($file);

      $old = array();

      foreach ($variables as $key => $var) {

        $old[$key] = "/*".$key."*/'".$var['val']."'";
        $new[$key] = "/*".$key."*/'".$new[$key]."'";

      }

      $new_file = implode(file($file));     
   
      $str = str_replace($old,$new,$new_file);

      //now, TOTALLY rewrite the file
      $fp=fopen($file,'w');

      fwrite($fp, $str, strlen($str));     

    }

    //Retrieve config   

    function returnVars($key = null) {

      require APP . 'webroot/vars.php';

      if ($key) {

        return $variables[$key];

      } else {

        return $variables;

      }

    }

    /* SYSTEM */

    //Save config

    function saveSys($new) {


      $file       = APP . 'webroot/system.php';
      include $file;

      $contents   = file_get_contents($file);

      $old = array();

      foreach ($system as $key => $var) {

        $old[$key] = "/*".$key."*/'".$var['val']."'";
        $new[$key] = "/*".$key."*/'".$new[$key]."'";

      }

      $new_file = implode(file($file));     
   
      $str = str_replace($old,$new,$new_file);

      //now, TOTALLY rewrite the file
      $fp=fopen($file,'w');

      fwrite($fp, $str, strlen($str));    

    }

    //Retrieve config   

    function returnSys($key = null) {

      require APP . 'webroot/system.php';

      if ($key) {

        return $variables[$key];

      } else {

        return $variables;

      }

    }
        
    //Function to get strings
    function get_string_between($string, $start, $end){
      $string = " ".$string;
      $ini = strpos($string,$start);
      if ($ini == 0) return "";
      $ini += strlen($start);
      $len = strpos($string,$end,$ini) - $ini;
      return substr($string,$ini,$len);
    }

}