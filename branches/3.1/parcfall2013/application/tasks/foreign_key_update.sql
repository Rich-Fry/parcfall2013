-- FK fixes --

ALTER TABLE `speed3db`.`employeeprogram` 
ADD INDEX `employeeprogram_employee_id_foreign_idx` (`employee_id` ASC);
ALTER TABLE `speed3db`.`employeeprogram` 
ADD CONSTRAINT `employeeprogram_employee_id_foreign`
  FOREIGN KEY (`employee_id`)
  REFERENCES `speed3db`.`employee` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  ALTER TABLE `speed3db`.`employeeprogram` 
ADD INDEX `employeeprogram_program_id_idx` (`program_id` ASC);
ALTER TABLE `speed3db`.`employeeprogram` 
ADD CONSTRAINT `employeeprogram_program_id`
  FOREIGN KEY (`program_id`)
  REFERENCES `speed3db`.`program` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  ALTER TABLE `speed3db`.`questionresponse` 
ADD INDEX `questionresponse_employee_id_foreign_idx` (`employee_id` ASC);
ALTER TABLE `speed3db`.`questionresponse` 
ADD CONSTRAINT `questionresponse_employee_id_foreign`
  FOREIGN KEY (`employee_id`)
  REFERENCES `speed3db`.`employee` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  ALTER TABLE `speed3db`.`questionresponse` 
CHANGE COLUMN `dataform_id` `dataform_id` INT(10) UNSIGNED NOT NULL ;

ALTER TABLE `speed3db`.`questionresponse` 
ADD INDEX `questionresponse_dataform_id_idx` (`dataform_id` ASC);
ALTER TABLE `speed3db`.`questionresponse` 
ADD CONSTRAINT `questionresponse_dataform_id`
  FOREIGN KEY (`dataform_id`)
  REFERENCES `speed3db`.`form` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `speed3db`.`formquestion` 
ADD INDEX `formquestion_dataform_id_idx` (`dataform_id` ASC);
ALTER TABLE `speed3db`.`formquestion` 
ADD CONSTRAINT `formquestion_dataform_id`
  FOREIGN KEY (`dataform_id`)
  REFERENCES `speed3db`.`form` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  ALTER TABLE `speed3db`.`trackedtemplate` 
ADD INDEX `trackedtemplate_trackedcategory_id_foreign_idx` (`trackedcategory_id` ASC);
ALTER TABLE `speed3db`.`trackedtemplate` 
ADD CONSTRAINT `trackedtemplate_trackedcategory_id_foreign`
  FOREIGN KEY (`trackedcategory_id`)
  REFERENCES `speed3db`.`trackedcategory` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  
  ALTER TABLE `speed3db`.`trackeditem` 
ADD INDEX `trackeditem_employee_id_foreign_idx` (`employee_id` ASC),
ADD INDEX `trackeditem_trackedcategory_id_foreign_idx` (`trackedcategory_id` ASC);
ALTER TABLE `speed3db`.`trackeditem` 
ADD CONSTRAINT `trackeditem_employee_id_foreign`
  FOREIGN KEY (`employee_id`)
  REFERENCES `speed3db`.`employee` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `trackeditem_trackedcategory_id_foreign`
  FOREIGN KEY (`trackedcategory_id`)
  REFERENCES `speed3db`.`trackedcategory` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

  ALTER TABLE `speed3db`.`formprogram` 
ADD INDEX `formprogram_program_id_foreign_idx` (`program_id` ASC),
ADD INDEX `formprogram_dataform_id_foreign_idx` (`dataform_id` ASC);
ALTER TABLE `speed3db`.`formprogram` 
ADD CONSTRAINT `formprogram_program_id_foreign`
  FOREIGN KEY (`program_id`)
  REFERENCES `speed3db`.`program` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `speed3db`.`trackeditemfield` 
ADD INDEX `trackeditemfield_trackeditem_id_foreign_idx` (`trackeditem_id` ASC),
ADD INDEX `trackeditemfield_trackedtemplatefield_id_foreign_idx` (`trackedtemplatefield_id` ASC);
ALTER TABLE `speed3db`.`trackeditemfield` 
ADD CONSTRAINT `trackeditemfield_trackeditem_id_foreign`
  FOREIGN KEY (`trackeditem_id`)
  REFERENCES `speed3db`.`trackeditem` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `trackeditemfield_trackedtemplatefield_id_foreign`
  FOREIGN KEY (`trackedtemplatefield_id`)
  REFERENCES `speed3db`.`trackedtemplatefield` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

 ALTER TABLE `speed3db`.`reporttemplatefield` 
ADD INDEX `reporttemplatefield_formquestion_id_idx` (`formquestion_id` ASC);
ALTER TABLE `speed3db`.`reporttemplatefield` 
ADD CONSTRAINT `reporttemplatefield_formquestion_id_foreign`
  FOREIGN KEY (`formquestion_id`)
  REFERENCES `speed3db`.`formquestion` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `speed3db`.`employeeprogram` 
DROP FOREIGN KEY `employeeprogram_program_id`;

ALTER TABLE `speed3db`.`employeeprogram` 
DROP FOREIGN KEY `employeeprogram_program_id`,
DROP FOREIGN KEY `employeeprogram_employee_id_foreign`;
ALTER TABLE `speed3db`.`employeeprogram` 
DROP INDEX `employeeprogram_program_id_idx` ,
DROP INDEX `employeeprogram_employee_id_foreign_idx` ;
