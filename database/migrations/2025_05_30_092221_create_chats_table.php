<?php

use App\Models\Chat;
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
        Schema::create(Chat::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->uuid(column: 'conversation_id');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Chat::TABLE);
    }
};
