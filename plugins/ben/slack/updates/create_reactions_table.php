<?php namespace Ben\Slack\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateReactionsTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('ben_slack_reactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id');
            $table->integer('user_id');
            $table->string('emoji');
            $table->timestamps();
        });

    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('ben_slack_reactions');
    }
};
