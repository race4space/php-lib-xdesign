<?php
namespace phpxdesign;

use stdClass;

$con_host;$con_user;$con_pass;$con_schema;
$obj_request;

class XDesign{
  function __construct($mycon_user, $mycon_pass, $mycon_host="localhost", $mycon_schema="xdesign") {
    
      global $con_host;
      global $con_user;
      global $con_pass;      
      global $con_schema;
      $con_user=$mycon_user;
      $con_pass=$mycon_pass;
      $con_host=$mycon_host;
      $con_schema=$mycon_schema;
      
      $this->obj_pdo=new \phplibrary\PDO;
      $this->obj_pdo->fn_connect($con_host, $con_user, $con_pass, $con_schema);      
      
      $this->filename_xdesign="xdesign.js";            
      $this->filename_runtime="filename_runtime.js";      
      $this->dbtype_runtime="RuntimeCode";       
      $this->filename_component_design_map="filename_component_design_map.js";      
      $this->filename_designtime="filename_designtime.js";
      $this->dbtype_designtime="DesigntimeCode";
      $this->filename_template="filename_template.js";
      $this->dbtype_template="TemplateCode";
      
      $this->filename_publishtime="filename_publishtime.js";
      $this->dbtype_publishtime="PublishtimeCode";
      $this->filename_css="xdesign.css";
      $this->dbtype_css="RuntimeCSS"; 

      $this->folderpath_designInstance="../xdesign";
      $this->folderpath_projectInstance="../xdesign-projects/MyProject";
      $this->folderpath_projectDestination="../MyProject";      
      $this->filename_xdesignIndex="index.html";
      
      //Palette Components      
      $this->filename_component_tag="filename_component_tag.js";      
      $this->dbtype_component_tag="Tag";            
      $this->filename_component_ajax="filename_component_ajax.js";
      $this->dbtype_component_ajax="AJAX";                              
      $this->filename_component_accordion="filename_component_accordion.js";
      $this->dbtype_component_accordion="Accordion";                              
      $this->filename_component_button="filename_component_button.js";
      $this->dbtype_component_button="Button";                              
      $this->filename_component_comment="filename_component_comment.js";
      $this->dbtype_component_comment="Comment";                            
      $this->filename_component_design="filename_component_design.js";            
      $this->dbtype_component_design="Design";            
      $this->filename_component_designfile="filename_component_designfile.js";
      $this->dbtype_component_designfile="DesignFile";
      $this->filename_component_flex="filename_component_flex.js";
      $this->dbtype_component_flex="Flex";
      $this->filename_component_grid="filename_component_grid.js";      
      $this->dbtype_component_grid="Grid";
      $this->filename_component_griditem="filename_component_griditem.js";            
      $this->dbtype_component_griditem="GridItem";
      $this->filename_component_img="filename_component_img.js";            
      $this->dbtype_component_img="Img";
      $this->filename_component_input="filename_component_input.js";            
      $this->dbtype_component_input="Input";
      $this->filename_component_inputandbutton="filename_component_inputandbutton.js";            
      $this->dbtype_component_inputandbutton="InputAndButton";
      $this->filename_component_inputtext="filename_component_inputtext.js";            
      $this->dbtype_component_inputtext="InputText";      
      $this->filename_component_menubutton="filename_component_menubutton.js";            
      $this->dbtype_component_menubutton="MenuButton";
      $this->filename_component_navelement="filename_component_navelement.js";            
      $this->dbtype_component_navelement="NavElement";
      $this->filename_component_table="filename_component_table.js";            
      $this->dbtype_component_table="Table";
      $this->filename_component_tablerow="filename_component_tablerow.js";            
      $this->dbtype_component_tablerow="TableRow";
      $this->filename_component_tablecell="filename_component_tablecell.js";                  
      $this->dbtype_component_tablecell="TableCell";
      $this->filename_component_tableheader="filename_component_tableheader.js";      
      $this->dbtype_component_tableheader="TableHeader";            
      $this->filename_component_textarea="filename_component_textarea.js";            
      $this->dbtype_component_textarea="Textarea";      
      $this->filename_component_textnode="filename_component_textnode.js";            
      $this->dbtype_component_textnode="TextNode";
      //Palette Components
      
      $this->bln_debug=false;
    }
    function fn_execute() {
      
      try {        
        $this->fn_runQuery();
      } 
      catch (\Exception $e) {
        throw $this->fn_addEcho($e->getMessage());
      }
    }

    function fn_runQuery() {
      
      global $obj_request;      
      

      $obj_request=new \phplibrary\ServerVariables();      

      //*
      $str_json= file_get_contents("php://input");

      $obj_post = json_decode($str_json);
      $this->obj_post=$obj_post;

      
      
      if(empty($obj_post->IsRoot)){
        $obj_post->IsRoot=false;
      }

      if(empty($obj_post->Action)){
        $obj_post->Action="";
      }
      if(empty($obj_post->Context)){
        $obj_post->Context="";
      }
      if(empty($obj_post->Query)){
        $obj_post->Query="";
      }
      if(empty($obj_post->DependentId)){
        $obj_post->DependentId="";
      }      
      if(empty($obj_post->RecordId)){
        $obj_post->RecordId=0;
      }
      if(empty($obj_post->RecordName)){
        $obj_post->RecordName="RecordNameNotSet";
      }
      if(empty($obj_post->NotifierId)){
        $obj_post->NotifierId="NotifierIdNotSet";
      }     
      
      if(empty($obj_post->DesignId)){
        $obj_post->DesignId="DesignIdNotSet";
      }      
      if(empty($obj_post->RecordType)){
        $obj_post->RecordType="RecordTypeNotSet";
      }      
      if(empty($obj_post->ObjectData)){
          $obj_post->ObjectData="{}";
      }      
      if(empty($obj_post->ProjectPin)){        
        $obj_post->ProjectPin=false;
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
        case "getComponentInstance":
          $this->fn_getComponentInstance();
        break;
        case "openInstance":
          $this->fn_openInstance();
        break;
        case "openInstanceHTML":
          $this->openInstanceHTML();
        break;
        case "openInstanceHTMLTest":
          $this->openInstanceHTMLTest();
        break;
        case "getListPinnedComponent":
          $this->fn_getListPinnedComponent();
        break;
        case "getListProject":
          $this->fn_getListProject();
        break;
        case "save":
          $this->fn_saveInstance();
        break;
        case "saveInstance":
          $this->fn_saveInstance();
        break;
        case "publish":
          $this->fn_publishInstance();
        break;
        case "publishInstance":
          $this->fn_publishInstance();
        break;
        case "saveAs":
          $this->fn_saveAsInstance();
        break;
        case "saveAsInstance":
          $this->fn_saveAsInstance();
        break;
        case "delete":
          $this->fn_deleteInstance();
        break;        
        case "deleteInstance":
          $this->fn_deleteInstance();
        break;        
        case "newProject":          
          $RecordId=0;
          $this->fn_newProject($RecordId);          
        break;
        case "setCurrentProject":                    
          $this->fn_setCurrentProject($this->obj_post->RecordId);          
        break;
        case "openCurrentProject":                    
          $this->fn_openCurrentProject();          
        break;
        case "pinCurrentProject":                    
          $this->fn_pinCurrentProject();          
        break;
        case "openBootInstance":                              
          $this->fn_openBootInstance();          
        break;
        case "buildDesigner":
          $this->fn_buildDesigner(false);          
        break;        
        case "SQLQuery":
          $this->fn_openQuery();          
        break;        
        default:          
          $obj_post->HasError=true;
          $obj_post->ErrorMessage="XDesign ACTION Not Handled: [".$obj_post->Action."]";
      }

      echo json_encode($obj_post);//write post back down to client
    }
    function fn_get_last_insert_id(){
      return $this->obj_pdo->pdo->lastInsertId();
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
        $obj_post->ObjectData=$row["Serialize"];
      }
    }

    function fn_getListPinnedComponent(){        
        
      $obj_post=$this->obj_post;
      $str_sql="SELECT `id`, `Name`, `Type` FROM  `xdesign`.`instance` WHERE `PalettePin`;";            
      $this->fn_addEcho($str_sql);
      $stmt = $this->obj_pdo->pdo->prepare($str_sql);
      $stmt->execute();

      $row=$stmt->fetchAll();
      if($row){       
        $obj_post->RowData=json_encode($row);
      }
      else{
        $obj_post->RowData="[{}]";
      }      
    } 
    function fn_getListProject(){        
        
      $obj_post=$this->obj_post;
      $str_sql="SELECT `id`, `Name`, `Type` FROM  `xdesign`.`instance` WHERE `ProjectPin`";                  
      $stmt = $this->obj_pdo->pdo->prepare($str_sql);      
      
      $stmt->execute();

      $row=$stmt->fetchAll();
      if($row){       
        $obj_post->RowData=json_encode($row);
      }
      else{
        $obj_post->RowData="[{}]";
      }
      
    } 

    function fn_formatHTML($str_nameFile, $str_data){

      $obj_post=$this->obj_post;

      $obj_post->FileName=$str_nameFile;
      $obj_post->RecordType="HTML";      
      $obj_post->ObjectData=json_encode($str_data);

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

      
      $str_sql="DELETE FROM `xdesign`.`instance` WHERE `Id`=$obj_post->RecordId ;";
      $stmt = $obj_pdo->query($str_sql);
      $row=$stmt->fetch();

      $str_sql="DELETE FROM `xdesign`.`componentlink` WHERE `InstanceId`=$obj_post->RecordId ;";
      $stmt = $obj_pdo->query($str_sql);
      $row=$stmt->fetch();
      

    }    
    function fn_getComponentInstance(){
      $obj_post=$this->obj_post;
      $obj_pdo=$this->obj_pdo;

      $str_sql=$obj_post->Query;

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

      

  

    function openInstanceHTML(){


      $str_nameFile="openInstanceHTML.html";
      //$str_nameFile="http://www.google.com";
      //$str_nameFile="http://www.reallysimplesystems.com";
      //$str_nameFile="https://www.bbc.com/";
      //$str_nameFile="https://www.foxnews.com/";
      //$str_nameFile="https://news.sky.com/";
      $str_nameFile="https://www.mozilla.org/en-US/firefox/new/?redirect_source=firefox-com";
      //$str_nameFile="https://mail.google.com/mail/u/0/";
      //$str_nameFile="https://matracasz.hu/";


      if($this->bln_debug){$this->fn_addEcho("str_nameFile: ". $str_nameFile);}

      $str_document=file_get_contents($str_nameFile);
      $this->fn_formatHTML($str_nameFile, $str_document);
    }

    function openInstanceHTMLTest(){


      $str_nameFile="test.html";
      if($this->bln_debug){$this->fn_addEcho("str_nameFile: ". $str_nameFile);}

      $str_document=file_get_contents($str_nameFile);
      $this->fn_formatHTML($str_nameFile, $str_document);
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
      $str_objectData=$obj_post->ObjectData;
      $str_objectData=$obj_pdo->quote($str_objectData);

      
      $str_sql="INSERT INTO `xdesign`.`instance` (`Name`,`Type`,`Serialize`) VALUES ($str_nameRecord,$str_typeRecord,$str_objectData);";

      if($this->bln_debug){$this->fn_addEcho($str_sql);}
      //if($this->bln_debug){$this->fn_addEcho("str_objectData->str_type".$str_objectData->str_type);}

      
      $obj_pdo->query($str_sql);
      
      $obj_post->RecordId=$this->fn_get_last_insert_id();
      
      //*
      //Save id record direct into the object data
      $obj_ObjectData=json_decode($obj_post->ObjectData);
      $obj_ObjectData->obj_design->int_idRecord=$obj_post->RecordId;      
      $obj_post->ObjectData=json_encode($obj_ObjectData);      
      $this->fn_saveInstance();      
      //Save id record direct into the object data
      //*/
      
      $obj_post->ObjectData="{}";
    }               
    
    function fn_saveInstance(){

      //requires obj post to have an accurate dependent id string

      $obj_post=$this->obj_post;
      $obj_pdo=$this->obj_pdo;

      $int_idRecord=$obj_post->RecordId;
      $int_idRecord=$obj_pdo->quote($int_idRecord);

      $str_nameRecord=$obj_post->RecordName;
      $str_nameRecord=$obj_pdo->quote($str_nameRecord);
      $str_typeRecord=$obj_post->RecordType;
      $str_typeRecord=$obj_pdo->quote($str_typeRecord);      
      $str_objectData=$obj_post->ObjectData;
      $str_objectData=$obj_pdo->quote($str_objectData);      
      $str_dependentId=$obj_post->DependentId;
      $str_dependentId=$obj_pdo->quote($str_dependentId);                       
      $int_projectPin=$this->fn_get_intBool($obj_post->ProjectPin);
      $int_projectPin=$obj_pdo->quote($int_projectPin);
      

      //$str_sql="UPDATE `xdesign`.`instance` SET `Name`=$str_nameRecord,`Type`=$str_typeRecord, `DependentId`=$str_dependentId, `Serialize`=$str_objectData ";
      $str_sql="UPDATE `xdesign`.`instance` SET `Name`=$str_nameRecord,`Type`=$str_typeRecord, `ProjectPin`=$int_projectPin, `DependentId`=$str_dependentId, `Serialize`=$str_objectData ";
      $str_sql.="WHERE `Id`=$int_idRecord;";      
      $obj_pdo->query($str_sql);      

      $obj_post->ObjectData="{}";

      //Temporary measure until Choose Project      
      if($this->obj_post->IsRoot){        
        $this->fn_setCurrentProject($this->obj_post->RecordId);
      }
      //Temporary measure until Choose Project
    }     

    function fn_get_intBool($foo_val){
      
      $int_val=1; 
      if(empty($foo_val)){$int_val=0;}                   
      switch ($foo_val) {                                  
        case false:          
          $int_val=0;          
          break;            
        case 0:
          $int_val=0;          
          break;        
      }              
      return $int_val;
  }


    
    function fn_openCurrentProject(){

      $int_idRecord=0;     
      $stmt = $this->obj_pdo->pdo->prepare("SELECT * FROM `xdesign`.`instance` WHERE CurrentProject;");
      $stmt->execute();
      $row=$stmt->fetch();      
      if($row){
        //$int_idRecord=$row["Id"];
        $this->fn_formatPost($row);
      }   
      
      $this->fn_addEcho("int_idRecord: ".$this->obj_post->RecordId);                    

      $obj_ini=new stdClass();
      $obj_ini->RecordId=$this->obj_post->RecordId;
      $obj_ini->str_path_folder=$this->folderpath_projectInstance;        
      $obj_ini->bln_publish=false;
      $obj_ini->str_nameTargetClass="";      
      $this->fn_buildProject($obj_ini);
    }
    function fn_setCurrentProject($int_idRecord){
      
      $this->obj_pdo->query("UPDATE `xdesign`.`instance` SET `CurrentProject`=0;");
      $this->obj_pdo->query("UPDATE `xdesign`.`instance` SET `CurrentProject`=1 WHERE `Id`=".$int_idRecord.";");
    }

    function fn_pinCurrentProject(){
      $this->obj_pdo->query("UPDATE `xdesign`.`instance` SET `PalettePin`=IF(`PalettePin`, 0,1) WHERE `CurrentProject`;");
    }

    
    
    
    
    function fn_newProject(){
      
      $obj_ini=new stdClass();
      $obj_ini->RecordId=0;
      $obj_ini->str_path_folder=$this->folderpath_projectInstance;      
      $obj_ini->bln_publish=false;
      $obj_ini->str_nameTargetClass="";      
      $this->fn_buildProject($obj_ini);
    }

    function fn_publishInstance(){

      
      //save the instance first.
      //requires obj post to have an accurate dependent id string
      //puboish does use the same client side route "actionSave" which runs fn_compileDependentId
      $this->fn_saveInstance();


      $obj_ini=new stdClass();
      $obj_ini->RecordId=$this->obj_post->RecordId;  
      $obj_ini->str_path_folder=$this->folderpath_projectDestination;
      $obj_ini->bln_publish=true;        
      $obj_ini->str_nameTargetClass="";      
      //$this->fn_debugBuildProject($obj_ini);
      $this->fn_buildProject($obj_ini);

      
      
    }
    
    function fn_buildProject($obj_ini){

      
      $RecordId=$obj_ini->RecordId;      
      $str_path_folder=$obj_ini->str_path_folder;            
      $bln_publish=$obj_ini->bln_publish;      
      $str_nameTargetClass=$obj_ini->str_nameTargetClass;
      
      if(empty($RecordId)){$RecordId=0;}
      if(empty($str_path_folder)){return;}
      if(empty($bln_publish)){$bln_publish=false;}      
      if(empty($str_nameTargetClass)){$str_nameTargetClass="Component";}//Default New Project Type, RecordId=0            
      
      if($bln_publish){
        $this->filename_xdesign="xdesign$RecordId.js";      
      }
      
      $stmt = $this->obj_pdo->pdo->prepare("SELECT * FROM `xdesign`.`instance` WHERE Id=$RecordId;");
      $stmt->execute();
      $row=$stmt->fetch();      
      if($row){$str_nameTargetClass=$row["Type"];}//Overide with Custom Project Type, if the Component has been Saved, RecordId=x
  
      
      //0 START Create Project Folder            
      if(empty($str_path_folder)){
        return;        
      }
      
      if(!file_exists($str_path_folder)){
        mkdir($str_path_folder, 0777);
      }
      //0 End Create Project Folder
      
      //1 START Create Project Index File
      $str_header=<<<heredoc
      <!DOCTYPE html>
      <html lang="en">
      <title>Document</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" type="text/css" href="xdesign.css"> 
      <script type="module" src="$this->filename_xdesign"></script>                  
      <body>
heredoc;
      
      $str_footer=<<<heredoc
      </body>
      </html>
heredoc;      
      
      $str_document=$str_header.$str_footer;
      //Write Code to File
      file_put_contents("$str_path_folder/$this->filename_xdesignIndex", $str_document);   
      //1 END Create Project Index File

      //2 START Create Project CSS File      
      //get css code from database
      $str_code=$this->fn_getComponentCodeFromDBType($this->dbtype_css);            
      if(!empty($str_code)){        
        //Write Code to File
        file_put_contents("$str_path_folder/$this->filename_css", $str_code);            
      }
      //2 END Create Project CSS File           
      
      
      //3 START Create Project Code File            
      $str_code_project="";      
      
      //get runtime code from database
      $str_code=$this->fn_getComponentCodeFromDBType($this->dbtype_runtime);            
      $str_code_project.=$str_code.PHP_EOL.PHP_EOL;            
      
      if(!$bln_publish){//designtime code
        //get designtime code from database
        $str_code=$this->fn_getComponentCodeFromDBType($this->dbtype_designtime);      
        $str_code_project.=$str_code.PHP_EOL.PHP_EOL;
      }
      else{
        //get designtime code from database
        $str_code=$this->fn_getComponentCodeFromDBType($this->dbtype_publishtime);      
        $str_code_project.=$str_code.PHP_EOL.PHP_EOL;
      }            
      
      //$this->arr_ComponentMap=["Button","Comment","Component", "Flex","Grid","GridItem","Input","InputAndButton","Img","MenuButton","NavElement","Table","TableRow","TableCell","TableHeader","Tag","Textarea","TextNode"];//This array is altered/addedto in fn_getComponentCodeFromListId      
      $this->arr_ComponentMap=[];//This array is altered/addedto in fn_getComponentCodeFromListId      
      //$this->arr_ComponentMap=["Tag"];//This array is altered/addedto in fn_getComponentCodeFromListId      
      
      
      //---Insert List of Required Components into Component Link Table
      $this->fn_createComponentLinkTableEntries($RecordId);
      
      //---Add Pinned Component (if not publish)   
      if(!$bln_publish){
        $this->fn_addPinnedComponentToLinkTable($RecordId);//add pinned components temporarily to buildproject
      }
      
      //---Write code base 
      //get dependent code from database 
      $str_code=$this->fn_getComponentCodeFromLinkTable($RecordId);                                
      $str_code_project.=$str_code.PHP_EOL.PHP_EOL;
      
      $str_code=$this->fn_getComponentMap();                          
      $str_code_project.=$str_code.PHP_EOL.PHP_EOL;

      
      
      //get own code template code from database 
      $str_code=$this->fn_getComponentCodeFromDBType($this->dbtype_template);//needs to go at the bottom of the file            
      $str_code_project.=$str_code.PHP_EOL.PHP_EOL;

      //-----Write Project Instance to JSONMap
      //write jsonmap from database to file - map must be included, publish or not.
      $str_code=$this->fn_updateProjectFileWithjsonObject($RecordId, $bln_publish);      
      $str_code_project.=$str_code.PHP_EOL.PHP_EOL; 

      //Write Code to File
      $str_path_filexdesign=$str_path_folder."/".$this->filename_xdesign;
      file_put_contents($str_path_filexdesign, $str_code_project);                  

      //START Update Project Code File with BootId and ClassName     

      $this->fn_updateTemplateFile($str_path_filexdesign, $RecordId, $str_nameTargetClass);
      //END Update Project Code File with BootId and ClassName 
      
      //---Delete Component Link
      //Remove ExisitngEntries
      $this->fn_removeComponentLinkTableEntries($RecordId);      
      //Remove ExisitngEntries

      //3 END Create Project Code File
    }

    function fn_removeComponentLinkTableEntries($int_idRecord){       

      //Remove ExisitngEntries
      $str_sql = "DELETE FROM `xdesign`.`Componentlink` WHERE `InstanceId` =".$int_idRecord.";";            
      if($this->bln_debug){$this->fn_addEcho("str_sql: ".$str_sql);}                  
      $stmt = $this->obj_pdo->pdo->prepare($str_sql);                                        
      $stmt->execute();      
      //Remove ExisitngEntries
    }


    function fn_createComponentLinkTableEntries($int_idRecord){       
      
      $obj_pdo=$this->obj_pdo;

      //1. Remove any exisitn entries for the RecordId in ComponentLink - safety
      //2. Build Dependent List            
      //3. Add Dependent List
      //4. Remove any orphan  
      
      //Remove ExisitngEntries
      $this->fn_removeComponentLinkTableEntries($int_idRecord);      
      //Remove ExisitngEntries

      //Add Dependent List
      $str_listDependentId=$this->fn_getDependentList($int_idRecord);//must include self      
      $this->fn_addEcho("NEW str_listDependentId: ".$str_listDependentId);
      //Add Dependent List

      //Add Dependent List      
      $this->fn_addDependentListToLinkTable($int_idRecord, $str_listDependentId);
      //Add Dependent List
      
      //removeOrphanComponentLink
      $str_sql = "DELETE FROM `xdesign`.`Componentlink` WHERE `InstanceId` NOT IN(SELECT `Id` FROM `xdesign`.`instance`);";      
      if($this->bln_debug){$this->fn_addEcho("str_sql: ".$str_sql);}                  
      $stmt = $obj_pdo->pdo->prepare($str_sql);                                        
      $stmt->execute();      
      //removeOrphanComponentLink
    }

    function fn_getDependentList($int_idRecord){

      $str_list=$this->fn_buildDependentList($int_idRecord);//must include self
      return rtrim($str_list, ',');            
    }

    function fn_buildDependentList($int_idRecord){

      //Build Dependent List      
      $str_list="";
      //Add Self to list      
      $str_list.=$int_idRecord.",";

      //For each item in depndnt list rpeat      
      $str_sql = "SELECT `DependentId` FROM `xdesign`.`instance` WHERE `Id` =".$int_idRecord.";";            
      if($this->bln_debug){$this->fn_addEcho("str_sql: ".$str_sql);}                  
      $stmt = $this->obj_pdo->pdo->prepare($str_sql);                                        
      $stmt->execute();      
      $row=$stmt->fetch();      
      if($row){$str_listDependentId=$row["DependentId"];}

      if(empty($str_listDependentId)){return $str_list;}      

      $arr_id=explode(",",$str_listDependentId);//grab list of child instance ids      
      $arr_length = count($arr_id);
      for($i=0;$i<$arr_length;$i++)
      {
        $int_idRecord=$arr_id[$i];      
        $str_list.=$this->fn_buildDependentList($int_idRecord);
      }        
      return $str_list;
    }    
    

    function fn_addDependentListToLinkTable($int_idRecord, $str_listDependentId){
      
      $obj_pdo=$this->obj_pdo;

      //create  entries relating to current instance
      $str_sql = "INSERT INTO `xdesign`.`Componentlink` (InstanceId, ComponentId)  VALUES (?,?);";      
      $stmt = $obj_pdo->pdo->prepare($str_sql);     
      //create  entries relating to current instance 
      
      if(empty($str_listDependentId)){
        $str_listDependentId="";//safety check , perhaps could be nulkl etc
      }      
      $arr_id=explode(",",$str_listDependentId);//grab list of child instance ids            
      $arr_length = count($arr_id);                  
      for($i=0;$i<$arr_length;$i++)
      {
        $int_id=$arr_id[$i];                      
        $bln_isNumeric=is_numeric($int_id);        
        if($bln_isNumeric){
          //$this->fn_addEcho("stmt->execute: ".$int_idRecord.": ".$int_id);
          $stmt->execute([$int_idRecord, $int_id]);
        }        
      }
    }

    function fn_addPinnedComponentToLinkTable($int_id_record){//added during buildproject           
      //publish uses save routnie to build sufficient list    
      //after this operaiton the list will be technically incorrect - including all pinned, including  required pinned componnents.
      //however the list will be correct again when the operaiton is next saved , or published
      $str_sql="INSERT INTO `xdesign`.`ComponentLink` (`InstanceId`, `ComponentId`) SELECT distinct $int_id_record, `Id` FROM `xdesign`.`instance` WHERE `PalettePin`;";            
      $stmt = $this->obj_pdo->pdo->prepare($str_sql);
      $stmt->execute();
    }   
    
    function fn_getComponentCodeFromLinkTable($int_id_record){      
      $str_code="";      
      
      //important also generates component map
      $obj_pdo=$this->obj_pdo;            
      $str_sql="SELECT group_concat(distinct component.`id`) as `list` FROM xdesign.componentlink join instance on componentId=instance.id join component on instance.type=component.Type ";      
      $str_sql.="WHERE ";      
      $str_sql.="`InstanceId`=".$int_id_record.";";
      //$this->fn_addEcho($str_sql);
      
      $stmt = $obj_pdo->query($str_sql);                  
      $row=$stmt->fetch();
      
      if($row){
        $str_list=$row["list"];                    
      }
      else{        
        $this->fn_addEcho("NO COMPONENTS FOUND FOR ".$int_id_record);
      }
      
      if(empty($str_list)){
        if($this->bln_debug){$this->fn_addEcho("str_list is empty: ".$int_id_record);}      
        return $str_code;
      }
      
      $str_code=$this->fn_getComponentCodeFromListId($str_list, $this->arr_ComponentMap);             
      return $str_code;
    }

    function fn_getComponentCodeFromListId($str_listRecord, &$arr_listRecord){
      //Note: &$arr_listRecord is passed by reference
      
      $str_listCode="";

      if(empty($str_listRecord)){
        return  $str_listCode;
      }
      
      $obj_pdo=$this->obj_pdo;      
      $str_sql="SELECT * FROM `xdesign`.`component` WHERE `Id` IN($str_listRecord) ;";
      if($this->bln_debug){$this->fn_addEcho($str_sql);}      
      $stmt = $obj_pdo->query($str_sql);      
      $str_listCode=PHP_EOL;      

      $bln_gotAJAX=false;
      while($row=$stmt->fetch()){               
        $str_id=$row["id"];              
        $str_type=$row["Type"];      
        $str_code=$row["Code"];  
        $int_AJAX=$this->fn_get_intBool($row["AJAX"]);
        $this->fn_addEcho("int_AJAX: ". $int_AJAX);
        /*
        if($this->bln_debug){$this->fn_addEcho("str_id: ". $str_id);}
        if($this->bln_debug){$this->fn_addEcho("str_type: ". $str_type);}
        if($this->bln_debug){$this->fn_addEcho("str_code: ". $str_code);}    
        if($this->bln_debug){$this->fn_addEcho("int_AJAX: ". $int_AJAX);}    
        //*/

        if($int_AJAX===1 && !$bln_gotAJAX){
          $bln_gotAJAX=true;
          $str_listCode.=$this->fn_getAJAXCode();
        }
        
        $str_listCode.=PHP_EOL;
        $str_listCode.="/*START COMPONENT//*/".PHP_EOL;
        $str_listCode.="/*id: ".$str_id."//*/".PHP_EOL;
        $str_listCode.="/*type: ".$str_type."//*/".PHP_EOL;        
        $str_listCode.=$str_code.PHP_EOL;        
        $str_listCode.="/*id: ".$str_id."//*/".PHP_EOL;
        $str_listCode.="/*type: ".$str_type."//*/".PHP_EOL;        
        $str_listCode.="/*END COMPONENT//*/".PHP_EOL;
        $str_listCode.=PHP_EOL;

        array_push($arr_listRecord, $str_type);
      }
      
      return  $str_listCode;
    }
    
    function fn_getAJAXCode(){
      $str_code=$this->fn_getComponentCodeFromDBType($this->dbtype_component_ajax);            
      return $str_code.PHP_EOL.PHP_EOL;      
    }
    

    function fn_updateProjectFileWithjsonObject($int_id_record, $bln_publish){     
      
      $str_code="";      
      $str_listRecord="";

      

      $str_code="";      
      $obj_pdo=$this->obj_pdo;            
      $str_sql="SELECT group_concat(distinct ComponentId) as `list` FROM `xdesign`.`ComponentLink` WHERE `InstanceId`='$int_id_record';";      
      //$this->fn_addEcho($str_sql);      
      $stmt = $obj_pdo->query($str_sql);                  
      $row=$stmt->fetch();      
      if($row){
        $str_listRecord=$row["list"];                            
      }
      else{
        if($this->bln_debug){$this->fn_addEcho("NO CODE FOUND");}        
      }

      //$str_listRecord.=",".$int_id_record;//add reference to self
      

      //$this->fn_addEcho("str_listRecord: " . $str_listRecord);
      
      $arr_listRecord=[];
      $str_code_json=$this->fn_getInstanceCodeFromListId($str_listRecord, $arr_listRecord);

      $str_listCodeStart="";
      $str_listCodeStart.=PHP_EOL;
      $str_listCodeStart.="/*START INSTANCE JSON MAP//*/".PHP_EOL;        
      $str_listCodeStart.="var obj_InstanceJSONMap = new Map([".PHP_EOL;

      $str_listCodeEnd="";
      $str_listCodeEnd.="]);".PHP_EOL;
      $str_listCodeEnd.="/*END INSTANCE JSON MAP//*/".PHP_EOL;

      $str_code.=$str_listCodeStart;
      if($bln_publish){
        //$str_code.=$str_code_json;      
      }
      $str_code.=$str_code_json;      
      $str_code.=$str_listCodeEnd;      

      return $str_code;
     }     

     function fn_getInstanceCodeFromListId($str_listRecord, &$arr_listRecord){
      //Note: &$arr_listRecord is passed by reference
      
      $str_listCode="";

      if(empty($str_listRecord)){
        return  $str_listCode;
      }
      
      $obj_pdo=$this->obj_pdo;      
      $str_sql="SELECT * FROM `xdesign`.`instance` WHERE `Id` IN($str_listRecord) ;";
      $this->fn_addEcho($str_sql);
      $stmt = $obj_pdo->query($str_sql);      
      $str_listCode=PHP_EOL;      

      while($row=$stmt->fetch()){               
        $str_id=$row["id"];              
        $str_type=$row["Type"];      
        $str_code=$row["Serialize"];         
        /*
        if($this->bln_debug){$this->fn_addEcho("str_id: ". $str_id);}
        if($this->bln_debug){$this->fn_addEcho("str_type: ". $str_type);}
        if($this->bln_debug){$this->fn_addEcho("str_code: ". $str_code);}    
        //*/

        
        $str_listCode.="[".$str_id.", ".$str_code."],".PHP_EOL;        
        array_push($arr_listRecord, $str_type);
      }

      $str_listCode=trim($str_listCode);//remove whitespace
      $str_listCode=substr($str_listCode, 0, -1);//trim trailing comma      
      $str_listCode.=PHP_EOL;//re-add  new line
      
      return  $str_listCode;
    }

    function fn_getComponentMap(){

      $str_code="";
      
      //Now have a list of all 

      //$str_debug=json_encode($arr_list);        
      //if($this->bln_debug){$this->fn_addEcho("arr_list: ".$str_debug);}      

      $arr_list=$this->arr_ComponentMap;
      
      $str_map="";
      $str_map.="//START AUTO GENERATED COMPONENT MAP".PHP_EOL;
      $str_map.="const obj_ComponentMap = new Map([";        
      $arr_length = count($arr_list);        
      for($i=0;$i<$arr_length;$i++)
      {        
        $str_val=$arr_list[$i];                
        //$str_key=strtolower($str_val);
        $str_key=$str_val;
        $str_map.="['$str_key', $str_val],";
      }
      $str_map = rtrim($str_map, ',');
      $str_map.="]);".PHP_EOL;        
      $str_map.="//END AUTO GENERATED MAP".PHP_EOL;
      if($this->bln_debug){$this->fn_addEcho("str_map: ".$str_map);}      

      $str_code.=$str_map;
      
      
      return $str_code;
    }
    

    function fn_updateTemplateFile($filename_xdesign, $int_id_recordBoot, $str_nameTargetClass){     
      
  
      $str_code = file_get_contents($filename_xdesign);  
      
      $str_search="{int_idRecord}";
      $str_replace=$int_id_recordBoot;
      $str_code = str_replace($str_search, $str_replace, $str_code);
    
      $str_search="{str_nameTargetClass}";
      $str_replace=$str_nameTargetClass;
      $str_code = str_replace($str_search, $str_replace, $str_code);
    
      if(!empty($str_code)){file_put_contents($filename_xdesign, $str_code);}
      //END Write Boot Record
     
     }     
    function fn_getComponentCodeFromDBType($str_type){

      $str_code="";      
      $obj_pdo=$this->obj_pdo;            
      $str_sql="SELECT group_concat(Id) as `list` FROM `xdesign`.`component` WHERE `Type`='$str_type';";
      //if($this->bln_debug){$this->fn_addEcho($str_sql);}
      $stmt = $obj_pdo->query($str_sql);                  
      $row=$stmt->fetch();      
      if($row){
        $str_list=$row["list"];                    
      }
      else{        
        if($this->bln_debug){$this->fn_addEcho("NO CODE FOUND");}
      }       
      //if($this->bln_debug){$this->fn_addEcho("List: ".$str_list);}
      if(!empty($str_list)){
        $arr_list=[];              
        $str_code=$this->fn_getComponentCodeFromListId($str_list, $arr_list);                  
      }
      
      return $str_code;
    }
    

     

     function fn_setPinStatus($int_id_record, $bln_status){                
      
      $int_status=0;
      if($bln_status){$int_status=1;}
      
      $str_sql="UPDATE `xdesign`.`Instance` SET PalettePin =$int_status WHERE `Id`=$int_id_record;";
      //$this->fn_addEcho("pin str_sql: ".$str_sql);
      $stmt = $this->obj_pdo->pdo->prepare($str_sql);
      $stmt->execute();
    }
    
    function fn_copyFile($str_folder_source, $str_folder_target, $str_name_file){
      file_put_contents($str_folder_target."/".$str_name_file, file_get_contents($str_folder_source."/".$str_name_file));
    }
  
////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
function fn_getDesignProjectId($bln_createBootFile){

  if($bln_createBootFile){
    return 0;
  };  

  $int_id_record=0;     
  $stmt = $this->obj_pdo->pdo->prepare("SELECT Id FROM `xdesign`.`instance` WHERE Type='Design' and `Name`='My Designer';");
  $stmt->execute();
  $row=$stmt->fetch();      
  if($row){$int_id_record=$row["Id"];}     
  $this->fn_addEcho("int_id_record Design: ".$int_id_record);  
  return $int_id_record;
} 

function fn_openBootInstance(){//run via action
  
    $this->fn_buildDesigner(true);  //build designer // build project // set id to 0 in project file
  }
function fn_buildDesigner($bln_createBootFile){//run via action  

  
  
  $this->int_id_recordDesign=$this->fn_getDesignProjectId($bln_createBootFile);      
  $this->fn_buildRuntimeFile();       
  $this->fn_buildDesigntimeFile();            
  $this->fn_buildPublishtimeFile();             
  $this->fn_buildTemplateFile();         
  $this->fn_buildComponentFile();      
  $this->fn_writeFilesToComponentTable();              
  $this->fn_deleteUneededFiles();  
  
  $obj_ini=new stdClass();
  $obj_ini->RecordId=$this->int_id_recordDesign;  
  $obj_ini->str_path_folder=$this->folderpath_designInstance;
  $obj_ini->bln_publish=false;    
  $obj_ini->str_nameTargetClass="Design";        
  $this->fn_debugBuildProject($obj_ini);    
  $this->fn_buildProject($obj_ini);   
  //$this->fn_addEcho("this->folderpath_designInstance: ". $this->folderpath_designInstance);  
}
function fn_debugBuildProject($obj_ini){

  $this->fn_addEcho("obj_ini->RecordId: ". $obj_ini->RecordId);
  $this->fn_addEcho("obj_ini->str_path_folder: ". $obj_ini->str_path_folder);  
  $this->fn_addEcho("obj_ini->bln_publish: ". $obj_ini->bln_publish);  
  $this->fn_addEcho("obj_ini->str_nameTargetClass: ". $obj_ini->str_nameTargetClass);  

}

function fn_buildRuntimeFile(){      

  //run build.js equivalent

  //*      
  $arr_file=[
    //RunTime must be at the top of the file    
    "Runtime/Shared.js",
    "Runtime/LevelObject.js",
    "Runtime/Holder.js",  
    "Runtime/BaseObject.js",      
    "Runtime/Component.js",    
    
    "Runtime/Debug.js",  
    "Runtime/myjson.js",        
    "Runtime/Main.js"    
    //RunTime must be at the top of the file
 ];
 $this->fn_concat_fileList($this->filename_runtime, $arr_file);
 //*/
}

function fn_dbTypeInstanceExist($int_idFixed, $str_dbtype){
  
  $str_sql="SELECT Id FROM `xdesign`.`instance` WHERE Id=? AND Type =? ;";
  $stmt = $this->obj_pdo->pdo->prepare($str_sql);  
  $stmt->execute([$int_idFixed, $str_dbtype]);
  $row=$stmt->fetch();        
  $int_id_record=0;  
  if($row){$int_id_record=$row["Id"];}
  return $int_id_record;  
}

function fn_writeFilesToComponentTable(){

  
  //write runtime code from file to database      
  $str_code = file_get_contents($this->filename_runtime);    
  $this->fn_updateFileToComponentTable(100, $this->dbtype_runtime, $str_code);    
  
  //write css code from file to database        
  $str_code = file_get_contents("Runtime/".$this->filename_css);   
  $this->fn_updateFileToComponentTable(110, $this->dbtype_css, $str_code);    
  
  //write designtime code from file to database      
  $str_code = file_get_contents($this->filename_designtime);  
  $this->fn_updateFileToComponentTable(120, $this->dbtype_designtime, $str_code);  
  
  //write publishtime code from file to database      
  $str_code = file_get_contents($this->filename_publishtime);  
  $this->fn_updateFileToComponentTable(180, $this->dbtype_publishtime, $str_code);  
  
  //write template code from file to database      
  $str_code = file_get_contents($this->filename_template);  
  $this->fn_updateFileToComponentTable(190, $this->dbtype_template, $str_code);      
    
  //write design component code from file to database      
  $str_code = file_get_contents($this->filename_component_design);  
  $this->int_id_componentCodeDesign=$this->fn_updateFileToComponentTable(210, $this->dbtype_component_design, $str_code);        
  
  
  $this->fn_bootPaletteComponent($this->filename_component_tag, $this->dbtype_component_tag, 300, true);          
  $this->fn_bootPaletteComponent($this->filename_component_ajax, $this->dbtype_component_ajax, 301, false);       
  $this->fn_bootPaletteComponent($this->filename_component_accordion, $this->dbtype_component_accordion, 320, true);  
  $this->fn_bootPaletteComponent($this->filename_component_button, $this->dbtype_component_button, 325, true);  
  $this->fn_bootPaletteComponent($this->filename_component_comment, $this->dbtype_component_comment, 330, false);      

//write boottime component code from file to database        
$str_filename=$this->filename_component_designfile;
$str_dbtype=$this->dbtype_component_designfile;  
$int_idRecord=335;  
$str_code = file_get_contents($str_filename);
$this->fn_updateFileToComponentTable($int_idRecord, $str_dbtype, $str_code, 1);          



  $this->fn_bootPaletteComponent($this->filename_component_flex, $this->dbtype_component_flex, 340, true);  
  $this->fn_bootPaletteComponent($this->filename_component_grid, $this->dbtype_component_grid, 350, true);  
  $this->fn_bootPaletteComponent($this->filename_component_griditem, $this->dbtype_component_griditem, 360, true);  
  $this->fn_bootPaletteComponent($this->filename_component_img, $this->dbtype_component_img, 370, true);  
  $this->fn_bootPaletteComponent($this->filename_component_input, $this->dbtype_component_input, 380, true);  
  $this->fn_bootPaletteComponent($this->filename_component_inputandbutton, $this->dbtype_component_inputandbutton, 390, true);      
  $this->fn_bootPaletteComponent($this->filename_component_inputtext, $this->dbtype_component_inputtext, 400, true);          
  $this->fn_bootPaletteComponent($this->filename_component_menubutton, $this->dbtype_component_menubutton, 410, true);    
  $this->fn_bootPaletteComponent($this->filename_component_navelement, $this->dbtype_component_navelement, 420, true);        
  $this->fn_bootPaletteComponent($this->filename_component_table, $this->dbtype_component_table, 430, true);      
  $this->fn_bootPaletteComponent($this->filename_component_tablerow, $this->dbtype_component_tablerow, 440, true);        
  $this->fn_bootPaletteComponent($this->filename_component_tablecell, $this->dbtype_component_tablecell, 450, true);      
  $this->fn_bootPaletteComponent($this->filename_component_tableheader, $this->dbtype_component_tableheader, 460, true);      
  $this->fn_bootPaletteComponent($this->filename_component_textarea, $this->dbtype_component_textarea, 480, true);        
  $this->fn_bootPaletteComponent($this->filename_component_textnode, $this->dbtype_component_textnode, 490, false);      
}

function fn_bootPaletteComponent($str_filename, $str_dbtype, $int_idRecord, $blnPalettePin, $int_AJAX=0){

  
  //write boottime code from file to database        
  $str_code = file_get_contents($str_filename);  
  $this->fn_updateFileToComponentTable($int_idRecord, $str_dbtype, $str_code, $int_AJAX);                
  $str_code = "{}";
  $this->fn_updateFileToInstanceTable($int_idRecord, $str_dbtype, $str_dbtype, $str_code);          
  $this->fn_setPinStatus($int_idRecord, $blnPalettePin);
}

function fn_updateFileToComponentTable($int_idFixed, $str_dbtype, $str_code, $int_AJAX=0){
  
  $int_id_record=$this->fn_dbTypeComponentExist($int_idFixed, $str_dbtype);  

  //$int_id_record=0;  
  
  if($int_id_record===0){
    $stmt = $this->obj_pdo->pdo->prepare("INSERT INTO `xdesign`.`component` (`Id`, `Type`, `Code`, `AJAX`) SELECT ?, ?, ?, ?;");
    $stmt->execute([$int_idFixed, $str_dbtype, $str_code, $int_AJAX]);
  }
  else{
    $str_sql="UPDATE `xdesign`.`component` SET `Code`=? WHERE `Id`=?;";    
    $stmt = $this->obj_pdo->pdo->prepare($str_sql);
    $stmt->execute([$str_code, $int_id_record]);
  }  
  return $int_id_record;
}

function fn_updateFileToInstanceTable($int_idFixed, $str_dbname, $str_dbtype, $str_code){
  
  $int_id_record=$this->fn_dbTypeInstanceExist($int_idFixed, $str_dbtype);  

  //$int_id_record=0;  
  
  if($int_id_record==0){
    $stmt = $this->obj_pdo->pdo->prepare("INSERT INTO `xdesign`.`instance` (`Id`, `Name`, `Type`, `DependentId`, `Serialize`) SELECT ?, ?, ?, ?, ?;");
    $stmt->execute([$int_idFixed, $str_dbname, $str_dbtype, "", $str_code]);
  }
  else{
    $str_sql="UPDATE `xdesign`.`instance` SET `Serialize`=? WHERE `Id`=?;";    
    $stmt = $this->obj_pdo->pdo->prepare($str_sql);
    $stmt->execute([$str_code, $int_id_record]);
  }  
  
  return $int_idFixed;
}

function fn_dbTypeComponentExist($int_idFixed, $str_dbtype){
  
  $str_sql="SELECT Id FROM `xdesign`.`component` WHERE Id=? AND Type =? ;";
  $stmt = $this->obj_pdo->pdo->prepare($str_sql);  
  $stmt->execute([$int_idFixed, $str_dbtype]);
  $row=$stmt->fetch();        
  $int_id_record=0;  
  if($row){$int_id_record=$row["Id"];}
  return $int_id_record;  
}

function fn_buildDesigntimeFile(){  
  
  $arr_file=[              
    
    "Component/Design/FileDelegate.js", 
    "Component/Design/DesignDelegate.js",
    "Component/Design/DesignDelegateGrid.js",
    "Component/Design/DesignDelegateGridItem.js",
    "Component/Design/DesignDelegateProjectInstance.js",
    "Component/Design/GlobalVariable.js"
  ];
  $this->fn_concat_fileList($this->filename_designtime, $arr_file);
}

function fn_buildPublishtimeFile(){  
  
  $arr_file=[      
    
  ];
  $this->fn_concat_fileList($this->filename_publishtime, $arr_file);
}

function fn_buildTemplateFile(){  
  
  $arr_file=[      
    "Runtime/Project.js"
  ];
  $this->fn_concat_fileList($this->filename_template, $arr_file);
}


function fn_buildComponentFile(){
  
  $arr_file=["Component/AJAX.js"];$this->fn_concat_fileList($this->filename_component_ajax, $arr_file);  
  $arr_file=["Component/Accordion.js"];$this->fn_concat_fileList($this->filename_component_accordion, $arr_file);
  $arr_file=["Component/Button.js"];$this->fn_concat_fileList($this->filename_component_button, $arr_file);
  $arr_file=["Component/Comment.js"];$this->fn_concat_fileList($this->filename_component_comment, $arr_file);
  $arr_file=["Component/DesignFile.js"];$this->fn_concat_fileList($this->filename_component_designfile, $arr_file);  
  $arr_file=["Component/Flex.js"];$this->fn_concat_fileList($this->filename_component_flex, $arr_file);    
  $arr_file=["Component/Grid.js"];$this->fn_concat_fileList($this->filename_component_grid, $arr_file);  
  $arr_file=["Component/GridItem.js"];$this->fn_concat_fileList($this->filename_component_griditem, $arr_file);  
  $arr_file=["Component/Img.js"];$this->fn_concat_fileList($this->filename_component_img, $arr_file);  
  $arr_file=["Component/Input.js"];$this->fn_concat_fileList($this->filename_component_input, $arr_file);  
  $arr_file=["Component/InputAndButton.js"];$this->fn_concat_fileList($this->filename_component_inputandbutton, $arr_file);    
  $arr_file=["Component/InputText.js"];$this->fn_concat_fileList($this->filename_component_inputtext, $arr_file);        
  $arr_file=["Component/Menubutton.js"];$this->fn_concat_fileList($this->filename_component_menubutton, $arr_file);
  $arr_file=["Component/NavElement.js"];$this->fn_concat_fileList($this->filename_component_navelement, $arr_file);
  $arr_file=["Component/Table.js"];$this->fn_concat_fileList($this->filename_component_table, $arr_file);
  $arr_file=["Component/TableRow.js"];$this->fn_concat_fileList($this->filename_component_tablerow, $arr_file);
  $arr_file=["Component/TableCell.js"];$this->fn_concat_fileList($this->filename_component_tablecell, $arr_file);      
  $arr_file=["Component/TableHeader.js"];$this->fn_concat_fileList($this->filename_component_tableheader, $arr_file);        
  $arr_file=["Component/Tag.js"];$this->fn_concat_fileList($this->filename_component_tag, $arr_file);          
  $arr_file=["Component/TextArea.js"];$this->fn_concat_fileList($this->filename_component_textarea, $arr_file);
  $arr_file=["Component/TextNode.js"];$this->fn_concat_fileList($this->filename_component_textnode, $arr_file);
  

  $arr_file=[      
    "Component/Design/Design.js",  
    "Component/Design/ManagerBootBuilder.js",
    "Component/Design/ManagerBootOptions.js",
    "Component/Design/ManagerIFrame.js",
    "Component/Design/ManagerProject.js",
    "Component/Design/ManagerPalette.js",    
    "Component/Design/ManagerFile.js",    
    "Component/Design/PropertySheet.js", 
    "Component/Design/ManagerProperty.js",
    "Component/Design/PropertySheetPaletteItem.js",
    "Component/Design/ManagerMessenger.js",
    "Component/Design/ObjectMap.js",
    "Component/Design/ObjectAction.js",
    "Component/Design/PropertyDOMProperty.js",
    "Component/Design/PropertyDOMAttribute.js",
    "Component/Design/PropertyDOMStyle.js",
    "Component/Design/PropertyDesign.js"    
  ];  
  
  $this->fn_concat_fileList($this->filename_component_design, $arr_file);

  $arr_file=[  
  
    "Component/ComponentMap.js"
    
  ];
  $this->fn_concat_fileList($this->filename_component_design_map, $arr_file);  
  
}

function fn_concat_fileList($str_file_target, $arr_list){
    
  file_put_contents($str_file_target, "");            
  $arr_length = count($arr_list);        
  for($i=0;$i<$arr_length;$i++)
  {
    $str_pathFile=$arr_list[$i];
    $str_code="";
    $str_code.="//START ".$str_pathFile.PHP_EOL;
    $str_code.=file_get_contents($str_pathFile).PHP_EOL;
    $str_code.="//END ".$str_pathFile.PHP_EOL;        
    file_put_contents($str_file_target, $str_code, FILE_APPEND);
  }
}

function fn_unlinkFile($filename){      
  if(file_exists($filename)){unlink($filename);}
}

function fn_deleteUneededFiles(){      
  
  $this->fn_unlinkFile($this->filename_runtime);    
  $this->fn_unlinkFile($this->filename_designtime);

  $this->fn_unlinkFile($this->filename_component_tag);          
  $this->fn_unlinkFile($this->filename_component_ajax);
  $this->fn_unlinkFile($this->filename_component_accordion);
  $this->fn_unlinkFile($this->filename_component_button);
  $this->fn_unlinkFile($this->filename_component_comment);
  $this->fn_unlinkFile($this->filename_component_design);  
  $this->fn_unlinkFile($this->filename_component_designfile);    
  $this->fn_unlinkFile($this->filename_component_flex);
  $this->fn_unlinkFile($this->filename_component_grid);
  $this->fn_unlinkFile($this->filename_component_griditem);  
  $this->fn_unlinkFile($this->filename_component_img);
  $this->fn_unlinkFile($this->filename_component_input);
  $this->fn_unlinkFile($this->filename_component_inputandbutton);
  $this->fn_unlinkFile($this->filename_component_inputtext);
  $this->fn_unlinkFile($this->filename_component_menubutton);
  $this->fn_unlinkFile($this->filename_component_navelement);  
  $this->fn_unlinkFile($this->filename_component_table);  
  $this->fn_unlinkFile($this->filename_component_tablerow);    
  $this->fn_unlinkFile($this->filename_component_tablecell);      
  $this->fn_unlinkFile($this->filename_component_tableheader);          
  $this->fn_unlinkFile($this->filename_component_textarea);            
  $this->fn_unlinkFile($this->filename_component_textnode);
  $this->fn_unlinkFile($this->filename_component_design_map);    
  $this->fn_unlinkFile($this->filename_template);

  $this->fn_unlinkFile($this->filename_publishtime);  
}


////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
////////////////////////////////
}//END CLASS XDesign
?>
