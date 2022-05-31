<?php

/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/

include('classes/Factory_Management.supplierquestionairre.class.php');
include('classes/Factory_Management.supplierquestionairres.class.php');

function factory_management_form_handler($SubmittedForm)
{
  if ($SubmittedForm->validate()) {
    $API  = new PerchAPI(1.0, 'factory_management');
    $supplierQuestionnaire = new Supplier_Questionnaires($API);

    switch ($SubmittedForm->formID) {

      case 'supplier_questionnaire':
        $data = $SubmittedForm->data;
        $data['SUPPLIER_REF'] = $_GET['id'];
        $data = $supplierQuestionnaire->submit_questionnaire($data);
        break;
    
    }

  } else {
    echo "Not Validated";
  }
}