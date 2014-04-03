<?php

class Create_PersonnelForm {    

        public function up()
    {
                Schema::create('PersonnelForm', function($table) {
                        
                        $table->increments('id');
                        $table->integer('employee_id')->unsigned();
                        $table->integer('personnelFormType_id')->default(1)->unsigned();
                        $table->date('effectiveDateFrom');
                        $table->date('effectiveDateTo');
                        $table->string('outcomeA');
                        $table->string('supportA');
                        $table->string('personResponsibleA');
                        $table->string('relationshipA');
                        $table->string('paidSupportA');
                        $table->string('naturalSupportA');
                        $table->string('suggestedByA');
                        $table->string('supportStrategyA');
                        $table->string('actionItemA');
                        $table->string('outcomeB');
                        $table->string('supportB');
                        $table->string('personResponsibleB');
                        $table->string('relationshipB');
                        $table->string('paidSupportB');
                        $table->string('naturalSupportB');
                        $table->string('suggestedByB');
                        $table->string('supportStrategyB');
                        $table->string('actionItemB');
                        $table->string('standAloneSupport');
                        $table->string('hasMaladaptiveBehavior');
                        $table->string('hasMedicalIssues');
                        $table->string('issueDescription');
                        $table->string('supportDescription');
                        $table->string('trainingDescription');
                        $table->string('programDescription');
                        $table->string('naturalSupportDevelopment');
                        $table->timestamps();
        });

    }    

        public function down()
    {
                Schema::drop('PersonnelForm');

    }

}