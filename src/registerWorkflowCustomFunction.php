<?php

/**
 * Register workflow custom functions define in config file. 
 * Call from http://<VTIGER_PATH>/registerWorkflowCustomFunction.php
 * @author Pablo Veintimilla <pabloveintimilla@clouder7.com> 
 */

require_once 'include/utils/utils.php';
require 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';

require_once 'modules/com_vtiger_workflow/custom_functions/utils.php';
require_once 'modules/com_vtiger_workflow/custom_functions/config.php';    

$emm = new VTEntityMethodManager($adb); 

echo "<table border=1 width='100%'>
        <tr>
            <th>Module</th>
            <th>Method</th>
            <th>Status</th>
            <th>Error</th>
        </tr>";
foreach($custom_functions as $function){
    echo "<tr>
            <td>$function[module]</td>
            <td>$function[method]</td>";
    $check = cf_checkCustomFunction($function['module'], $function['path'], $function['label'], $function['method'],$emm);
    if($check['process']){
        $emm->addEntityMethod(  $function['module'], 
                                $function['label'],  
                                $function['path'], 
                                $function['method']);
        echo " <td><span style='color:green'>OK</span></td>
                <td></td>";        
    }else{ 
        echo " <td><span style='color:red'>KO</span></td>
                <td>$check[error]</td>";            
    }
    echo "</tr>";
}
echo "</table>";
?>
