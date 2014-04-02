/ application/ migrations/ 2014_03_02_211909_add_formtitledata_personnelform.php
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
Hide details
Change log
r108 by esbeth@gmail.com on Today (2 hours ago)   Diff
[No log message]
Go to: 	
Double click a line to add a comment
Older revisions
All revisions of this file
File info
Size: 774 bytes, 36 lines
View raw file
