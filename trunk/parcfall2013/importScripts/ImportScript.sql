-- --------------------------------------
-- Create temp table 801-888-4652
-- --------------------------------------
DROP TABLE IF EXISTS tmp_data_import;
CREATE TEMPORARY TABLE tmp_data_import (
	record_number INTEGER AUTO_INCREMENT NOT NULL,
	name_last_first VARCHAR(100) NULL,
	maiden_name VARCHAR(100) NULL,
	active VARCHAR(100) NULL,
	classified VARCHAR(100) NULL,
	referal_source VARCHAR(100) NULL,
	work_location_code VARCHAR(100) NULL,
	job_title VARCHAR(100) NULL,
	full_time VARCHAR(100) NULL,
	education VARCHAR(100) NULL,
	shift VARCHAR(100) NULL,
	person_number VARCHAR(100) NULL,
	gender VARCHAR(100) NULL,
	dob DATE NULL,
	year_of_birth VARCHAR(100) NULL,
	age VARCHAR(100) NULL,
	full_address VARCHAR(500) NULL,
	full_zip VARCHAR(100) NULL,
	race_and_ethnicity VARCHAR(100) NULL,
	marital_status VARCHAR(100) NULL,
	veteran VARCHAR(100) NULL,
	special_disabled_veteran VARCHAR(100) NULL,
	vietnam_veteran VARCHAR(100) NULL,
	veteran_date_of_seperation VARCHAR(100) NULL,
	other_veteran VARCHAR(100) NULL,
	hire_date VARCHAR(100) NULL,
	ability_one_eligibility VARCHAR(100) NULL,
	disability VARCHAR(100) NULL,
	encore_dis_code VARCHAR(100) NULL,
	primary_disiability VARCHAR(100) NULL,
	disiability1 VARCHAR(100) NULL,
	disiability2 VARCHAR(100) NULL,
	disiability3 VARCHAR(100) NULL,
	npa  VARCHAR(100) NULL,
	ability_one_direct VARCHAR(100) NULL,
	ability_one_indirect VARCHAR(100) NULL,
	state_use_projects VARCHAR(100) NULL,
	other_project VARCHAR(100) NULL,
	training_wage VARCHAR(100) NULL,
	flsa_14c VARCHAR(100) NULL,
	productivity VARCHAR(100) NULL,
	basis_for_productivity VARCHAR(100) NULL,
	fringe_eligible VARCHAR(100) NULL,
	separation_date VARCHAR(100) NULL,
	separation_type VARCHAR(100) NULL,
	separation_reason VARCHAR(5000) NULL,
	add_comments VARCHAR(100) NULL,
	exit_most VARCHAR(100) NULL,
	exit_least  VARCHAR(100) NULL,
	exit_add  VARCHAR(100) NULL,
	tenure_months  VARCHAR(100) NULL,
	tenure_years  VARCHAR(100) NULL,
	ssn VARCHAR(100) NULL,
	KEY record_number (record_number)
);

-- --------------------------------------
-- Import data into the temp table
-- --------------------------------------
LOAD DATA INFILE 'C:\\School\\3750\\data.csv'
	INTO TABLE tmp_data_import FIELDS TERMINATED BY ',' ENCLOSED BY '"'
		LINES TERMINATED BY '\r\n' IGNORE 0 LINES
	(name_last_first,
	maiden_name,
	active,
	classified,
	referal_source,
	work_location_code,
	job_title,
	full_time,
	education,
	shift,
	person_number,
	gender,
	dob,
	year_of_birth,
	age,
	full_address,
	full_zip,
	race_and_ethnicity,
	marital_status,
	veteran,
	special_disabled_veteran,
	vietnam_veteran,
	veteran_date_of_seperation,
	other_veteran,
	hire_date,
	ability_one_eligibility,
	disability,
	encore_dis_code,
	primary_disiability,
	disiability1,
	disiability2,
	disiability3,
	npa,
	ability_one_direct,
	ability_one_indirect,
	state_use_projects,
	other_project,
	training_wage,
	flsa_14c,
	productivity,
	basis_for_productivity,
	fringe_eligible,
	separation_date,
	separation_type,
	separation_reason,
	add_comments,
	exit_most,
	exit_least,
	exit_add,
	tenure_months,
	tenure_years,
	ssn);
	
	-- check import
	-- select * from tmp_data_import;
	
-- -------------------------------------------------------
-- Name Splitting Function
-- -------------------------------------------------------
DROP FUNCTION IF EXISTS SPLIT_STR;
CREATE FUNCTION SPLIT_STR(
  x VARCHAR(255),
  delim VARCHAR(12),
  pos INT
)
RETURNS VARCHAR(255)
RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
       LENGTH(SUBSTRING_INDEX(x, delim, pos -1)) + 1),
       delim, '');

-- -------------------------------------------------------
-- Convert Procedure
-- -------------------------------------------------------	   
	   
DROP PROCEDURE IF EXISTS convert_records;
DELIMITER //
CREATE PROCEDURE convert_records()
BEGIN
	-- values pulled from spreadsheet
	DECLARE in_name_last VARCHAR(100);
	DECLARE in_name_first VARCHAR(100);
	DECLARE in_maiden_name VARCHAR(100);
	DECLARE in_active VARCHAR(100);
	DECLARE in_address VARCHAR(100);
	DECLARE in_city VARCHAR(100);
	DECLARE in_state VARCHAR(100);
	DECLARE in_zip VARCHAR(100);
	DECLARE in_city2 VARCHAR(100);
	DECLARE in_state2 VARCHAR(100);
	DECLARE in_zip2 VARCHAR(100);
	DECLARE in_classified VARCHAR(100);
	DECLARE in_referal_source VARCHAR(100);
	DECLARE in_work_location_code VARCHAR(100);
	DECLARE in_job_title VARCHAR(100);
	DECLARE in_full_time VARCHAR(100);
	DECLARE in_education VARCHAR(100);
	DECLARE in_shift VARCHAR(100);
	DECLARE in_person_number VARCHAR(100);
	DECLARE in_gender VARCHAR(100);
	DECLARE in_full_zip VARCHAR(100);
	DECLARE in_race_and_ethnicity VARCHAR(100);
	DECLARE in_marital_status VARCHAR(100);
	DECLARE in_veteran VARCHAR(100);
	DECLARE in_special_disabled_veteran VARCHAR(100);
	DECLARE in_vietnam_veteran VARCHAR(100);
	DECLARE in_veteran_date_of_seperation VARCHAR(100);
	DECLARE in_other_veteran VARCHAR(100);
	DECLARE in_hire_date VARCHAR(100);
	DECLARE in_ability_one_eligibility VARCHAR(100);
	DECLARE in_disability VARCHAR(100);
	DECLARE in_encore_dis_code VARCHAR(100);
	DECLARE in_primary_disiability VARCHAR(100);
	DECLARE in_disiability1 VARCHAR(100);
	DECLARE in_disiability2 VARCHAR(100);
	DECLARE in_disiability3 VARCHAR(100);
	DECLARE in_npa VARCHAR(100);
	DECLARE in_ability_one_direct VARCHAR(100);
	DECLARE in_ability_one_indirect VARCHAR(100);
	DECLARE in_state_use_projects VARCHAR(100);
	DECLARE in_other_project VARCHAR(100);
	DECLARE in_training_wage VARCHAR(100);
	DECLARE in_flsa_14c VARCHAR(100);
	DECLARE in_productivity VARCHAR(100);
	DECLARE in_basis_for_productivity VARCHAR(100);
	DECLARE in_fringe_eligible VARCHAR(100);
	DECLARE in_separation_date VARCHAR(100);
	DECLARE in_separation_type VARCHAR(100);
	DECLARE in_separation_reason VARCHAR(5000);
	DECLARE in_add_comments VARCHAR(100);
	DECLARE in_exit_most VARCHAR(100);
	DECLARE in_exit_least VARCHAR(100);
	DECLARE in_exit_add VARCHAR(100);
	DECLARE in_tenure_months VARCHAR(100);
	DECLARE in_tenure_years VARCHAR(100);
	DECLARE in_ssn VARCHAR(100);
	
	-- values created during process

	-- temporary values for client records
	DECLARE employee_id INT; -- client id
	DECLARE program1_id INT; -- form program id 1
	DECLARE program2_id INT; -- form program id 1
	DECLARE program3_id INT; -- form program id 1
	
	-- General Form id's
	DECLARE general_form_id INT;
	DECLARE first_name_id INT;
	DECLARE last_name_id INT;
	DECLARE maiden_name_id INT;
	DECLARE status_id INT;
	DECLARE address_id INT;
	DECLARE city_id INT;
	DECLARE state_id INT;
	DECLARE zip_id INT;
	DECLARE education_id INT;
	DECLARE person_number_id INT;
	DECLARE gender_id INT;
	DECLARE ethnicity_id INT;
	DECLARE w4_status_id INT;
	DECLARE ssn_id INT;
	
	
	-- Employment Form id's
	DECLARE employ_form_id INT;
	DECLARE work_location_code_id INT;
	DECLARE job_title_id INT;
	DECLARE full_time_id INT;
	DECLARE shift_id INT;
	DECLARE hire_date_id INT;
	DECLARE training_wage_id INT;
	DECLARE productivity_id INT;
	DECLARE productivity_basis_id INT;
	DECLARE separation_date_id INT;
	DECLARE separation_type_id INT;
	DECLARE separation_reason_id INT;
	DECLARE separation_add_comments INT;
	DECLARE exit_like_id INT;
	DECLARE exit_not_like_id INT;
	DECLARE exit_add_comments INT;
	DECLARE tenure_months_id INT;
	DECLARE tenure_years_id INT;
	
	
	-- Additional Information Form id's
	DECLARE add_info_form_id INT;
	DECLARE classified_id INT;
	DECLARE hire_source_id INT;
	DECLARE vet_id INT;
	DECLARE special_vet_id INT;
	DECLARE vietnam_vet_id INT;
	DECLARE vet_date_id INT;
	DECLARE other_vet_id INT;
	DECLARE ability_one_id INT;
	DECLARE disability_id INT;
	DECLARE encore_code_id INT;
	DECLARE primary_disability_id INT;
	DECLARE add_dis_1_id INT;
	DECLARE add_dis_2_id INT;
	DECLARE add_dis_3_id INT;
	DECLARE npa_id INT;
	DECLARE ability_one_direct_id INT;
	DECLARE ability_on_indirect_id INT;
	DECLARE state_project_id INT;
	DECLARE other_project_id INT;
	DECLARE flsa_14_id INT;
	DECLARE fringe_id INT;
		
	
	DECLARE insert_count INT;
	
	DECLARE done INT DEFAULT 0;
	DECLARE recordInfo CURSOR FOR
		SELECT
		SPLIT_STR(name_last_first, ', ', 1) as last,
		SPLIT_STR(name_last_first, ', ', 2) as first,
		maiden_name,
		active,
		SPLIT_STR(full_address, ', ', 1) as address,
		SPLIT_STR(full_address, ', ', 2) as city,
		SPLIT_STR(full_address, ', ', 3) as state,
		SPLIT_STR(full_address, ', ', 4) as zip,
		SPLIT_STR(SPLIT_STR(full_address, '\n', 2), ', ', 1) as city2,
		SPLIT_STR(full_address, ', ', 2) as state2,
		SPLIT_STR(full_address, ', ', 3) as zip2,
		classified,
		referal_source,
		work_location_code,
		job_title,
		full_time,
		education,
		shift,
		person_number,
		gender,
		STR_TO_DATE(CONCAT(SPLIT_STR(dob, '/', 1), ',', SPLIT_STR(dob, '/', 2), ',', year_of_birth), '%c,%d,%Y') correct_dob, 
		full_zip,
		race_and_ethnicity,
		marital_status,
		veteran,
		special_disabled_veteran,
		vietnam_veteran,
		veteran_date_of_seperation,
		other_veteran,
		hire_date,
		ability_one_eligibility,
		disability,
		encore_dis_code,
		primary_disiability,
		disiability1,
		disiability2,
		disiability3,
		npa,
		ability_one_direct,
		ability_one_indirect,
		state_use_projects,
		other_project,
		training_wage,
		flsa_14c,
		productivity,
		basis_for_productivity,
		fringe_eligible,
		separation_date,
		separation_type,
		separation_reason,
		add_comments,
		exit_most,
		exit_least,
		exit_add,
		tenure_months,
		tenure_years,
		ssn
		FROM tmp_data_import;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	
	SET program1_id = (SELECT id FROM program WHERE programName = 'General' ORDER BY id desc LIMIT 1);
	
	-- General Form id's
	SET general_form_id = (SELECT id FROM form WHERE formName = 'General Information Form' ORDER BY created_at desc LIMIT 1);
	SET first_name_id = (SELECT id FROM formquestion WHERE questionText = 'First Name' AND dataform_id = general_form_id limit 1);
	SET last_name_id = (SELECT id FROM formquestion WHERE questionText = 'Last Name' AND dataform_id = general_form_id limit 1);
	SET maiden_name_id = (SELECT id FROM formquestion WHERE questionText = 'Maiden Name' AND dataform_id = general_form_id limit 1);
	SET status_id = (SELECT id FROM formquestion WHERE questionText = 'Status' AND dataform_id = general_form_id limit 1);
	SET address_id = (SELECT id FROM formquestion WHERE questionText = 'Address' AND dataform_id = general_form_id limit 1);
	SET city_id = (SELECT id FROM formquestion WHERE questionText = 'City' AND dataform_id = general_form_id limit 1);
	SET state_id = (SELECT id FROM formquestion WHERE questionText = 'State Code' AND dataform_id = general_form_id limit 1);
	SET zip_id = (SELECT id FROM formquestion WHERE questionText = 'Zip Code' AND dataform_id = general_form_id limit 1);
	SET education_id = (SELECT id FROM formquestion WHERE questionText = 'Education' AND dataform_id = general_form_id limit 1);
	SET person_number_id = (SELECT id FROM formquestion WHERE questionText = 'Person Number' AND dataform_id = general_form_id limit 1);
	SET gender_id = (SELECT id FROM formquestion WHERE questionText = 'Gender' AND dataform_id = general_form_id limit 1);
	SET ethnicity_id = (SELECT id FROM formquestion WHERE questionText = 'Ethnicity' AND dataform_id = general_form_id limit 1);
	SET w4_status_id = (SELECT id FROM formquestion WHERE questionText = 'W-4 Status' AND dataform_id = general_form_id limit 1);
	SET ssn_id = (SELECT id FROM formquestion WHERE questionText = 'Social Security Number' AND dataform_id = general_form_id limit 1);
	
	-- SET  = SELECT id FROM formquestion WHERE questionText = '' AND dataform_id = general_form_id limit 1;
	-- Employment Form id's
	SET employ_form_id = (SELECT id FROM form WHERE formName = 'Employment' ORDER BY created_at desc LIMIT 1);
	SET work_location_code_id = (SELECT id FROM formquestion WHERE questionText = 'Work Location Code' AND dataform_id = employ_form_id limit 1);
	SET job_title_id = (SELECT id FROM formquestion WHERE questionText = 'Job Title' AND dataform_id = employ_form_id limit 1);
	SET full_time_id = (SELECT id FROM formquestion WHERE questionText = 'Full Time / PT' AND dataform_id = employ_form_id limit 1);
	SET shift_id = (SELECT id FROM formquestion WHERE questionText = 'Shift' AND dataform_id = employ_form_id limit 1);
	SET hire_date_id = (SELECT id FROM formquestion WHERE questionText = 'Hire Date' AND dataform_id = employ_form_id limit 1);
	SET training_wage_id = (SELECT id FROM formquestion WHERE questionText = 'Training Wage' AND dataform_id = employ_form_id limit 1);
	SET productivity_id = (SELECT id FROM formquestion WHERE questionText = 'Productivity in Primary Job' AND dataform_id = employ_form_id limit 1);
	SET productivity_basis_id = (SELECT id FROM formquestion WHERE questionText = 'Basis for Productivity' AND dataform_id = employ_form_id limit 1);
	SET separation_date_id = (SELECT id FROM formquestion WHERE questionText = 'Separation Date' AND dataform_id = employ_form_id limit 1);
	SET separation_type_id = (SELECT id FROM formquestion WHERE questionText = 'Separation Type' AND dataform_id = employ_form_id limit 1);
	SET separation_reason_id = (SELECT id FROM formquestion WHERE questionText = 'Separation Reason' AND dataform_id = employ_form_id limit 1);
	SET separation_add_comments = (SELECT id FROM formquestion WHERE questionText = 'Add Separation Comments' AND dataform_id = employ_form_id limit 1);
	SET exit_like_id = (SELECT id FROM formquestion WHERE questionText = 'Exit Interview - Like most about job' AND dataform_id = employ_form_id limit 1);
	SET exit_not_like_id = (SELECT id FROM formquestion WHERE questionText = 'Exit Interview - Like least about job' AND dataform_id = employ_form_id limit 1);
	SET exit_add_comments = (SELECT id FROM formquestion WHERE questionText = 'Exit Interview - Add Comments' AND dataform_id = employ_form_id limit 1);
	SET tenure_months_id = (SELECT id FROM formquestion WHERE questionText = 'Tenure (Months)' AND dataform_id = employ_form_id limit 1);
	SET tenure_years_id = (SELECT id FROM formquestion WHERE questionText = 'Tenure (Years)' AND dataform_id = employ_form_id limit 1);
	
	
	-- Additional Information Form id's
	SET add_info_form_id = (SELECT id FROM form WHERE formName = 'Additional Information' ORDER BY created_at desc LIMIT 1);
	SET classified_id = (SELECT id FROM formquestion WHERE questionText = 'Classified/Non' AND dataform_id = add_info_form_id limit 1);
	SET hire_source_id = (SELECT id FROM formquestion WHERE questionText = 'Hiring/Referral Source' AND dataform_id = add_info_form_id limit 1);
	SET vet_id = (SELECT id FROM formquestion WHERE questionText = 'Veteran' AND dataform_id = add_info_form_id limit 1);
	SET special_vet_id = (SELECT id FROM formquestion WHERE questionText = 'Special Disabled Veteran' AND dataform_id = add_info_form_id limit 1);
	SET vietnam_vet_id = (SELECT id FROM formquestion WHERE questionText = 'Vietnam Veteran' AND dataform_id = add_info_form_id limit 1);
	SET vet_date_id = (SELECT id FROM formquestion WHERE questionText = 'Veteran Date of Separation' AND dataform_id = add_info_form_id limit 1);
	SET other_vet_id = (SELECT id FROM formquestion WHERE questionText = 'Other Protected Veteran' AND dataform_id = add_info_form_id limit 1);
	SET ability_one_id = (SELECT id FROM formquestion WHERE questionText = 'AbilityOne Eligibility' AND dataform_id = add_info_form_id limit 1);
	SET disability_id = (SELECT id FROM formquestion WHERE questionText = 'Person with a Disabiliity' AND dataform_id = add_info_form_id limit 1);
	SET encore_code_id = (SELECT id FROM formquestion WHERE questionText = 'Encore Disability Code' AND dataform_id = add_info_form_id limit 1);
	SET primary_disability_id = (SELECT id FROM formquestion WHERE questionText = 'Primary Disability' AND dataform_id = add_info_form_id limit 1);
	SET add_dis_1_id = (SELECT id FROM formquestion WHERE questionText = 'Additional Disability 1' AND dataform_id = add_info_form_id limit 1);
	SET add_dis_2_id = (SELECT id FROM formquestion WHERE questionText = 'Additional Disability 2' AND dataform_id = add_info_form_id limit 1);
	SET add_dis_3_id = (SELECT id FROM formquestion WHERE questionText = 'Additional Disability 3' AND dataform_id = add_info_form_id limit 1);
	SET npa_id = (SELECT id FROM formquestion WHERE questionText = 'Employee of NPA' AND dataform_id = add_info_form_id limit 1);
	SET ability_one_direct_id = (SELECT id FROM formquestion WHERE questionText = 'AbilityOn E Direct Labor' AND dataform_id = add_info_form_id limit 1);
	SET ability_on_indirect_id = (SELECT id FROM formquestion WHERE questionText = 'AbilityOn E Indirect Labor' AND dataform_id = add_info_form_id limit 1);
	SET state_project_id = (SELECT id FROM formquestion WHERE questionText = 'State Use Projects' AND dataform_id = add_info_form_id limit 1);
	SET other_project_id = (SELECT id FROM formquestion WHERE questionText = 'Other Project' AND dataform_id = add_info_form_id limit 1);
	SET flsa_14_id = (SELECT id FROM formquestion WHERE questionText = 'FLSA 14c Certificate' AND dataform_id = add_info_form_id limit 1);
	SET fringe_id = (SELECT id FROM formquestion WHERE questionText = 'Eligible for Fringe Benefits' AND dataform_id = add_info_form_id limit 1);
	
	
	SET insert_count = 0;
	
	OPEN recordInfo;
	REPEAT
		FETCH recordInfo INTO
		in_name_last,
		in_name_first,
		in_maiden_name,
		in_active,
		in_address,
		in_city,
		in_state,
		in_zip,
		in_city2,
		in_state2,
		in_zip2,
		in_classified,
		in_referal_source,
		in_work_location_code,
		in_job_title,
		in_full_time,
		in_education,
		in_shift,
		in_person_number,
		in_gender,
		in_dob,
		in_full_zip,
		in_race_and_ethnicity,
		in_marital_status,
		in_veteran,
		in_special_disabled_veteran,
		in_vietnam_veteran,
		in_veteran_date_of_seperation,
		in_other_veteran,
		in_hire_date,
		in_ability_one_eligibility,
		in_disability,
		in_encore_dis_code,
		in_primary_disiability,
		in_disiability1,
		in_disiability2,
		in_disiability3,
		in_npa,
		in_ability_one_direct,
		in_ability_one_indirect,
		in_state_use_projects,
		in_other_project,
		in_training_wage,
		in_flsa_14c,
		in_productivity,
		in_basis_for_productivity,
		in_fringe_eligible,
		in_separation_date,
		in_separation_type,
		in_separation_reason,
		in_add_comments,
		in_exit_most,
		in_exit_least,
		in_exit_add,
		in_tenure_months,
		in_tenure_years,
		in_ssn
		;
	IF NOT done THEN
	
		-- create employee record
		INSERT INTO employee (firstName, lastName, client, created_at, updated_at)
			VALUES (in_name_first, in_name_last, 1, NOW(), NOW());
		SET insert_count = insert_count + 1;
		SET employee_id = LAST_INSERT_ID();
		
		-- link employee to programs
		INSERT INTO employeeprogram (employee_id, program_id, created_at, updated_at)
			VALUES (employee_id, program1_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		
		-- General Information Form Records
		
		-- First Name
		IF in_name_first IS NOT NULL AND in_name_first <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (first_name_id, in_name_first, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		-- Last Name
		IF in_name_last IS NOT NULL AND in_name_last <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (last_name_id, in_name_last, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		-- Maiden Name
		IF in_maiden_name IS NOT NULL AND in_maiden_name <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (maiden_name_id, in_name_last, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		-- Active/Inactive
		IF in_active IS NOT NULL AND in_active <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (status_id, in_active, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		-- Address
		IF in_address IS NOT NULL AND in_address <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (address_id, in_address, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		-- if zip is null or '' use approach 2 for address parsing
		IF in_zip IS NULL OR in_zip THEN
			-- city2
			IF in_city2 IS NOT NULL AND in_city2 <> '' THEN
				INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
					VALUES (city_id, in_city2, general_form_id, employee_id, NOW(), NOW());
				SET insert_count = insert_count + 1;
			END IF;
			-- state2
			IF in_state2 IS NOT NULL AND in_state2 <> '' THEN
				INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
					VALUES (state_id, in_state2, general_form_id, employee_id, NOW(), NOW());
				SET insert_count = insert_count + 1;
			END IF;
			-- zip2
			IF in_full_zip IS NOT NULL AND in_full_zip <> '' THEN
				INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
					VALUES (zip_id, in_full_zip, general_form_id, employee_id, NOW(), NOW());
				SET insert_count = insert_count + 1;
			ELSEIF in_zip2 IS NOT NULL AND in_zip2 <> '' THEN
				INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
					VALUES (zip_id, in_zip2, general_form_id, employee_id, NOW(), NOW());
				SET insert_count = insert_count + 1;
			END IF;
		ELSE
			-- city
			IF in_city IS NOT NULL AND in_city <> '' THEN
				INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
					VALUES (city_id, in_city, general_form_id, employee_id, NOW(), NOW());
				SET insert_count = insert_count + 1;
			END IF;
			-- state
			IF in_state IS NOT NULL AND in_state <> '' THEN
				INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
					VALUES (state_id, in_state, general_form_id, employee_id, NOW(), NOW());
				SET insert_count = insert_count + 1;
			END IF;
			-- zip
			IF in_full_zip IS NOT NULL AND in_full_zip <> '' THEN
				INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
					VALUES (zip_id, in_full_zip, general_form_id, employee_id, NOW(), NOW());
				SET insert_count = insert_count + 1;
			ELSEIF in_zip IS NOT NULL AND in_zip <> '' THEN
				INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
					VALUES (zip_id, in_zip, general_form_id, employee_id, NOW(), NOW());
				SET insert_count = insert_count + 1;
			END IF;
		END IF;
		
		
		-- Education
		IF in_education IS NOT NULL AND in_education <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (education_id, in_education, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		-- Person Number
		IF in_person_number IS NOT NULL AND in_person_number <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (person_number_id, in_person_number, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		-- Gender
		IF in_gender IS NOT NULL AND in_gender <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (gender_id, in_gender, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		-- DOB in_dob  not sure?
		-- Year of Birth  not sure?
		-- Age  not sure?
		-- Race and Ethnicity
		IF in_race_and_ethnicity IS NOT NULL AND in_race_and_ethnicity <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (ethnicity_id, in_race_and_ethnicity, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		-- Marital Status
		IF in_marital_status IS NOT NULL AND in_marital_status <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (w4_status_id, in_marital_status, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		-- ERS Identifier (SSN)
		IF in_ssn IS NOT NULL AND in_ssn <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (ssn_id, in_ssn, general_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
				
		-- Employment Form Records
		IF in_work_location_code IS NOT NULL AND in_work_location_code <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (work_location_code_id, in_work_location_code, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_job_title IS NOT NULL AND in_job_title <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (job_title_id, in_job_title, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_full_time IS NOT NULL AND in_full_time <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (full_time_id, in_full_time, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_shift IS NOT NULL AND in_shift <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (shift_id, in_shift, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_hire_date IS NOT NULL AND in_hire_date <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (hire_date_id, in_hire_date, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_training_wage IS NOT NULL AND in_training_wage <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (training_wage_id, in_training_wage, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_productivity IS NOT NULL AND in_productivity <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (productivity_id, in_productivity, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_basis_for_productivity IS NOT NULL AND in_basis_for_productivity <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (productivity_basis_id, in_basis_for_productivity, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_separation_date IS NOT NULL AND in_separation_date <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (separation_date_id, in_separation_date, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_separation_type IS NOT NULL AND in_separation_type <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (separation_type_id, in_separation_type, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_separation_reason IS NOT NULL AND in_separation_reason <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (separation_reason_id, in_separation_reason, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_add_comments IS NOT NULL AND in_add_comments <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (separation_add_comments, in_add_comments, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_exit_most IS NOT NULL AND in_exit_most <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (exit_like_id, in_exit_most, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_exit_least IS NOT NULL AND in_exit_least <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (exit_not_like_id, in_exit_least, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_exit_add IS NOT NULL AND in_exit_add <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (exit_add_comments, in_exit_add, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_tenure_months IS NOT NULL AND in_tenure_months <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (tenure_months_id, in_tenure_months, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_tenure_years IS NOT NULL AND in_tenure_years <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (tenure_years_id, in_tenure_years, employ_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		
		-- values for Additional Information Form Records
		IF in_classified IS NOT NULL AND in_classified <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (classified_id, in_classified, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_referal_source IS NOT NULL AND in_referal_source <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (hire_source_id, in_referal_source, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_veteran IS NOT NULL AND in_veteran <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (vet_id, in_veteran, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_special_disabled_veteran IS NOT NULL AND in_special_disabled_veteran <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (special_vet_id, in_special_disabled_veteran, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_vietnam_veteran IS NOT NULL AND in_vietnam_veteran <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (vietnam_vet_id, in_vietnam_veteran, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_veteran_date_of_seperation IS NOT NULL AND in_veteran_date_of_seperation <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (vet_date_id, in_veteran_date_of_seperation, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_other_veteran IS NOT NULL AND in_other_veteran <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (other_vet_id, in_other_veteran, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_ability_one_eligibility IS NOT NULL AND in_ability_one_eligibility <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (ability_one_id, in_ability_one_eligibility, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_disability IS NOT NULL AND in_disability <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (disability_id, in_disability, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_encore_dis_code IS NOT NULL AND in_encore_dis_code <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (encore_code_id, in_encore_dis_code, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_primary_disiability IS NOT NULL AND in_primary_disiability <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (primary_disability_id, in_primary_disiability, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_disiability1 IS NOT NULL AND in_disiability1 <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (add_dis_1_id, in_disiability1, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_disiability2 IS NOT NULL AND in_disiability2 <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (add_dis_2_id, in_disiability2, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_disiability3 IS NOT NULL AND in_disiability3 <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (add_dis_3_id, in_disiability3, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_npa IS NOT NULL AND in_npa <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (npa_id, in_npa, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_ability_one_direct IS NOT NULL AND in_ability_one_direct <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (ability_one_direct_id, in_ability_one_direct, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_ability_one_indirect IS NOT NULL AND in_ability_one_indirect <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (ability_on_indirect_id, in_ability_one_indirect, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_state_use_projects IS NOT NULL AND in_state_use_projects <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (state_project_id, in_state_use_projects, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_other_project IS NOT NULL AND in_other_project <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (other_project_id, in_other_project, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_flsa_14c IS NOT NULL AND in_flsa_14c <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (flsa_14_id, in_flsa_14c, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
		IF in_fringe_eligible IS NOT NULL AND in_fringe_eligible <> '' THEN
		INSERT INTO questionresponse (formquestion_id, response, dataform_id, employee_id, created_at, updated_at)
			VALUES (fringe_id, in_fringe_eligible, add_info_form_id, employee_id, NOW(), NOW());
		SET insert_count = insert_count + 1;
		END IF;
		
	END IF;
	UNTIL done END REPEAT;
	CLOSE recordInfo;
	SELECT insert_count as "Records Inserted into Database";
	END//
DELIMITER ;

-- -------------------------------------------------------
-- Call Procedure
-- -------------------------------------------------------
 CALL convert_records();
-- SELECT COUNT(*) from questionresponse;


-- -------------------------------------------------------
-- Drop Procedures
-- -------------------------------------------------------
 DROP PROCEDURE IF EXISTS convert_records;
 DROP FUNCTION IF EXISTS SPLIT_STR;


