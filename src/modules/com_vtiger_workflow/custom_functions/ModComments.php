<?php
require_once('modules/com_vtiger_workflow/custom_functions/utils.php');
/**
 * Update last modified field on related entity when a comment is added
 * @global object $adb
 * @global object $current_user
 * @param object $entity 
 * @author Pablo Veintimilla <pabloveintimilla@clouder7.com>
 */
function UpdateLastModified($entity){
    global $adb, $current_user;

    $data = $entity->getData();        
    $relatedTo =  explode('x',$data['related_to']);
    $relatedToId = $relatedTo[1];
    $relatedToModule = cf_getModuleName($relatedTo[0]);
    
    if(!$relatedToModule) return false;

    //Update last modification
    $today_now = date('y-m-d h:i:s');
    $today_now=getvaliddbinsertdatetimevalue($today_now);

    $entityUpdate = crmentity::getinstance($relatedToModule);
    $entityUpdate->retrieve_entity_info($relatedToId, $relatedToModule);
    $entityUpdate->column_fields["modifiedtime"]=$today_now;
    $entityUpdate->id = $relatedToId;
    $entityUpdate->mode="edit";
    $entityUpdate->save($relatedToModule);   
    
    //Update tracker
    $id = $adb->getUniqueId('vtiger_modtracker_basic');
    $adb->pquery('INSERT INTO vtiger_modtracker_basic(id, crmid, module, whodid, changedon, status)
                  VALUES(?,?,?,?,?,?)', Array($id, $relatedToId, $relatedToModule, $current_user->id, date('Y-m-d H:i:s',time()), ModTracker::$UPDATED));        
}
