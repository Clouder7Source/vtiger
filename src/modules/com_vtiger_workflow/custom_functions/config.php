<?php
//Define custom functions to register
$custom_functions = array(
    array(  'module'=> 'ModComments',
            'label' => 'Update last modified date when a comment is added',
            'path'  => 'modules/com_vtiger_workflow/custom_functions/ModComments.php',
            'method'=> 'UpdateLastModified'),   
);
