<?php
namespace phpxdesign;

use stdClass;


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

      try {
        $this->fn_runQuery();
      } catch (\Exception $e) {
        throw $this->fn_addEcho($e->getMessage());        
      }
    }

    function fn_runQuery() {

      global $obj_request;
      global $obj_xpublish_const;
      global $obj_site;
      global $obj_publish;

      $obj_request=new \phplibrary\ServerVariables();
      //$obj_xpublish_const=new XPublishConstant();

      //*
      $str_json= file_get_contents("php://input");

      $obj_post = json_decode($str_json);
      $this->obj_post=$obj_post;


      if(empty($obj_post->Action)){
        $obj_post->Action="";
      }
      if(empty($obj_post->Context)){
        $obj_post->Context="";
      }
      if(empty($obj_post->Query)){
        $obj_post->Query="";
      }
      if(empty($obj_post->RecordId)){
        $obj_post->RecordId=0;
      }
      if(empty($obj_post->RecordName)){
        $obj_post->RecordName="notset";
      }
      if(empty($obj_post->RecordType)){
        $obj_post->RecordType="notset";
      }
      if(empty($obj_post->Bootable)){
        $obj_post->Bootable=0;
    }
      if(empty($obj_post->ObjectData)){
          $obj_post->ObjectData="{}";
      }
      if(empty($obj_post->ObjectPublishHTML)){
        $obj_post->ObjectPublishHTML="{}";
    }
      if(empty($obj_post->RowData)){
        $obj_post->RowData="[]";
      }
      if(empty($obj_post->Echo)){
        $obj_post->Echo="";
      }
      if(empty($obj_post->HasError)){
        $obj_post->HasError=false;
      }
      if(empty($obj_post->ErrorMessage)){
        $obj_post->ErrorMessage="";
      }

      switch($obj_post->Action){
        case "getBootable":
          $this->fn_getBootable();

        break;
        case "openInstance":
          $this->fn_openInstance();
        break;
        case "saveInstance":
          $this->fn_saveInstance();
        break;
        case "publishInstance":
          $this->fn_publishInstance();
        break;
        case "saveAsInstance":
          $this->fn_saveAsInstance();
        break;
        case "deleteInstance":
          $this->fn_deleteInstance();
        break;
        default:
          $this->fn_openQuery();
          //$obj_post->HasError=true;
          //$obj_post->ErrorMessage="XDesign ACTION Not Handled: [".$obj_post->Action."]";
      }

      echo json_encode($obj_post);//write post back down to client
    }
    function fn_openQuery(){

      $obj_post=$this->obj_post;
      $obj_pdo=$this->obj_pdo;

      $stmt = $obj_pdo->query($obj_post->Query);//Be alert for open sql queries from client !!

      $row=$stmt->fetchAll();
      if($row){
        //$this->fn_formatPost($row);
        $obj_post->RowData=json_encode($row);
      }
      else{
        $obj_post->RowData="[{}]";
      }
    }
    function fn_deleteInstance(){
      $obj_post=$this->obj_post;
      $obj_pdo=$this->obj_pdo;

      if(empty($obj_post->RecordId)){
        //return;
      }

      $str_sql="DELETE FROM `xdesign`.`instance` WHERE `Id`=$obj_post->RecordId ;";

      if($this->bln_debug){$this->fn_addEcho($str_sql);}

      $stmt = $obj_pdo->query($str_sql);
      $row=$stmt->fetch();
      if($row){
        $this->fn_formatPost($row);
      }
      else{
        $this->fn_addEcho("EMPTY ROW");
      }

    }
    function fn_getBootable(){

      $obj_post=$this->obj_post;
      $obj_pdo=$this->obj_pdo;

      $str_sql="SELECT * From `xdesign`.`instance` WHERE Bootable LIMIT 1;";

      if($this->bln_debug){$this->fn_addEcho($str_sql);}

      $stmt = $obj_pdo->query($str_sql);
      $row=$stmt->fetch();
      if($row){
        $this->fn_formatPost($row);
      }

    }
    function fn_openInstance(){

      $obj_post=$this->obj_post;
      $obj_pdo=$this->obj_pdo;

      if(empty($obj_post->RecordId)){
        //return;
      }

      $str_sql="SELECT * FROM `xdesign`.`instance` WHERE `Id`=$obj_post->RecordId ;";

      if($this->bln_debug){$this->fn_addEcho($str_sql);}

      $stmt = $obj_pdo->query($str_sql);
      $row=$stmt->fetch();
      if($row){
        $this->fn_formatPost($row);
      }
      else{
        $this->fn_addEcho("EMPTY ROW");
      }
    }

    function fn_publishInstance(){

      $str_header=<<<heredoc
      <!DOCTYPE html><html lang="en">
      <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <style>
            * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
          }
      </style>
      </head>
      <body style="padding:100px">
heredoc;

      $str_footer=<<<heredoc
      </body>
      </html>
heredoc;

      $obj_post=$this->obj_post;
      $arr_json_decode=json_decode( $obj_post->ObjectPublishHTML, true);
      $str_decode=$arr_json_decode["PublishHTML"];
      $str_html=$str_header.$str_decode.$str_footer;
      $str_html=$str_decode;

      $str_document=$str_header.$str_html.$str_footer;			
      
      file_put_contents("viewinbrowser.html", $str_document);

      
    }


    function fn_saveInstance(){

      $obj_post=$this->obj_post;
      $obj_pdo=$this->obj_pdo;

      $int_idRecord=$obj_post->RecordId;
      $int_idRecord=$obj_pdo->quote($int_idRecord);

      $str_nameRecord=$obj_post->RecordName;
      $str_nameRecord=$obj_pdo->quote($str_nameRecord);
      $str_typeRecord=$obj_post->RecordType;
      $str_typeRecord=$obj_pdo->quote($str_typeRecord);
      $bln_bootable=$obj_post->Bootable;
      $bln_bootable=$obj_pdo->quote($bln_bootable);
      $str_objectData=$obj_post->ObjectData;
      $str_objectData=$obj_pdo->quote($str_objectData);


      $str_sql="UPDATE `xdesign`.`instance` SET `Name`=$str_nameRecord,`Type`=$str_typeRecord,`Bootable`=$bln_bootable,`Serialize`=$str_objectData ";

      if(isset($obj_post->ObjectPublishHTML)){
        $str_objectPublishHTML=$obj_post->ObjectPublishHTML;
        $str_objectPublishHTML=$obj_pdo->quote($str_objectPublishHTML);
        $str_sql.=",`PublishHTML`=$str_objectPublishHTML ";
      }

      $str_sql.="WHERE `Id`=$int_idRecord;";

      if($this->bln_debug){$this->fn_addEcho($str_sql);}

      $obj_pdo->query($str_sql);

      $obj_post->ObjectData="{}";
    }
    function fn_saveAsInstance(){

      $obj_post=$this->obj_post;
      $obj_pdo=$this->obj_pdo;

      $int_idRecord=$obj_post->RecordId;
      $int_idRecord=$obj_pdo->quote($int_idRecord);

      $str_nameRecord=$obj_post->RecordName;
      $str_nameRecord=$obj_pdo->quote($str_nameRecord);
      $str_typeRecord=$obj_post->RecordType;
      $str_typeRecord=$obj_pdo->quote($str_typeRecord);
      $bln_bootable=$obj_post->Bootable;
      $bln_bootable=$obj_pdo->quote($bln_bootable);
      $str_objectData=$obj_post->ObjectData;
      $str_objectData=$obj_pdo->quote($str_objectData);


      $str_sql="INSERT INTO `xdesign`.`instance` (`Name`,`Type`,`Bootable`, `Serialize`) VALUES ($str_nameRecord,$str_typeRecord,$bln_bootable,$str_objectData);";


      if($this->bln_debug){$this->fn_addEcho($str_sql);}
      //if($this->bln_debug){$this->fn_addEcho("str_objectData->str_type".$str_objectData->str_type);}

      $obj_pdo->query($str_sql);

      $obj_post->RecordId=$this->fn_get_last_insert_id();

      //*
      //Save id record direct into the object data
      $obj_ObjectData=json_decode($obj_post->ObjectData);
      $obj_ObjectData->int_idRecord=$obj_post->RecordId;
      $obj_post->ObjectData=json_encode($obj_ObjectData);
      $this->fn_saveInstance();
      //Save id record direct into the object data
      //*/

      $obj_post->ObjectData="{}";
    }
    function fn_addEcho($str_val){
      $this->obj_post->Echo.=$str_val.PHP_EOL;
    }
    function fn_formatPost($row){
      $obj_post=$this->obj_post;
      if($row){
        $obj_post->RecordId=$row["id"];
        $obj_post->RecordName=$row["Name"];
        $obj_post->RecordType=$row["Type"];
        $obj_post->Bootable=$row["Bootable"];
        $obj_post->ObjectData=$row["Serialize"];
      }
    }
    function fn_get_last_insert_id(){
      return $this->obj_pdo->pdo->lastInsertId();
    }
}//END CLASS XDesign
?>
