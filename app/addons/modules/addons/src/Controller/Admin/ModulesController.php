<?php namespace Addon\Module\Addons\Controller\Admin;

use Addon\Module\Addons\Model\ModuleEntryModel;
use Streams\Controller\AdminController;
use Streams\Ui\EntryTableUi;

class ModulesController extends AdminController
{
    /**
     * Construct without bothering the parents.
     */
    public function boot()
    {
        $this->table   = new EntryTableUi();
        $this->modules = new ModuleEntryModel();

        $this->modules->sync();
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