    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invocation_claims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('invocation_id')->nullable();
            $table->string('bond_type')->nullable();
            $table->integer('bond_id')->default(0);
            $table->text('bond_detail')->nullable();
            $table->string('conditional')->nullable();
            $table->text('bond_wording')->nullable();
            $table->date('invocation_notice_date')->nullable();
            $table->date('invocation_claim_date')->nullable();
            $table->enum('claim_form', ['Yes', 'No'])->default('Yes')->nullable();
            $table->enum('invocation_notice', ['Yes', 'No'])->default('Yes')->nullable();
            $table->enum('contract_copy', ['Yes', 'No'])->default('Yes')->nullable();
            $table->enum('correspondence_details', ['Yes', 'No'])->default('Yes')->nullable();
            $table->enum('arbitration', ['Yes', 'No'])->default('Yes')->nullable();
            $table->enum('dispute', ['Yes', 'No'])->default('Yes')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('account_type')->nullable();
            $table->string('micr')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->integer('claimed_amount')->default(0);
            $table->integer('claimed_disallowed')->default(0);
            $table->string('total_claim_approved')->nullable();
            $table->text('remark')->nullable();          
            $table->string('status')->nullable();
            $table->tinyInteger('is_amendment')->default(0)->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->string('ip')->nullable();
            $table->string('update_from_ip')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invocation_claims');
    }
};
