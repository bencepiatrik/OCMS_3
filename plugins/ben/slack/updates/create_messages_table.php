<?php namespace Ben\Slack\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateMessagesTable Migration
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
        Schema::create('ben_slack_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chat_id');
            $table->integer('user_id');
            $table->text('content');
            $table->integer('reply_to_message_id')->nullable();
            $table->timestamps();
        });

    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('ben_slack_messages');
    }
};
