<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_candles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('launchpad_id')->constrained()->onDelete('cascade');
            $table->timestamp('timestamp');  // Start time of the candle
            $table->string('timeframe');     // 1m, 5m, 15m, 1h, 4h, 1d
            $table->decimal('open', 24, 12);
            $table->decimal('high', 24, 12);
            $table->decimal('low', 24, 12);
            $table->decimal('close', 24, 12);
            $table->decimal('volume', 24, 12);
            $table->integer('trades_count')->default(0);
            // Indexes for efficient querying
            $table->index(['launchpad_id', 'timeframe', 'timestamp']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_candles');
    }
};
