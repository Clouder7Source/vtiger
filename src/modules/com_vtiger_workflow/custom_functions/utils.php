<?php
require_once 'include/utils/utils.php';
/**
 * Return module name by Id
 * @param integer $id Id of module to get name
 * @return string|bool string if get name or false if error
 * @author Pablo Veintimilla <pabloveintimilla@clouder7.com> 
 */
function cf_getModuleName($id){
    global $adb;
    
    $return = false;
    
    $result = $adb->pquery('select name from vtiger_ws_entity where id=?',array($id));
    $rowData = $adb->raw_query_result_rowdata($result, 0);
    
    if ($rowData){
        $return = $rowData['name'];
    }
    return $return;
}
/**
 * Check if a custom function is well format
 * @param string $module
 * @param string $path
 * @param string $method_name
 * @param string $method_function
 * @param object $emm EntityMethodManager
 * @return array process to define pass process and error detail if exist. 
 */
function cf_checkCustomFunction($module,$path,$method_name,$method_function,$emm){
    global $adb;
    
    $return = array('process' => false, 'error' => '');
    
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    
    //Check if function is already registred
    $result = $adb->pquery('SELECT workflowtasks_entitymethod_id FROM com_vtiger_workflowtasks_entitymethod WHERE module_name LIKE ? AND function_path LIKE ? AND function_name LIKE ?',array($module,$path,$method_function));
    $exist = $adb->raw_query_result_rowdata($result, 0);
    if($exist){
        $return['error'] = 'Function already exist';
        return $return;       
    }
    
    //Check path
    if(!file_exists($path)){
        $return['error'] = "No exist file: $path";
        return $return;        
    }
    //Check function
    require_once $path;
    if(!function_exists($method_function)){
        $return['error'] = "No exist functon: $method_function";
        return $return;        
    }    
    
    //Return
    $return['process'] = true;
    return $return;
}
?>
