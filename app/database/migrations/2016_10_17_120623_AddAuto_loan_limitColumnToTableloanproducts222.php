<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutoLoanLimitColumnToTableloanproducts222 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('loanproducts',function($table){
			$table->decimal('auto_loan_limit')->nullable();	
			$table->string('application_form')->nullable();			
		});		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('loanproducts',function($table){
			$table->dropColumn('auto_loan_limit');
			$table->dropColumn('application_form');
		});		
	}

}
