<?php namespace Addon\Module\Users\Controller\Admin;

use Streams\Controller\AdminController;
use Streams\Model\Users\UsersUsersEntryModel;
use Streams\Ui\EntryTableUi;

class UsersController extends AdminController
{
    /**
     * Construct without bothering the parents.
     */
    public function boot()
    {
        $this->table = new EntryTableUi();
        $this->users = new UsersUsersEntryModel();
    }

    /**
     * Display a table of all users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->table->make($this->users)->columns(
            array(
                'email',
                'closure column' => array(
                    'header' => 'Name',
                    'value'  => function ($entry) {
                            return "{$entry->first_name} {$entry->last_name}";
                        }
                ),
                'parsed column'  => array(
                    'value' => 'Boom.'
                )
            )
        )->render();
    }
}