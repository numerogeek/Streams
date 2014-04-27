<?php namespace Addon\FieldType\User;

use Streams\Addon\FieldTypeAbstract;

class UserFieldType extends FieldTypeAbstract
{
    /**
     * The database column type this field type uses.
     *
     * @var string
     */
    public $columnType = 'string';

    /**
     * Field type version
     *
     * @var string
     */
    public $version = '1.1.0';

    /**
     * Available field type settings.
     *
     * @var array
     */
    public $settings = array(
        'groups',
    );

    /**
     * Field type author information.
     *
     * @var array
     */
    public $author = array(
        'name' => 'AI Web Systems, Inc.',
        'url'  => 'http://aiwebsystems.com/',
    );

    /**
     * Create a new UserFieldType instance.
     */
    public function __construct()
    {
        $this->users = new \Streams\Model\UserModel;
    }

    /**
     * The field type relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relation()
    {
        return $this->belongsTo($this->getRelationClass('Streams\Model\UserModel'));
    }

    /**
     * Return the input used for forms.
     *
     * @return mixed
     */
    public function formInput()
    {
        \Form::select($this->formSlug, $this->users->get()->lists('username', 'id'), $this->value);
    }

    /**
     * Return the string output value.
     *
     * @return null
     */
    public function stringOutput()
    {
        if ($user = $this->getRelationResult()) {
            return $user->username;
        }

        return null;
    }

    /**
     * Return the plugin output value.
     *
     * @return null
     */
    public function pluginOutput()
    {
        if ($user = $this->getRelationResult()) {
            return $user->toArray();
        }

        return null;
    }

    /**
     * Return the data output value.
     *
     * @return null
     */
    public function dataOutput()
    {
        if ($user = $this->getRelationResult()) {
            return $user;
        }

        return null;
    }

    /**
     * Get column name
     *
     * @return string
     */
    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }
}
