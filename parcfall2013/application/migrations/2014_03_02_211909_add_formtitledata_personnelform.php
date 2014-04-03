<?php

class Add_Formtitledata_PersonnelformType {

        /**
         * Make changes to the database.
         *
         * @return void
         */
        public function up()
        {
                //
                DB::table('PersonnelFormType')->insert(array(
                        'formTitle'=> 'supportStrategies',
                        'created_at'=>date('Y-m-d H:m:s'),
                        'updated_at'=>date('Y-m-d H:m:s')
                        ));
                DB::table('PersonnelFormType')->insert(array(
                        'formTitle'=> 'clientUpdateBilling',
                        'created_at'=>date('Y-m-d H:m:s'),
                        'updated_at'=>date('Y-m-d H:m:s')
                        ));
        }

        /**
         * Revert the changes to the database.
         *
         * @return void
         */
        public function down()
        {
                DB::table('PersonnelFormType')->where('formTitle', '=', 'supportStrategies')->delete();
                DB::table('PersonnelFormType')->where('formTitle', '=', 'clientUpdateBilling')->delete();
        }

}