<?php

use App\Models\Conversation;
use App\Models\User;
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
        Schema::create(Conversation::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->uuid('conversation_id');
            $table->timestamps();

            //$table->foreignId(column: 'sender_id')->references(column: 'id')->on(table: User::TABLE);
            //$table->foreignId(column: 'receiver_id')->references(column: 'id')->on(table: User::TABLE);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Conversation::TABLE);
    }
};
