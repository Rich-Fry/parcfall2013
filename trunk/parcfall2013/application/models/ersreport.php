<?php

class ErsReport extends Eloquent 
{
	public static function generate()
	{
		//Override the max execution time because our report takes longer than 30 seconds to run
		ini_set("max_execution_time", 300);
		
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel = ErsReport::generateDemographics($objPHPExcel);
		$objPHPExcel = ErsReport::generateWorkLocationTab($objPHPExcel);
		$objPHPExcel = ErsReport::generateDisabilityCategoryTab($objPHPExcel);
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($_SERVER['DOCUMENT_ROOT'].'/ERS/SpeedERS_'.date("Y_m_d").'.xlsx');
		return('/ERS/SpeedERS_'.date("Y_m_d").'.xlsx');
		//$objWriter->save('SpeedERS.xlsx');
	}
	
	public static function download()
	{
		header ('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header ('Content-Disposition: attachment; filename="ERS Reports\SpeedERS_'.date("Y_m_d").'.xlsx"'); 
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel = $objReader->load('ERS Reports\SpeedERS_'.date("Y_m_d").'.xlsx');
		
		//$objPHPExcel->load('ERS Reports\SpeedERS_'.date("Y_m_d").'.xlsx');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		//readfile('ERS Reports\SpeedERS_'.date("Y_m_d").'.xlsx');
	}
	
	private static function generateDemographics($objPHPExcel)
	{
		// Create a new worksheet
		$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Demographics');
		$objPHPExcel->addSheet($myWorkSheet, 0);
		$objPHPExcel->setActiveSheetIndexByName('Demographics');
				
		//Set the titles for each column
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Person Number');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Gender');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Year of Birth');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Home Zip Code + 4');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Race and Ethnicity');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Marital Status');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Veteran?');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Special Disabled Veteran?');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Veteran Date of Separation?');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Hire Date');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'AbilityOne Eligibility');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Person with a Disability?');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Primary Disability ');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Additional Disability 1');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Additional Disability 2');
		$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Additional Disability 3');
		$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Employee of NPA?');
		$objPHPExcel->getActiveSheet()->setCellValue('R1', 'AbilityOne Direct Labor?');
		$objPHPExcel->getActiveSheet()->setCellValue('S1', 'AbilityOne Indirect Labor?');
		$objPHPExcel->getActiveSheet()->setCellValue('T1', 'State Use Projects?');
		$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Other Project?');
		$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Work Location Code');
		$objPHPExcel->getActiveSheet()->setCellValue('W1', 'Paid AbilityOne Hours in Quarter');
		$objPHPExcel->getActiveSheet()->setCellValue('X1', 'AbilityOne Compensation in Quarter, excluding Health & Welfare');
		$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'AbilityOne Health and Welfare Payments in Quarter');
		$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'Paid Non-AbilityOne Hours in Quarter');
		$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'Non-AbilityOne Compensation in Quarter, excluding Health & Welfare');
		$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'Non-AbilityOne Health and Welfare Payments in Quarter ');
		$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'Training Wage?');
		$objPHPExcel->getActiveSheet()->setCellValue('AD1', 'FLSA 14c Certificate?');
		$objPHPExcel->getActiveSheet()->setCellValue('AE1', 'Productivity in Primary Job?');
		$objPHPExcel->getActiveSheet()->setCellValue('AF1', 'Basis for Productivity');
		$objPHPExcel->getActiveSheet()->setCellValue('AG1', 'Eligible for Fringe Benefits');
		$objPHPExcel->getActiveSheet()->setCellValue('AH1', 'Separation Date');
		$objPHPExcel->getActiveSheet()->setCellValue('AI1', 'Separation Type');
		$objPHPExcel->getActiveSheet()->setCellValue('AJ1', 'Separation Reason');
		$objPHPExcel->getActiveSheet()->setCellValue('AK1', 'ERS Identifier');

		//Initialize the ids
		$employeeNumberId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Person Number')->get();
		$genderId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Gender')->get();
		$birthdateId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Birthdate')->get();
		$zipCodeId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Zip Code')->get();
		$ethnicityId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Ethnicity')->get();
		$w4StatusId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'W-4 Status')->get();
		$veteranId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Veteran')->get();
		$specialDisabledVeteranId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Special Disabled Veteran')->get();
		$veteranDateOfSeparationId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Veteran Date of Separation')->get();
		$hireDateId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Hire Date')->get();
		$abilityOneEligibilityId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'AbilityOne Eligibility')->get();
		$personWithADisabiliityId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Person with a Disabiliity')->get();
		$primaryDisabilityId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Primary Disability')->get();
		$additionalDisability1Id = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Additional Disability 1')->get();
		$additionalDisability2Id = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Additional Disability 2')->get();
		$additionalDisability3Id = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Additional Disability 3')->get();
		$employeeOfNPAId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Employee of NPA')->get();
		$abilityOnEDirectLaborId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'AbilityOn E Direct Labor')->get();
		$abilityOnEIndirectLaborId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'AbilityOn E Indirect Labor')->get();
		$stateUseProjectsId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'State Use Projects')->get();
		$otherProjectId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Other Project')->get();
		$workLocationCodeId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Work Location Code')->get();
		$trainingWageId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Training Wage')->get();
		$fLSA14cCertificateId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'FLSA 14c Certificate')->get();
		$productivityInPrimaryJobId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Productivity in Primary Job')->get();
		$basisForProductivityId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Basis for Productivity')->get();
		$eligibleForFringeBenefitsId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Eligible for Fringe Benefits')->get();
		$separationDateId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Separation Date')->get();
		$separationTypeId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Separation Type')->get();
		$separationReasonId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Separation Reason')->get();
		$socialSecurityNumberId = Formquestion::select('formquestion.id as id')->where('formquestion.questionText', '=', 'Social Security Number')->get();
		

		$indexer = 2;//Leave a row for the titles on the excel 1-based spreadsheet
		$employees = Employee::select('employee.id as id')->get();
		
		foreach ($employees as $employee) {
			$id = $employee->id;
			
			$employeeNumber = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $employeeNumberId[0]->id)->get();
			$gender = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $genderId[0]->id)->get();
			$birthdate = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $birthdateId[0]->id)->get();
			$zipCode = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $zipCodeId[0]->id)->get();
			$ethnicity = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $ethnicityId[0]->id)->get();
			$w4Status = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $w4StatusId[0]->id)->get();
			$veteran = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $veteranId[0]->id)->get();
			$specialDisabledVeteran = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $specialDisabledVeteranId[0]->id)->get();
			$veteranDateOfSeparation = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $veteranDateOfSeparationId[0]->id)->get();
			$hireDate = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $hireDateId[0]->id)->get();
			$abilityOneEligibility = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $abilityOneEligibilityId[0]->id)->get();
			$personWithADisabiliity = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $personWithADisabiliityId[0]->id)->get();
			$primaryDisability = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $primaryDisabilityId[0]->id)->get();
			$additionalDisability1 = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $additionalDisability1Id[0]->id)->get();
			$additionalDisability2 = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $additionalDisability2Id[0]->id)->get();
			$additionalDisability3 = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $additionalDisability3Id[0]->id)->get();
			$employeeOfNPA = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $employeeOfNPAId[0]->id)->get();
			$abilityOnEDirectLabor = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $abilityOnEDirectLaborId[0]->id)->get();
			$abilityOnEIndirectLabor = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $abilityOnEIndirectLaborId[0]->id)->get();
			$stateUseProjects = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $stateUseProjectsId[0]->id)->get();
			$otherProject = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $otherProjectId[0]->id)->get();
			$workLocationCode = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $workLocationCodeId[0]->id)->get();
			$trainingWage = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $trainingWageId[0]->id)->get();
			$fLSA14cCertificate = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $fLSA14cCertificateId[0]->id)->get();
			$productivityInPrimaryJob = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $productivityInPrimaryJobId[0]->id)->get();
			$basisForProductivity = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $basisForProductivityId[0]->id)->get();
			$eligibleForFringeBenefits = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $eligibleForFringeBenefitsId[0]->id)->get();
			$separationDate = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $separationDateId[0]->id)->get();
			$separationType = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $separationTypeId[0]->id)->get();
			$separationReason = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $separationReasonId[0]->id)->get();
			$socialSecurityNumber = Questionresponse::select('questionresponse.response as response')->where('questionresponse.employee_id','=',$id)->where('questionresponse.formquestion_id', '=', $socialSecurityNumberId[0]->id)->get();
			
			//encrypt the social security with sha256 hash algorithm
			$socialHash = false;
			if(sizeof($socialSecurityNumber) > 0)
			{
				$socialSecurityNumber = hash("sha256", $socialSecurityNumber[0]->response);
				$socialHash = true;
			}
			
			if(sizeOf($employeeNumber) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$indexer, $employeeNumber[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$indexer, "NOT RECORDED");
			if(sizeOf($gender) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$indexer, $gender[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$indexer, "NOT RECORDED");
			if(sizeOf($birthdate) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$indexer, substr($birthdate[0]->response, 0, 4));
				//We need to figure out if newly entered dates are being inserted with this same format or create a transform to make them do so
			else
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$indexer, "NOT RECORDED");
			if(sizeOf($zipCode) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$indexer, $zipCode[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$indexer, "NOT RECORDED");
			if(sizeOf($ethnicity) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$indexer, $ethnicity[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$indexer, "NOT RECORDED");
			if(sizeOf($w4Status) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$indexer, $w4Status[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$indexer, "NOT RECORDED");
			if(sizeOf($veteran) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$indexer, $veteran[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$indexer, "NOT RECORDED");
			if(sizeOf($specialDisabledVeteran) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$indexer, $specialDisabledVeteran[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$indexer, "NOT RECORDED");
			if(sizeOf($veteranDateOfSeparation) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$indexer, $veteranDateOfSeparation[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$indexer, "NOT RECORDED");
			if(sizeOf($hireDate) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$indexer, $hireDate[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$indexer, "NOT RECORDED");
			if(sizeOf($abilityOneEligibility) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$indexer, $abilityOneEligibility[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$indexer, "NOT RECORDED");
			if(sizeOf($personWithADisabiliity) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$indexer, $personWithADisabiliity[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$indexer, "NOT RECORDED");
			if(sizeOf($primaryDisability) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$indexer, $primaryDisability[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$indexer, "NOT RECORDED");
			if(sizeOf($additionalDisability1) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$indexer, $additionalDisability1[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$indexer, "NOT RECORDED");
			if(sizeOf($additionalDisability2) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$indexer, $additionalDisability2[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$indexer, "NOT RECORDED");
			if(sizeOf($additionalDisability3) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$indexer, $additionalDisability3[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$indexer, "NOT RECORDED");
			if(sizeOf($employeeOfNPA) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$indexer, $employeeOfNPA[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$indexer, "NOT RECORDED");
			if(sizeOf($abilityOnEDirectLabor) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$indexer, $abilityOnEDirectLabor[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$indexer, "NOT RECORDED");
			if(sizeOf($abilityOnEIndirectLabor) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$indexer, $abilityOnEIndirectLabor[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$indexer, "NOT RECORDED");
			if(sizeOf($stateUseProjects) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$indexer, $stateUseProjects[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$indexer, "NOT RECORDED");
			if(sizeOf($otherProject) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$indexer, $otherProject[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$indexer, "NOT RECORDED");
			if(sizeOf($workLocationCode) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$indexer, $workLocationCode[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$indexer, "NOT RECORDED");
	
	
			//TODO: insert Encore data here
	
	
			if(sizeOf($trainingWage) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('AC'.$indexer, $trainingWage[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('AC'.$indexer, "NOT RECORDED");
			if(sizeOf($fLSA14cCertificate) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('AD'.$indexer, $fLSA14cCertificate[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('AD'.$indexer, "NOT RECORDED");
			if(sizeOf($productivityInPrimaryJob) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('AE'.$indexer, $productivityInPrimaryJob[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('AE'.$indexer, "NOT RECORDED");
			if(sizeOf($basisForProductivity) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('AF'.$indexer, $basisForProductivity[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('AF'.$indexer, "NOT RECORDED");
			if(sizeOf($eligibleForFringeBenefits) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('AG'.$indexer, $eligibleForFringeBenefits[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('AG'.$indexer, "NOT RECORDED");
			if(sizeOf($separationDate) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('AH'.$indexer, $separationDate[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('AH'.$indexer, "NOT RECORDED");
			if(sizeOf($separationType) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('AI'.$indexer, $separationType[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('AI'.$indexer, "NOT RECORDED");
			if(sizeOf($separationReason) > 0)
				$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$indexer, $separationReason[0]->response);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$indexer, "NOT RECORDED");
			if($socialHash)
				$objPHPExcel->getActiveSheet()->setCellValue('AK'.$indexer, $socialSecurityNumber);
			else
				$objPHPExcel->getActiveSheet()->setCellValue('AK'.$indexer, "NOT RECORDED");
		 	
			$indexer++;
		} 
		
		return $objPHPExcel;
	}

	private static function generateWorkLocationTab($objPHPExcel)
	{
		//Add a sheet
		$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Work Location');
		$objPHPExcel->addSheet($myWorkSheet, 1);
		$objPHPExcel->setActiveSheetIndexByName('Work Location');
		
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Work Location Code');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Primary Work Location Name');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Primary Work Location Zip');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Primary Work Location Type');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Primary Industry');
		
		$indexer = 2;
		foreach (WorkLocation::getWorkLocations() as $location) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$indexer, $location->work_location_code);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$indexer, $location->primary_work_location_name);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$indexer, $location->primary_work_location_zip);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$indexer, $location->primary_work_location_type);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$indexer, $location->primary_industry);
			
			$indexer++;
		}
		
		return $objPHPExcel;
	}
	
	private static function generateDisabilityCategoryTab($objPHPExcel)
	{
		//Add a sheet
		$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Disability Category');
		$objPHPExcel->addSheet($myWorkSheet, 2);
		$objPHPExcel->setActiveSheetIndexByName('Disability Category');
		
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'NPA Disability Category');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'ERS Disability Category');
		
		$indexer = 2;
		foreach (DisabilityCategory::getDisabilityCategories() as $category) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$indexer, $category->npa_disability_category);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$indexer, $category->ers_disability_category);
			
			$indexer++;
		}
		
		return $objPHPExcel;
	}
	
} 