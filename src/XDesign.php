<?php
namespace phpxpublish;
$con_host;$con_user;$con_pass;$con_schema;
$obj_request;$obj_xpublish_const;
$obj_site;$obj_page;$obj_publish;$obj_bootstrap;

class XPublish{
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
    $obj_site=new SiteItem();
    $obj_publish=new Publish($obj_site->obj_page);

    $obj_publish->fn_start();
echo <<<CLIENT
    <!DOCTYPE html>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
    a{color:black;text-decoration:none;}
    a:hover {color:black;}
    .nav-link > a{text-decoration:none;}
    .recordtable {width: inherit;}
    .recordlabel {text-align:right;width:10%;}
    .my-max {max-width: 100%;height: auto !important;}
    </style>
    <title>Console</title>
    <body style="overflow-y: scroll;">
CLIENT;
    $obj_site->fn_execute();
echo <<<CLIENT
    </body>
CLIENT;
    $obj_publish->fn_end();
  }
}//END CLASS XPUBLISH
?>
