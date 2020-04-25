<?php
namespace phpxdesign;
$con_host;$con_user;$con_pass;$con_schema;
$obj_request;$obj_xpublish_const;
$obj_site;$obj_page;$obj_publish;$obj_bootstrap;

class XDesign{
  function __construct($mycon_user, $mycon_pass, $mycon_host="localhost", $mycon_schema="my-vm") {
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
  }
  function fn_execute() {

    global $obj_request;
    global $obj_xpublish_const;
    global $obj_site;
    global $obj_publish;

    $obj_request=new \phplibrary\ServerVariables();
    $obj_xpublish_const=new XPublishConstant();

}//END CLASS XDesign
?>
