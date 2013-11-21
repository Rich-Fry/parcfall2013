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

		$objPHPExcel->setActiveSheetIndexByName('Demographics');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($_SERVER['DOCUMENT_ROOT'].'/ERS/SpeedERS_'.date("Y_m_d").'.xlsx');
		return('/ERS/SpeedERS_'.date("Y_m_d").'.xlsx');
		//$objWriter->save('SpeedERS.xlsx');
	}

	private static function generateDemographics($objPHPExcel)
	{
		// Create a new worksheet
		$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Demographics');
		$objPHPExcel->addSheet($myWorkSheet, 0);
		$objPHPExcel->setActiveSheetIndexByName('Demographics');

		//Set the titles for each column
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Employee Name');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Shift');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Employee Number');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Gender');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Date of Birth');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Year of Birth');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Home Address');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Home Zip Code + 4');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Race and Ethnicity');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Marital Status');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Veteran?');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Special Disabled Veteran?');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Vietnam Veteran');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Veteran Date of Separation?');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Other Protected Veteran?');
		$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Hire Date');
		$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'AbilityOne Eligibility');
		$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Person with a Disability?');
		$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Primary Disability ');
		$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Additional Disability 1');
		$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Additional Disability 2');
		$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Additional Disability 3');
		$objPHPExcel->getActiveSheet()->setCellValue('W1', 'Employee of NPA?');
		$objPHPExcel->getActiveSheet()->setCellValue('X1', 'AbilityOne Direct Labor?');
		$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'AbilityOne Indirect Labor?');
		$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'State Use Projects?');
		$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'Other Project?');
		$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'Work Location Code');
		$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'Paid AbilityOne Hours in Quarter');
		$objPHPExcel->getActiveSheet()->setCellValue('AD1', 'AbilityOne Compensation in Quarter, excluding Health & Welfare');
		$objPHPExcel->getActiveSheet()->setCellValue('AE1', 'AbilityOne Health and Welfare Payments in Quarter');
		$objPHPExcel->getActiveSheet()->setCellValue('AF1', 'Paid Non-AbilityOne Hours in Quarter');
		$objPHPExcel->getActiveSheet()->setCellValue('AG1', 'Non-AbilityOne Compensation in Quarter, excluding Health & Welfare');
		$objPHPExcel->getActiveSheet()->setCellValue('AH1', 'Non-AbilityOne Health and Welfare Payments in Quarter ');
		$objPHPExcel->getActiveSheet()->setCellValue('AI1', 'Training Wage?');
		$objPHPExcel->getActiveSheet()->setCellValue('AJ1', 'FLSA 14c Certificate?');
		$objPHPExcel->getActiveSheet()->setCellValue('AK1', 'Productivity in Primary Job?');
		$objPHPExcel->getActiveSheet()->setCellValue('AL1', 'Basis for Productivity');
		$objPHPExcel->getActiveSheet()->setCellValue('AM1', 'Eligible for Fringe Benefits');
		$objPHPExcel->getActiveSheet()->setCellValue('AN1', 'Separation Date');
		$objPHPExcel->getActiveSheet()->setCellValue('AO1', 'Separation Type');
		$objPHPExcel->getActiveSheet()->setCellValue('AP1', 'Separation Reason');
		$objPHPExcel->getActiveSheet()->setCellValue('AQ1', 'ERS Identifier');

		//Initialize the ids
		$firstNameId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'First Name')->get();
		$lastNameId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Last Name')->get();
		$shiftID = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Shift')->get();
		$employeeNumberId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Employee Number')->get();
		$genderId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Gender')->get();
		$birthdateId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Birthdate')->get();
		$addressId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Address')->get();
		$addressLine2Id = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Address Line 2')->get();
		$cityId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'City')->get();
		$stateCodeId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'State Code')->get();
		$zipCodeId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Zip Code')->get();
		$ethnicityId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Ethnicity')->get();
		$w4StatusId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'W-4 Status')->get();
		$veteranId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Veteran')->get();
		$specialDisabledVeteranId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Special Disabled Veteran')->get();
		$vietnamVeteranId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Vietnam Veteran')->get();
		$veteranDateOfSeparationId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Veteran Date of Separation')->get();
		$otherProtectedVeteranId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Other Protected Veteran')->get();
		$hireDateId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Hire Date')->get();
		$abilityOneEligibilityId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'AbilityOne Eligibility')->get();
		$personWithADisabiliityId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Person with a Disabiliity')->get();
		$primaryDisabilityId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Primary Disability')->get();
		$additionalDisability1Id = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Additional Disability 1')->get();
		$additionalDisability2Id = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Additional Disability 2')->get();
		$additionalDisability3Id = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Additional Disability 3')->get();
		$employeeOfNPAId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Employee of NPA')->get();
		$abilityOnEDirectLaborId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'AbilityOn E Direct Labor')->get();
		$abilityOnEIndirectLaborId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'AbilityOn E Indirect Labor')->get();
		$stateUseProjectsId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'State Use Projects')->get();
		$otherProjectId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Other Project')->get();
		$workLocationCodeId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Work Location Code')->get();
		$trainingWageId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Training Wage')->get();
		$fLSA14cCertificateId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'FLSA 14c Certificate')->get();
		$productivityInPrimaryJobId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Productivity in Primary Job')->get();
		$basisForProductivityId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Basis for Productivity')->get();
		$eligibleForFringeBenefitsId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Eligible for Fringe Benefits')->get();
		$separationDateId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Separation Date')->get();
		$separationTypeId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Separation Type')->get();
		$separationReasonId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Separation Reason')->get();
		$socialSecurityNumberId = Formquestion::select('FormQuestion.id as id')->where('FormQuestion.questionText', '=', 'Social Security Number')->get();

		$indexer = 2;//Leave a row for the titles on the excel 1-based spreadsheet
		$employees = Employee::select('Employee.id as id')->get();

		foreach ($employees as $employee) {
			$id = $employee->id;

			$abilityOneEligibility = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $abilityOneEligibilityId[0]->id)->get();

			if(sizeOf($abilityOneEligibility) > 0)//This is our indicator that the person should be included in the ERSReport
			{
				$firstName = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $firstNameId[0]->id)->get();
				$lastName = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $lastNameId[0]->id)->get();
				$shift = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $shiftID[0]->id)->get();
				$employeeNumber = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $employeeNumberId[0]->id)->get();
				$gender = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $genderId[0]->id)->get();
				$birthdate = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $birthdateId[0]->id)->get();
				$address = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $addressId[0]->id)->get();
				$addressLine2 = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $addressLine2Id[0]->id)->get();
				$city = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $cityId[0]->id)->get();
				$stateCode = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $stateCodeId[0]->id)->get();
				$zipCode = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $zipCodeId[0]->id)->get();
				$ethnicity = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $ethnicityId[0]->id)->get();
				$w4Status = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $w4StatusId[0]->id)->get();
				$veteran = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $veteranId[0]->id)->get();
				$specialDisabledVeteran = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $specialDisabledVeteranId[0]->id)->get();
				$vietnamVeteran = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $vietnamVeteranId[0]->id)->get();
				$veteranDateOfSeparation = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $veteranDateOfSeparationId[0]->id)->get();
				$otherProtectedVeteran = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $otherProtectedVeteranId[0]->id)->get();
				$hireDate = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $hireDateId[0]->id)->get();

				$personWithADisabiliity = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $personWithADisabiliityId[0]->id)->get();
				$primaryDisability = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $primaryDisabilityId[0]->id)->get();
				$additionalDisability1 = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $additionalDisability1Id[0]->id)->get();
				$additionalDisability2 = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $additionalDisability2Id[0]->id)->get();
				$additionalDisability3 = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $additionalDisability3Id[0]->id)->get();
				$employeeOfNPA = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $employeeOfNPAId[0]->id)->get();
				$abilityOnEDirectLabor = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $abilityOnEDirectLaborId[0]->id)->get();
				$abilityOnEIndirectLabor = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $abilityOnEIndirectLaborId[0]->id)->get();
				$stateUseProjects = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $stateUseProjectsId[0]->id)->get();
				$otherProject = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $otherProjectId[0]->id)->get();
				$workLocationCode = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $workLocationCodeId[0]->id)->get();
				$trainingWage = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $trainingWageId[0]->id)->get();
				$fLSA14cCertificate = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $fLSA14cCertificateId[0]->id)->get();
				$productivityInPrimaryJob = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $productivityInPrimaryJobId[0]->id)->get();
				$basisForProductivity = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $basisForProductivityId[0]->id)->get();
				$eligibleForFringeBenefits = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $eligibleForFringeBenefitsId[0]->id)->get();
				$separationDate = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $separationDateId[0]->id)->get();
				$separationType = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $separationTypeId[0]->id)->get();
				$separationReason = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $separationReasonId[0]->id)->get();
				$socialSecurityNumber = Questionresponse::select('QuestionResponse.response as response')->where('QuestionResponse.employee_id','=',$id)->where('QuestionResponse.formquestion_id', '=', $socialSecurityNumberId[0]->id)->get();

				//encrypt the social security with sha256 hash algorithm
				$socialHash = false;
				if(sizeof($socialSecurityNumber) > 0)
				{
					$socialSecurityNumber = hash("sha256", $socialSecurityNumber[0]->response);
					$socialHash = true;
				}

				if(sizeOf($firstName) > 0 && sizeOf($lastName) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$indexer, $lastName[0]->response.", ".$firstName[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$indexer, "NOT RECORDED");
				if(sizeOf($shift) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$indexer, $shift[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$indexer, "NOT RECORDED");
				if(sizeOf($employeeNumber) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$indexer, $employeeNumber[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$indexer, "NOT RECORDED");
				if(sizeOf($gender) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$indexer, $gender[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$indexer, "NOT RECORDED");
				if(sizeOf($birthdate) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$indexer, substr($birthdate[0]->response, 5, 5));
					//We need to figure out if newly entered dates are being inserted with this same format or create a transform to make them do so
				else
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$indexer, "NOT RECORDED");
				if(sizeOf($birthdate) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$indexer, substr($birthdate[0]->response, 0, 4));
					//We need to figure out if newly entered dates are being inserted with this same format or create a transform to make them do so
				else
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$indexer, "NOT RECORDED");
				if(sizeOf($address) > 0)
				{
					$fullAddress = $address[0]->response;
					if(sizeOf($addressLine2) > 0)
						$fullAddress = $fullAddress." ".$addressLine2[0]->response;
					if(sizeOf($city) > 0)
						$fullAddress = $fullAddress." ".$city[0]->response;
					if(sizeOf($stateCode) > 0)
						$fullAddress = $fullAddress." ".$stateCode[0]->response;
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$indexer, $fullAddress);
				}
				else
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$indexer, "NOT RECORDED");
				if(sizeOf($zipCode) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$indexer, $zipCode[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$indexer, "NOT RECORDED");
				if(sizeOf($ethnicity) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('I'.$indexer, $ethnicity[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('I'.$indexer, "NOT RECORDED");
				if(sizeOf($w4Status) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$indexer, $w4Status[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$indexer, "NOT RECORDED");
				if(sizeOf($veteran) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('K'.$indexer, $veteran[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('K'.$indexer, "NOT RECORDED");
				if(sizeOf($specialDisabledVeteran) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('L'.$indexer, $specialDisabledVeteran[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('L'.$indexer, "NOT RECORDED");
				if(sizeOf($vietnamVeteran) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('M'.$indexer, $vietnamVeteran[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('M'.$indexer, "NOT RECORDED");
				if(sizeOf($veteranDateOfSeparation) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('N'.$indexer, $veteranDateOfSeparation[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('N'.$indexer, "NOT RECORDED");
				if(sizeOf($otherProtectedVeteran) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('O'.$indexer, $otherProtectedVeteran[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('O'.$indexer, "NOT RECORDED");
				if(sizeOf($hireDate) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$indexer, $hireDate[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$indexer, "NOT RECORDED");
				if(sizeOf($abilityOneEligibility) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$indexer, $abilityOneEligibility[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('Q'.$indexer, "NOT RECORDED");
				if(sizeOf($personWithADisabiliity) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('R'.$indexer, $personWithADisabiliity[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('R'.$indexer, "NOT RECORDED");
				if(sizeOf($primaryDisability) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$indexer, $primaryDisability[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$indexer, "NOT RECORDED");
				if(sizeOf($additionalDisability1) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('T'.$indexer, $additionalDisability1[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('T'.$indexer, "NOT RECORDED");
				if(sizeOf($additionalDisability2) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('U'.$indexer, $additionalDisability2[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('U'.$indexer, "NOT RECORDED");
				if(sizeOf($additionalDisability3) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('V'.$indexer, $additionalDisability3[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('V'.$indexer, "NOT RECORDED");
				if(sizeOf($employeeOfNPA) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('W'.$indexer, $employeeOfNPA[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('W'.$indexer, "NOT RECORDED");
				if(sizeOf($abilityOnEDirectLabor) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('X'.$indexer, $abilityOnEDirectLabor[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('X'.$indexer, "NOT RECORDED");
				if(sizeOf($abilityOnEIndirectLabor) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('Y'.$indexer, $abilityOnEIndirectLabor[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('Y'.$indexer, "NOT RECORDED");
				if(sizeOf($stateUseProjects) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('Z'.$indexer, $stateUseProjects[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('Z'.$indexer, "NOT RECORDED");
				if(sizeOf($otherProject) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('AA'.$indexer, $otherProject[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AA'.$indexer, "NOT RECORDED");
				if(sizeOf($workLocationCode) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('AB'.$indexer, substr($workLocationCode[0]->response, 0, 4));
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AB'.$indexer, "NOT RECORDED");


				//TODO: insert Encore data here


				if(sizeOf($trainingWage) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('AI'.$indexer, $trainingWage[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AI'.$indexer, "NOT RECORDED");
				if(sizeOf($fLSA14cCertificate) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$indexer, $fLSA14cCertificate[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$indexer, "NOT RECORDED");

				//This is from Encore too
				//if(sizeOf($productivityInPrimaryJob) > 0)
				//	$objPHPExcel->getActiveSheet()->setCellValue('AK'.$indexer, $productivityInPrimaryJob[0]->response);
				//else
				//	$objPHPExcel->getActiveSheet()->setCellValue('AK'.$indexer, "NOT RECORDED");

				if(sizeOf($basisForProductivity) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('AL'.$indexer, $basisForProductivity[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AL'.$indexer, "NOT RECORDED");
				if(sizeOf($eligibleForFringeBenefits) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('AM'.$indexer, $eligibleForFringeBenefits[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AM'.$indexer, "NOT RECORDED");
				if(sizeOf($separationDate) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('AN'.$indexer, $separationDate[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AN'.$indexer, "NOT RECORDED");
				if(sizeOf($separationType) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('AO'.$indexer, $separationType[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AO'.$indexer, "NOT RECORDED");
				if(sizeOf($separationReason) > 0)
					$objPHPExcel->getActiveSheet()->setCellValue('AP'.$indexer, $separationReason[0]->response);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AP'.$indexer, "NOT RECORDED");
				if($socialHash)
					$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$indexer, $socialSecurityNumber);
				else
					$objPHPExcel->getActiveSheet()->setCellValue('AQ'.$indexer, "NOT RECORDED");

				$indexer++;
			}

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