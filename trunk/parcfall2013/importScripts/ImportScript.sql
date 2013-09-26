----------------------------------------
-- Create temp table
----------------------------------------
DROP TABLE IF EXISTS tmp_data_import;
CREATE TABLE tmp_data_import (
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
	person_number INT NULL,
	gender VARCHAR(100) NULL,
	dob VARCHAR(100) NULL,
	year_of_birth INT NULL,
	age INT NULL,
	full_address VARCHAR(500) NULL,
	full_zip VARCHAR(100) NULL,
	race_and_ethnicity VARCHAR(100) NULL,
	marital_status VARCHAR(100) NULL,
	veteran TINYINT(1) UNSIGNED NULL,
	special_disabled_veteran VARCHAR(100) NULL,
	veteran_date_of_seperation VARCHAR(100) NULL,
	other_veteran VARCHAR(100) NULL,
	hire_date VARCHAR(100) NULL,
	ability_one_eligibility VARCHAR(100) NULL,
	disability VARCHAR(100) NULL,
	encore_dis_code VARCHAR(100) NULL,
	primary_disiability VARCHAR(100) NULL,
	disiability2 VARCHAR(100) NULL,
	disiability3 VARCHAR(100) NULL,
	npa  VARCHAR(100) NULL,
	ability_one_direct VARCHAR(100) NULL,
	ability_one_indirect VARCHAR(100) NULL,
	state_use_projects VARCHAR(100) NULL,
	training_wage VARCHAR(100) NULL,
	flsa_14c VARCHAR(100) NULL,
	productivity VARCHAR(100) NULL,
	basis_for_productivity VARCHAR(100) NULL,
	fringe_eligible VARCHAR(100) NULL,
	separation_date DATE NULL,
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
----------------------------------------
-- Import data into the temp table
----------------------------------------
LOAD DATA INFILE ''
	INTO TABLE  FIELDS TERMINATED BY ',' ENCLOSED BY '"'
		LINES TERMINATED BY '\r\n' IGNORE 0 LINES
	((name_last_first,
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
	veteran_date_of_seperation,
	other_veteran,
	hire_date,
	ability_one_eligibility,
	disability,
	encore_dis_code,
	primary_disiability,
	disiability2,
	disiability3,
	npa,
	ability_one_direct,
	ability_one_indirect,
	state_use_projects,
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
	ssn));
	
----------------------------------------
-- Create additional Forms
----------------------------------------





----------------------------------------
-- Populate Form Questions
----------------------------------------