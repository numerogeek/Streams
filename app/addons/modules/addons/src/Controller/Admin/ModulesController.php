<?php namespace Addon\Module\Addons\Controller\Admin;

use Addon\Module\Addons\Model\ModuleEntryModel;
use Streams\Controller\AdminController;
use Addon\Module\Addons\Contract\ModuleRepositoryInterface;
use Streams\Ui\EntryTableUi;

class ModulesController extends AdminController
{
    /**
     * Create a new ModulesController instance.
     *
     * @param \Streams\Addon\ModuleManager $modules
     */
    public function __construct(ModuleRepositoryInterface $modules)
    {
        parent::__construct();

        $modules->sync();

        $this->table   = new EntryTableUi();
        $this->modules = new ModuleEntryModel();
    }

    /**
     * Display a table of all modules.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->table->make($this->modules)->columns(
            array(
                'id',
                'slug',
                'closure column' => array(
                    'value' => function ($entry) {
                            return $entry;
                        }
                ),
                'parsed column'  => array(
                    'value' => 'Boom.'
                )
            )
        )
            ->buttons(
                array(
                    array(
                        'url'        => 'http://url.com',
                        'title'      => function ($entry) {
                                return 'Do something with ' . $entry->slug;
                            },
                        'attributes' => array(
                            'data-foo' => 'Test',
                            'class'    => 'btn btn-xs btn-success',
                        ),
                    )
                )
            )->render();
    }
}