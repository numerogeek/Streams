<?php namespace StreamsInstaller;

/**
 * Class InstallerSchema
 * Create all the main tables.
 *
 * @package StreamsInstaller
 */
class InstallerSchema
{
    public function install()
    {
        // Create streams table
        \Schema::dropIfExists('streams_streams');

        \Schema::create(
            'streams_streams',
            function ($table) {
                $table->increments('id');
                $table->string('namespace', 60);
                $table->string('slug', 60);
                $table->string('name', 60);
                $table->string('prefix', 60)->nullable();
                $table->string('about', 255)->nullable();
                $table->text('view_options');
                $table->string('title_column', 255)->nullable();
                $table->enum('sort_by', array('title', 'custom'))->default('title');
                $table->text('permissions')->nullable();
                $table->string('menu_path', 255)->nullable();
                $table->boolean('is_hidden')->default(0);
            }
        );

        // Create fields table
        \Schema::dropIfExists('streams_fields');

        \Schema::create('streams_fields', function($table) {
                $table->increments('id');
                $table->string('name', 60);
                $table->string('slug', 60);
                $table->string('namespace', 60)->nullable();
                $table->string('type', 50);
                $table->text('settings')->nullable();
                $table->dateTime('created_at');
                $table->dateTime('updated_at')->nullable();
                $table->boolean('is_locked')->default(0);
            });

        // Create assignments table
        \Schema::dropIfExists('streams_fields_assignments');

        \Schema::create(
            'streams_fields_assignments',
            function ($table) {
                $table->increments('id');
                $table->integer('sort_order');
                $table->integer('stream_id');
                $table->integer('field_id');
                $table->boolean('is_required')->default(0);
                $table->boolean('is_unique')->default(0);
                $table->text('instructions')->nullable();
                $table->string('field_name', 60)->nullable();
            }
        );
    }
}