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
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('project_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->uuid('milestone_id')->nullable();
            $table->text('status')->nullable();
            $table->integer('order_column')->default(0);
            $table->text('priority')->nullable();
            $table->foreignId('user_id');

            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('milestone_id')->references('id')->on('project_milestones')->onDelete('cascade');

            $table->index('start_date');
            $table->index('due_date');
            $table->index(['start_date', 'due_date']);

            $table->index('status');
            $table->index('order_column');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tasks');
    }
};
