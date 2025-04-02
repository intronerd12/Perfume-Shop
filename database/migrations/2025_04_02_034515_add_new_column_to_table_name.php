<?php
public function up()
{
    Schema::table('table_name', function (Blueprint $table) {
        $table->string('new_column');  // add your new column
    });
}

public function down()
{
    Schema::table('table_name', function (Blueprint $table) {
        $table->dropColumn('new_column');
    });
}