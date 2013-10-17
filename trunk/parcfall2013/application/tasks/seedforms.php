<?php
class SeedForms_Task {
	public function run($args)
	{
		//SeedForms_Task::form1();
		//SeedForms_Task::form2();
		//SeedForms_Task::form3();

		SeedForms_Task::F1();
		SeedForms_Task::F2();
		SeedForms_Task::F3();
		SeedForms_Task::F4();
	}

	//We would need to add an extra column to the database table for formQuestions and add an entry to every question
	// on the form in these functions to indicate what kind of field it should be

	//General tab of document set Beta provided by Josh at PARC
	//Written by Cory Snelson
	public function F1()
	{
	//Create the form
		$df = new DataForm;
		$df->formName = 'General Information Form';
		$df->formDescription = 'Collects General Information Data';
		$df->save();
		//TODO: update below line to associate with correct program or programs
		$programs = Program::where('programName', '=', 'General')->get();
		$df->program()->attach($programs[0]);


		//Create the questions

		//FieldTypes 1=textbox 2=combobox 3=datepicker 4=numeric 5=checkbox

		//Q1
		$fq = new FormQuestion;
		$fq->questionText = "First Name";
		$fq->questionExample = "First Name";
		$fq->fieldType = 1;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q2
		$fq = new FormQuestion;
		$fq->questionText = "Middle Initial";
		$fq->questionExample = "M.I.";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q3
		$fq = new FormQuestion;
		$fq->questionText = "Last Name";
		$fq->questionExample = "Last Name";
		$fq->fieldType = 1;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q4
		$fq = new FormQuestion;
		$fq->questionText = "Birthdate";
		$fq->questionExample = "MM/DD/YEAR";
		$fq->fieldType = 3;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q5
		$fq = new FormQuestion;
		$fq->questionText = "Social Security Number";
		$fq->questionExample = "XXX-XX-XXXX";
		$fq->fieldType = 1;
        $fq->validate = "^\d{3}-?\d{2}-?\d{4}$";
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q6
		$fq = new FormQuestion;
		$fq->questionText = "Address";
		$fq->questionExample = "Address Line 1";
		$fq->fieldType = 1;
		$fq->validate = "Address1";
		$df->questions()->save($fq);

		//Q7
		$fq = new FormQuestion;
		$fq->questionText = "Address Line 2";
		$fq->questionExample = "Address Line 2";
		$fq->fieldType = 0;
		$fq->validate = "Address2";
		$df->questions()->save($fq);

		//Q8
		$fq = new FormQuestion;
		$fq->questionText = "City";
		$fq->questionExample = "City";
		$fq->fieldType = 1;
		$fq->required = 1;
		$fq->validate = "City";
		$df->questions()->save($fq);

		//Q9
		$fq = new FormQuestion;
		$fq->questionText = "State Code";
		$fq->questionExample = "2 Digit Code";
		$fq->fieldType = 2;
		$fq->required = 1;
		$fq->validate = "State";
		$df->questions()->save($fq);

		//Q10
		$fq = new FormQuestion;
		$fq->questionText = "Zip Code";
		$fq->questionExample = "Zip Code";
		$fq->fieldType = 1;
		$fq->required = 1;
		$fq->validate = "Zip";
		$df->questions()->save($fq);

		//Q11
		$fq = new FormQuestion;
		$fq->questionText = "Country";
		$fq->questionExample = "Country";
		$fq->fieldType = 1;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q12
		$fq = new FormQuestion;
		$fq->questionText = "Maiden Name";
		$fq->questionExample = "Maiden Name";
		$fq->fieldType = 0;
		$df->questions()->save($fq);

		//Q13
		$fq = new FormQuestion;
		$fq->questionText = "Home Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q14
		$fq = new FormQuestion;
		$fq->questionText = "Work Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q15
		$fq = new FormQuestion;
		$fq->questionText = "Cell Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q16
		$fq = new FormQuestion;
		$fq->questionText = "Fax";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q17
		$fq = new FormQuestion;
		$fq->questionText = "E-mail Address";
		$fq->questionExample = "JaneDoe@sample.com";
		$fq->fieldType = 1;
        $fq->validate = "^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$";
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q18
		$fq = new FormQuestion;
		$fq->questionText = "Status";
		$fq->questionExample = "Active/Inactive";
		$fq->fieldType = 2;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q19
		$fq = new FormQuestion;
		$fq->questionText = "Employee Number";
		$fq->questionExample = "000000";
		$fq->fieldType = 4;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q20
		$fq = new FormQuestion;
		$fq->questionText = "Hire Date";
		$fq->questionExample = "MM/DD/YEAR";
		$fq->fieldType = 3;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q21
		$fq = new FormQuestion;
		$fq->questionText = "I-9 Renewal Date";
		$fq->questionExample = "MM/DD/YEAR";
		$fq->fieldType = 3;
		$df->questions()->save($fq);

		//Q22
		$fq = new FormQuestion;
		$fq->questionText = "Location";
		$fq->questionExample = "Location";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q23
		$fq = new FormQuestion;
		$fq->questionText = "Position";
		$fq->questionExample = "Position Title";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q24
		$fq = new FormQuestion;
		$fq->questionText = "Department";
		$fq->questionExample = "Department";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q25
		$fq = new FormQuestion;
		$fq->questionText = "Manager";
		$fq->questionExample = "Manager Name";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q26
		$fq = new FormQuestion;
		$fq->questionText = "W-4 Status";
		$fq->questionExample = "Married/Single";
		$fq->fieldType = 2;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q27
		$fq = new FormQuestion;
		$fq->questionText = "Exemptions";
		$fq->questionExample = "Exemption Code";
		$fq->fieldType = 1;
		$fq->required = 1;
		$df->questions()->save($fq);


		//Q28
		$fq = new FormQuestion;
		$fq->questionText = "Gender";
		$fq->questionExample = "Male/Female";
		$fq->fieldType = 2;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q29
		$fq = new FormQuestion;
		$fq->questionText = "EEO Category";
		$fq->questionExample = "EEO Category";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		// //Q30
		// $fq = new FormQuestion;
		// $fq->questionText = "Disability Code 01";
		// $fq->questionExample = "Primary Code";
		// $fq->fieldType = 2;
		// $fq->required = 1;
		// $df->questions()->save($fq);
//
		// //Q31
		// $fq = new FormQuestion;
		// $fq->questionText = "Disability Code 02";
		// $fq->questionExample = "Additional Code";
		// $fq->fieldType = 2;
		// $fq->required = 0;
		// $fq->alt_id = 30;
		// $df->questions()->save($fq);
//
		// //Q32
		// $fq = new FormQuestion;
		// $fq->questionText = "Disability Code 03";
		// $fq->questionExample = "Additional Code";
		// $fq->fieldType = 2;
		// $fq->required = 0;
		// $fq->alt_id = 30;
		// $df->questions()->save($fq);
//
		// //Q33
		// $fq = new FormQuestion;
		// $fq->questionText = "Disability Code 04";
		// $fq->questionExample = "Additional Code";
		// $fq->fieldType = 2;
		// $fq->required = 0;
    	// $fq->alt_id = 30;
		// $df->questions()->save($fq);

		//Q34
		$fq = new FormQuestion;
		$fq->questionText = "Education";
		$fq->questionExample = "Education";
		$fq->fieldType = 1;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q35
		$fq = new FormQuestion;
		$fq->questionText = "Person Number";
		$fq->questionExample = "Person Number";
		$fq->fieldType = 1;
		$fq->required = 1;
		$df->questions()->save($fq);

		//Q36
		$fq = new FormQuestion;
		$fq->questionText = "Ethnicity";
		$fq->questionExample = "Ethnicity";
		$fq->fieldType = 1;
		$fq->required = 1;
		$df->questions()->save($fq);

	}

	//Emergency Contact tab of document set Beta provided by Josh at PARC
	//Written by Cory Snelson
	public function F2()
	{
	//Create the form
		$df = new DataForm;
		$df->formName = 'Emergency Contact Form';
		$df->formDescription = 'Collects Emergency Contact Information Data';
		$df->save();
		//TODO: update below line to associate with correct program or programs
		$programs=Program::where('programName', '=', 'General')->get();
		$df->program()->attach($programs[0]);


		//Create the questions

		//Q1
		$fq = new FormQuestion;
		$fq->questionText = "Primary Contact Name";
		$fq->questionExample = "Full Name";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q2
		$fq = new FormQuestion;
		$fq->questionText = "P.C. Relationship";
		$fq->questionExample = "Sibling/Father/Mother/Etc";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q3
		$fq = new FormQuestion;
		$fq->questionText = "P.C. Address";
		$fq->questionExample = "Address Line 1";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q4
		$fq = new FormQuestion;
		$fq->questionText = "P.C. Address Line 2";
		$fq->questionExample = "Address Line 2";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q5
		$fq = new FormQuestion;
		$fq->questionText = "P.C. City";
		$fq->questionExample = "City";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q6
		$fq = new FormQuestion;
		$fq->questionText = "P.C. State Code";
		$fq->questionExample = "2 Digit Code";
		$fq->fieldType = 2;
		$fq->alt_id = 9;
		$df->questions()->save($fq);

		//Q7
		$fq = new FormQuestion;
		$fq->questionText = "P.C. Zip Code";
		$fq->questionExample = "Zip Code";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q8
		$fq = new FormQuestion;
		$fq->questionText = "P.C. Home Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q9
		$fq = new FormQuestion;
		$fq->questionText = "P.C. Work Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q10
		$fq = new FormQuestion;
		$fq->questionText = "P.C. Cell Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q11
		$fq = new FormQuestion;
		$fq->questionText = "Secondary Contact Name";
		$fq->questionExample = "Full Name";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q12
		$fq = new FormQuestion;
		$fq->questionText = "S.C. Relationship";
		$fq->questionExample = "Sibling/Father/Mother/Etc";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q13
		$fq = new FormQuestion;
		$fq->questionText = "S.C. Address";
		$fq->questionExample = "Address Line 1";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q14
		$fq = new FormQuestion;
		$fq->questionText = "S.C. Address Line 2";
		$fq->questionExample = "Address Line 2";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q15
		$fq = new FormQuestion;
		$fq->questionText = "S.C. City";
		$fq->questionExample = "City";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q16
		$fq = new FormQuestion;
		$fq->questionText = "S.C. State Code";
		$fq->questionExample = "2 Digit Code";
		$fq->fieldType = 2;
		$fq->alt_id = 9;
		$df->questions()->save($fq);

		//Q17
		$fq = new FormQuestion;
		$fq->questionText = "S.C. Zip Code";
		$fq->questionExample = "Zip Code";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q18
		$fq = new FormQuestion;
		$fq->questionText = "S.C. Home Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q19
		$fq = new FormQuestion;
		$fq->questionText = "S.C. Work Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q20
		$fq = new FormQuestion;
		$fq->questionText = "S.C. Cell Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q21
		$fq = new FormQuestion;
		$fq->questionText = "Physician Name";
		$fq->questionExample = "Physician Name";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q22
		$fq = new FormQuestion;
		$fq->questionText = "Physician Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q23
		$fq = new FormQuestion;
		$fq->questionText = "Special Notes";
		$fq->questionExample = "Allergies/Health Conditions/Etc";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
	}

	public function F3() {
		//Create the form
		$df = new DataForm;
		$df->formName = 'Employment';
		$df->formDescription = 'Employment Information';
		$df->save();

		//TODO: update below line to associate with correct program or programs
		$programs=Program::where('programName', '=', 'General')->get();
		$df->program()->attach($programs[0]);

		//Create the questions

		//Q1
		$fq = new FormQuestion;
		$fq->questionText = "Work Location Code";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q2
		$fq = new FormQuestion;
		$fq->questionText = "Job Title";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q3
		$fq = new FormQuestion;
		$fq->questionText = "Full Time / PT";
		$fq->questionExample = "";
		$fq->fieldType = 2;
		$fq->alt_id = 61;
		$df->questions()->save($fq);

		//Q4
		$fq = new FormQuestion;
		$fq->questionText = "Shift";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q5
		$fq = new FormQuestion;
		$fq->questionText = "Hire Date";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q6
		$fq = new FormQuestion;
		$fq->questionText = "Training Wage";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q7
		$fq = new FormQuestion;
		$fq->questionText = "Productivity in Primary Job";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q8
		$fq = new FormQuestion;
		$fq->questionText = "Basis for Productivity";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q9
		$fq = new FormQuestion;
		$fq->questionText = "Separation Date";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q10
		$fq = new FormQuestion;
		$fq->questionText = "Separation Type";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q11
		$fq = new FormQuestion;
		$fq->questionText = "Separation Reason";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q12
		$fq = new FormQuestion;
		$fq->questionText = "Add Separation Comments";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q13
		$fq = new FormQuestion;
		$fq->questionText = "Exit Interview - Like most about job";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);


		//Q14
		$fq = new FormQuestion;
		$fq->questionText = "Exit Interview - Like least about job";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q15
		$fq = new FormQuestion;
		$fq->questionText = "Exit Interview - Add Comments";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q16
		$fq = new FormQuestion;
		$fq->questionText = "Tenure (Months)";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q17
		$fq = new FormQuestion;
		$fq->questionText = "Tenure (Years)";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
	}

	public function F4() {
		//Create the form
		$df = new DataForm;
		$df->formName = 'Additional Information';
		$df->formDescription = 'Additional Information';
		$df->save();

		//TODO: update below line to associate with correct program or programs
		$programs=Program::where('programName', '=', 'General')->get();
		$df->program()->attach($programs[0]);

		//Create the questions

		//Q1
		$fq = new FormQuestion;
		$fq->questionText = "Classified/Non";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q2
		$fq = new FormQuestion;
		$fq->questionText = "Hiring/Referral Source";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q3
		$fq = new FormQuestion;
		$fq->questionText = "Veteran";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q4
		$fq = new FormQuestion;
		$fq->questionText = "Special Disabled Veteran";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q5
		$fq = new FormQuestion;
		$fq->questionText = "Vietnam Veteran";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q6
		$fq = new FormQuestion;
		$fq->questionText = "Veteran Date of Separation";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q7
		$fq = new FormQuestion;
		$fq->questionText = "Other Protected Veteran";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q8
		$fq = new FormQuestion;
		$fq->questionText = "AbilityOne Eligibility";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q9
		$fq = new FormQuestion;
		$fq->questionText = "Person with a Disabiliity";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q10
		$fq = new FormQuestion;
		$fq->questionText = "Encore Disability Code";
		$fq->questionExample = "";
		$fq->fieldType = 2;
		$fq->alt_id = 30;
		$df->questions()->save($fq);

		//Q11
		$fq = new FormQuestion;
		$fq->questionText = "Primary Disability";
		$fq->questionExample = "";
		$fq->fieldType = 2;
		$fq->alt_id = 30;
		$df->questions()->save($fq);

		//Q12
		$fq = new FormQuestion;
		$fq->questionText = "Additional Disability 1";
		$fq->questionExample = "";
		$fq->fieldType = 2;
		$fq->alt_id = 30;
		$df->questions()->save($fq);

		//Q13
		$fq = new FormQuestion;
		$fq->questionText = "Additional Disability 2";
		$fq->questionExample = "";
		$fq->fieldType = 2;
		$fq->alt_id = 30;
		$df->questions()->save($fq);

		//Q14
		$fq = new FormQuestion;
		$fq->questionText = "Additional Disability 3";
		$fq->questionExample = "";
		$fq->fieldType = 2;
		$fq->alt_id = 30;
		$df->questions()->save($fq);

		//Q15
		$fq = new FormQuestion;
		$fq->questionText = "Additional Disability 4";
		$fq->questionExample = "";
		$fq->fieldType = 2;
		$fq->alt_id = 30;
		$df->questions()->save($fq);

		//Q16
		$fq = new FormQuestion;
		$fq->questionText = "Employee of NPA";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q17
		$fq = new FormQuestion;
		$fq->questionText = "AbilityOn E Direct Labor";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q18
		$fq = new FormQuestion;
		$fq->questionText = "AbilityOn E Indirect Labor";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q19
		$fq = new FormQuestion;
		$fq->questionText = "State Use Projects";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q20
		$fq = new FormQuestion;
		$fq->questionText = "Other Project";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q21
		$fq = new FormQuestion;
		$fq->questionText = "FLSA 14c Certificate";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);

		//Q22
		$fq = new FormQuestion;
		$fq->questionText = "Eligible for Fringe Benefits";
		$fq->questionExample = "";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
}
}