<?php namespace StreamsInstaller;

use Illuminate\Support\Facades\DB;

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
        // Get the connection
        $connection = \Schema::getConnection();

        // Create apps table
        \Schema::dropIfExists('apps');

        \Schema::create(
            'apps',
            function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('reference');
                $table->string('domain');
                $table->boolean('is_enabled')->default(0);
            }
        );

        /*******************************************
         * REMOVE AFTER INSTALLED IS FINISHED!
         *******************************************/
        DB::table('apps')->insert(
            array(
                'name'       => 'Develop',
                'reference'  => 'develop',
                'domain'     => 'streams',
                'is_enabled' => true,
            )
        );
        /*******************************************
         * EOF: REMOVE AFTER INSTALLED IS FINISHED!
         *******************************************/

        // Change / get the table prefix
        $connection->setTablePrefix($tablePrefix = \Application::getTablePrefix());

        // Create streams table
        \Schema::dropIfExists($tablePrefix . 'streams_streams');

        \Schema::create(
            $tablePrefix . 'streams_streams',
            function ($table) {
                $table->increments('id');
                $table->string('namespace', 60);
                $table->string('slug', 60);
                $table->string('prefix', 60)->nullable();
                $table->string('name', 60)->nullable();
                $table->string('description', 255)->nullable();
                $table->text('view_options')->nullable();
                $table->string('title_column', 255)->nullable();
                $table->enum('sort_by', array('title', 'custom'))->default('title');
                $table->text('permissions')->nullable();
                $table->string('menu_path', 255)->nullable();
                $table->boolean('is_hidden')->default(0);
            }
        );

        // Create fields table
        \Schema::dropIfExists($tablePrefix . 'streams_fields');

        \Schema::create(
            $tablePrefix . 'streams_fields',
            function ($table) {
                $table->increments('id');
                $table->string('namespace', 60)->nullable();
                $table->string('slug', 60);
                $table->string('name', 60);
                $table->string('type', 50);
                $table->text('settings')->nullable();
                $table->boolean('is_locked')->default(0);
            }
        );

        // Create assignments table
        \Schema::dropIfExists($tablePrefix . 'streams_fields_assignments');

        \Schema::create(
            $tablePrefix . 'streams_fields_assignments',
            function ($table) {
                $table->increments('id');
                $table->integer('sort_order');
                $table->integer('stream_id');
                $table->integer('field_id');
                $table->string('name', 60)->nullable();
                $table->text('instructions')->nullable();
                $table->boolean('is_required')->default(0);
                $table->boolean('is_unique')->default(0);
            }
        );
    }
}