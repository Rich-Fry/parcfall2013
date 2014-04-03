<?php

class Add_Personnelformtypeid_Trackeditem {

        public function up()
        {
                //
                Schema::table('TrackedItem', function($table)
                {
                        $table->integer('personnelFormType_id')->default(0)->unsigned();
                });
        }

        public function down()
        {
                Schema::table('TrackedItem', function($table)
                {
                        $table->drop_column('personnelFormType_id');
                });
        }

}