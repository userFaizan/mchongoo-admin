<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUserKycDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_kyc_documents', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('business_license');
            $table->string('national_id')->nullable()->after('profile_photo');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_kyc_documents', function (Blueprint $table) {
            $table->dropColumn('profile_photo');
            $table->dropColumn('national_id');

        });
    }
}
