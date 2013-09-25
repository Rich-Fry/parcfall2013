<?php
class SeedForms_Task {
	public function run($args)
	{
		//SeedForms_Task::form1();
		//SeedForms_Task::form2();
		//SeedForms_Task::form3();
		
		SeedForms_Task::F1();
		SeedForms_Task::F2();
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
		$df->questions()->save($fq);
		
		//Q4
		$fq = new FormQuestion;
		$fq->questionText = "Birthdate";
		$fq->questionExample = "MM/DD/YEAR";
		$fq->fieldType = 3;
		$df->questions()->save($fq);
		
		//Q5
		$fq = new FormQuestion;
		$fq->questionText = "Social Security Number";
		$fq->questionExample = "XXX-XX-XXXX";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q6
		$fq = new FormQuestion;
		$fq->questionText = "Address";
		$fq->questionExample = "Address Line 1";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q7
		$fq = new FormQuestion;
		$fq->questionText = "Address Line 2";
		$fq->questionExample = "Address Line 2";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q8
		$fq = new FormQuestion;
		$fq->questionText = "City";
		$fq->questionExample = "City";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q9
		$fq = new FormQuestion;
		$fq->questionText = "State Code";
		$fq->questionExample = "2 Digit Code";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q10
		$fq = new FormQuestion;
		$fq->questionText = "Zip Code";
		$fq->questionExample = "Zip Code";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q11
		$fq = new FormQuestion;
		$fq->questionText = "Country";
		$fq->questionExample = "Country";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q12
		$fq = new FormQuestion;
		$fq->questionText = "Home Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q13
		$fq = new FormQuestion;
		$fq->questionText = "Work Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q14
		$fq = new FormQuestion;
		$fq->questionText = "Cell Phone";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q15
		$fq = new FormQuestion;
		$fq->questionText = "Fax";
		$fq->questionExample = "555-555-5555";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q16
		$fq = new FormQuestion;
		$fq->questionText = "E-mail Address";
		$fq->questionExample = "JaneDoe@sample.com";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q17
		$fq = new FormQuestion;
		$fq->questionText = "Status";
		$fq->questionExample = "Active/Inactive";
		$fq->fieldType = 2;
		$df->questions()->save($fq);
		
		//Q18
		$fq = new FormQuestion;
		$fq->questionText = "Employee Number";
		$fq->questionExample = "000000";
		$fq->fieldType = 4;
		$df->questions()->save($fq);
		
		//Q19
		$fq = new FormQuestion;
		$fq->questionText = "Hire Date";
		$fq->questionExample = "MM/DD/YEAR";
		$fq->fieldType = 3;
		$df->questions()->save($fq);
		
		//Q20
		$fq = new FormQuestion;
		$fq->questionText = "I-9 Renewal Date";
		$fq->questionExample = "MM/DD/YEAR";
		$fq->fieldType = 3;
		$df->questions()->save($fq);
		
		//Q21
		$fq = new FormQuestion;
		$fq->questionText = "Location";
		$fq->questionExample = "Location";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q22
		$fq = new FormQuestion;
		$fq->questionText = "Position";
		$fq->questionExample = "Position Title";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q23
		$fq = new FormQuestion;
		$fq->questionText = "Department";
		$fq->questionExample = "Department";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q24
		$fq = new FormQuestion;
		$fq->questionText = "Manager";
		$fq->questionExample = "Manager Name";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q25
		$fq = new FormQuestion;
		$fq->questionText = "W-4 Status";
		$fq->questionExample = "Married/Single";
		$fq->fieldType = 2;
		$df->questions()->save($fq);
		
		//Q26
		$fq = new FormQuestion;
		$fq->questionText = "Exemptions";
		$fq->questionExample = "Exemption Code";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		
		//Q27
		$fq = new FormQuestion;
		$fq->questionText = "Gender";
		$fq->questionExample = "Male/Female";
		$fq->fieldType = 2;
		$df->questions()->save($fq);
		
		//Q28
		$fq = new FormQuestion;
		$fq->questionText = "EEO Category";
		$fq->questionExample = "EEO Category";
		$fq->fieldType = 1;
		$df->questions()->save($fq);
		
		//Q29
		$fq = new FormQuestion;
		$fq->questionText = "Disabilty Code 01";
		$fq->questionExample = "Primary Code";
		$fq->fieldType = 2;
		$df->questions()->save($fq);
		
		//Q30
		$fq = new FormQuestion;
		$fq->questionText = "Disability Code 02";
		$fq->questionExample = "Additional Code";
		$fq->fieldType = 2;
		$df->questions()->save($fq);
		
		//Q31
		$fq = new FormQuestion;
		$fq->questionText = "Disability Code 03";
		$fq->questionExample = "Additional Code";
		$fq->fieldType = 2;
		$df->questions()->save($fq);
		
		//Q32
		$fq = new FormQuestion;
		$fq->questionText = "Disability Code 04";
		$fq->questionExample = "Additional Code";
		$fq->fieldType = 2;
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
		$fq->fieldType = 1;
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
		$fq->fieldType = 1;
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
	
	/*
	public function form1()
	{
		$df = new DataForm;
		$df->formName = 'Medical Information 2';
		$df->formDescription = 'Collects medical Data';
		$df->save();
		$df->program()->attach(Program::where('programName', '=', 'Community Employed')->get()[0]);
		
		
		$fq = new FormQuestion;
		$fq->questionText = "Question text goes here!!";
		$fq->questionExample = "An example answer to that question";
		$df->questions()->save($fq);
	}
	*/
	
	/*
	//Added by Cory Snelson
	//Demographic Data Form
	public function form2()
	{
		//Create the form
		$df = new DataForm;
		$df->formName = 'Demographic Data Form';
		$df->formDescription = 'Collects Demographic Data';
		//TODO: update below line to associate with correct program or programs
		$df->save();
		$df->program()->attach(Program::where('programName', '=', 'Community Employed')->get()[0]);
		
		
		//Create the questions
		
		//Q1
		$fq = new FormQuestion;
		$fq->questionText = "Date Hired";
		$fq->questionExample = "MM/DD/YEAR";
		$df->questions()->save($fq);
		
		//Q2
		$fq = new FormQuestion;
		$fq->questionText = "Full Name";
		$fq->questionExample = "Enter Full Name";
		$df->questions()->save($fq);
		
		//Q3
		$fq = new FormQuestion;
		$fq->questionText = "Program Location";
		$fq->questionExample = "Enter Program Location";
		$df->questions()->save($fq);
		
		//Q4
		$fq = new FormQuestion;
		$fq->questionText = "Job Title";
		$fq->questionExample = "Enter Job Title";
		$df->questions()->save($fq);
		
		//Q5
		$fq = new FormQuestion;
		$fq->questionText = "Date of Birth";
		$fq->questionExample = "MM/DD/YEAR";
		$df->questions()->save($fq);
		
		//Q6
		$fq = new FormQuestion;
		$fq->questionText = "Gender";
		$fq->questionExample = "Male/Female";
		$df->questions()->save($fq);
		
		//Q7
		$fq = new FormQuestion;
		$fq->questionText = "Marital Status";
		$fq->questionExample = "Single/Married/Divorced/Widowed";
		$df->questions()->save($fq);
		
		//Q8
		$fq = new FormQuestion;
		$fq->questionText = "Veteran Status";
		$fq->questionExample = "Newly Separated/Special Disabled/Vietnam Vet/Other Protected Vet";
		$df->questions()->save($fq);
		
		//Q9
		$fq = new FormQuestion;
		$fq->questionText = "Race";
		$fq->questionExample = "American Indian, Alaskan Native/Asian/Black or African American/Hispanic or Latino/
								Native Hawaiian, Other Pacific Islander/White/Two or More Races";
		$df->questions()->save($fq);
		
		//Q10
		$fq = new FormQuestion;
		$fq->questionText = "Referral Source";
		$fq->questionExample = "Ad or Publication/Gov't Agency/Job Fair/PARC Employee/Radio or Television/School or College/
								Website or Internet/OTHER";
		$df->questions()->save($fq);
	}
	*/
	
	/*
	//Added by Cory Snelson
	//SCA Employee Information Sheet
	public function form3()
	{
		//Create the form
		$df = new DataForm;
		$df->formName = 'SCA Employee Information Sheet';
		$df->formDescription = 'Collects SCA Employee Information';
		//TODO: update below line to associate with correct program or programs
		$df->save();
		$df->program()->attach(Program::where('programName', '=', 'Community Employed')->get()[0]);
		
		
		//Create the questions
		
		//Q1
		$fq = new FormQuestion;
		$fq->questionText = "Name";
		$fq->questionExample = "First Last MI";
		$df->questions()->save($fq);
		
		//Q2
		$fq = new FormQuestion;
		$fq->questionText = "Address";
		$fq->questionExample = "Enter Full Street Address";
		$df->questions()->save($fq);
		
		//Q3
		$fq = new FormQuestion;
		$fq->questionText = "City";
		$fq->questionExample = "Enter City Name";
		$df->questions()->save($fq);
		
		//Q4
		$fq = new FormQuestion;
		$fq->questionText = "State";
		$fq->questionExample = "Enter State Name";
		$df->questions()->save($fq);
		
		//Q5
		$fq = new FormQuestion;
		$fq->questionText = "Zip Code";
		$fq->questionExample = "Enter Zip Code";
		$df->questions()->save($fq);
		
		//Q6
		$fq = new FormQuestion;
		$fq->questionText = "Home Phone";
		$fq->questionExample = "(801)555-5555";
		$df->questions()->save($fq);
		
		//Q7
		$fq = new FormQuestion;
		$fq->questionText = "Alt. Phone";
		$fq->questionExample = "(801)555-5555";
		$df->questions()->save($fq);
		
		//Q8
		$fq = new FormQuestion;
		$fq->questionText = "Date of Birth";
		$fq->questionExample = "MM/DD/YEAR";
		$df->questions()->save($fq);
		
		//Q9
		$fq = new FormQuestion;
		$fq->questionText = "Social Security Number";
		$fq->questionExample = "###-##-####";
		$df->questions()->save($fq);
		
		//Q10
		$fq = new FormQuestion;
		$fq->questionText = "Marital Status";
		$fq->questionExample = "MM/DD/YEAR";
		$df->questions()->save($fq);
		
		//Q11
		$fq = new FormQuestion;
		$fq->questionText = "Sex";
		$fq->questionExample = "Male/Female";
		$df->questions()->save($fq);
		
		//Q12
		$fq = new FormQuestion;
		$fq->questionText = "Emergency Contact";
		$fq->questionExample = "Enter Emergency Contact Name";
		$df->questions()->save($fq);
		
		//Q13
		$fq = new FormQuestion;
		$fq->questionText = "Emergency Contact Relationship";
		$fq->questionExample = "Enter Relationship With Emergency Contact";
		$df->questions()->save($fq);
		
		//Q14
		$fq = new FormQuestion;
		$fq->questionText = "Emergency Contact Home Phone";
		$fq->questionExample = "(801)555-5555";
		$df->questions()->save($fq);
		
		//Q15
		$fq = new FormQuestion;
		$fq->questionText = "Emergency Contact Alt. Phone";
		$fq->questionExample = "(801)555-5555";
		$df->questions()->save($fq);
		
		//Q16
		$fq = new FormQuestion;
		$fq->questionText = "Race";
		$fq->questionExample = "American Indian, Alaskan Native/Asian/Black or African American/Hispanic or Latino/
								Native Hawaiian, Other Pacific Islander/White/Two or More Races";
		$df->questions()->save($fq);
		
		//Need to find out how to handle office use only section
	}
	*/
}