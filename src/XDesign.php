<?php
namespace phpxdesign;
$con_host;$con_user;$con_pass;$con_schema;
$obj_request;$obj_xpublish_const;
$obj_site;$obj_page;$obj_publish;$obj_bootstrap;

class XDesign{
  function __construct($mycon_user, $mycon_pass, $mycon_host="localhost", $mycon_schema="xdesign") {
    global $con_user;
    global $con_pass;
    global $con_host;
    global $con_schema;
    $con_user=$mycon_user;
    $con_pass=$mycon_pass;
    $con_host=$mycon_host;
    $con_schema=$mycon_schema;
    //*
    $this->obj_pdo=new \phplibrary\PDO;
    $this->obj_pdo->fn_connect($con_host, $con_user, $con_pass, $con_schema);
    //*/

    $this->bln_debug=true;
  }
  function fn_execute() {

    global $obj_request;
    global $obj_xpublish_const;
    global $obj_site;
    global $obj_publish;

    $obj_request=new \phplibrary\ServerVariables();
    //$obj_xpublish_const=new XPublishConstant();

    //fn_write_post();

    //echo "SUCCESSABC";


//*
$str_json= file_get_contents("php://input");
//var_dump($str_json);
echo(PHP_EOL);
$obj_post = json_decode($str_json);
$this->obj_post=$obj_post;
//$arr_myArray = json_decode($str_json, true);

//var_dump($obj_myObject);

$str_action=$obj_post->Action;
$this->str_data="";
if(isset($obj_post->Data)){
  $this->str_data=$obj_post->Data;
}

/*
echo("str_action: ".$str_action);
echo(PHP_EOL);
echo("$this->str_data: ".$this->str_data);
echo(PHP_EOL);
//*/

    switch($str_action){
      case "saveDesignerToServer":
        $this->fn_saveDesignerToServer();
      break;
      case "loadDesignerFromServer":
        $this->fn_loadDesignerFromServer();
      break;
      default:
        echo "XDesign ACTION Not Handled: [".$str_action."]";
    }
  }
  function fn_loadDesignerFromServer(){

    $str_sql="SELECT * FROM `xdesign`.`container` LIMIT 1;";//siteItem
    $stmt = $this->obj_pdo->pdo->query($str_sql);
    $row=$stmt->fetch();
    if($row){
      //var_dump($row);
      $str_data=$row["Serialize"];
      echo($str_data);
    }
  }
  function fn_saveDesignerToServer(){

    $str_data=$this->str_data;
    $str_data=$this->obj_pdo->pdo->quote($str_data);

    $str_sql="DELETE FROM `xdesign`.`container` LIMIT 1;";//siteItem
    $stmt = $this->obj_pdo->pdo->query($str_sql);

    $str_sql="INSERT INTO `xdesign`.`container` (`serialize`) VALUES ($str_data);";
    $stmt = $this->obj_pdo->pdo->query($str_sql);

    if($this->bln_debug){
      echo("fn_saveDesignerToServer: SUCCESS");
    }
  }
}//END CLASS XDesign
?>
