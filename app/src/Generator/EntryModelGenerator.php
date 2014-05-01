<?php namespace Streams\Generator;

use Illuminate\Support\Str;
use Streams\Model\StreamModel;

class EntryModelGenerator extends Generator
{
    protected $relationFields;

    /**
     * Site ref path
     *
     * @return string
     */
    public function getAppRefPath($path = null)
    {
        return 'models/streams/' . studly_case(\Application::getAppRef());
    }

    /**
     * Compile
     *
     * @param StreamModel $stream
     * @return bool
     */
    public function compileEntryModel(StreamModel $stream)
    {
        $stream->load('assignments.field');

        if (!empty($stream->slug) and !empty($stream->namespace)) {

            $appRefPath = $this->getAppRefPath();

            $namespace = Str::studly($stream->namespace);

            // Create the app ref folder
            if (!is_dir(app_path("{$appRefPath}"))) {
                mkdir(app_path("{$appRefPath}"), 0777);
            }

            // Create the namespace folder
            if (!is_dir(app_path("{$appRefPath}/{$namespace}"))) {
                mkdir(app_path("{$appRefPath}/{$namespace}"), 0777);
            }

            $className = Str::studly($stream->namespace . '_' . $stream->slug) . 'EntryModel';

            $this->make(
                app_path("{$appRefPath}/{$namespace}/{$className}.php"),
                array(
                    '{className}'      => $className,
                    '{table}'          => "'" . $stream->prefix . $stream->slug . "'",
                    '{stream}'         => $this->compileStreamData($stream),
                    '{relations}'      => $this->compileRelations($stream),
                    '{relationFields}' => $this->compileRelationFieldsData($stream),
                ),
                $update = true
            );


            return true;
        }

        return false;
    }

    /**
     * Compile Stream data
     *
     * @param StreamModel $stream
     * @return string
     */
    protected function compileStreamData(StreamModel $stream)
    {
        // Stream attributes array
        $string = 'array(';

        foreach ($stream->getAttributes() as $key => $value) {

            $value = $this->adjustValue($value, in_array($key, array('stream_name', 'about')));

            $string .= "\n{$this->s(8)}'{$key}' => {$value},";

        }

        // Assignments array
        $string .= "\n{$this->s(8)}'assignments' => array(";

        foreach ($stream->assignments as $assignment) {

            // Assignment attributes array
            $string .= "\n{$this->s(12)}array(";

            foreach ($assignment->getAttributes() as $key => $value) {

                $value = $this->adjustValue($value, in_array($key, array('instructions')));

                $string .= "\n{$this->s(16)}'{$key}' => {$value},";
            }

            // Field attributes array
            $string .= "\n{$this->s(16)}'field' => array(";

            foreach ($assignment->field->getAttributes() as $key => $value) {

                    $value = $this->adjustValue($value, in_array($key, array('field_name')));

                    $string .= "\n{$this->s(20)}'{$key}' => {$value},";

            }

            // End field attributes array
            $string .= "\n{$this->s(16)}),";

            // End assignment attributes array
            $string .= "\n{$this->s(12)}),";
        }

        // End assignments array
        $string .= "\n{$this->s(8)}),";

        // End stream attributes array
        $string .= "\n{$this->s(4)})";

        return $string;
    }

    /**
     * Add a number of spaces
     *
     * @param int
     * @return string
     */
    protected function s($n)
    {
        return str_repeat("\x20", $n);
    }

    /**
     * Adjust the value to be compiled as a string
     *
     * @param  mixed $value
     * @return mixed
     */
    protected function adjustValue($value, $escape = false)
    {
        if (is_null($value)) {
            $value = 'null';
        } elseif (is_bool($value)) {

            if ($value) {
                $value = 'true';
            } else {
                $value = 'false';
            }

        } elseif (!is_numeric($value) and !is_bool($value)) {

            if ($escape) {
                $value = addslashes($value);
            }

            $value = "'" . $value . "'";
        }

        return $value;
    }

    public function compileRelations(StreamModel $stream)
    {
        $string = '';

        foreach ($this->getRelationFields($stream) as $assignment) {

            $type = $assignment->getType();

            $type->setStream($stream);

            $relationString = '';

            $relationArray = $type->relation();

            $method = Str::camel($assignment->field->field_slug);

            $relationMethod = $relationArray['method'];

            $relationString .= "\n{$this->s(4)}public function {$method}()";

            $relationString .= "\n{$this->s(4)}{";

            $relationString .= "\n{$this->s(8)}return \$this->{$relationMethod}(";

            foreach ($relationArray['arguments'] as &$argument) {
                $argument = $this->adjustValue($argument);
            }

            $relationString .= implode(', ', $relationArray['arguments']);

            $relationString .= ");";

            $relationString .= "\n{$this->s(4)}}";

            $relationString .= "\n";

            $string .= $relationString;
        }

        return $string;
    }

    /**
     * Get relation fields
     *
     * @param StreamModel $stream
     * @return mixed
     */
    protected function getRelationFields(StreamModel $stream)
    {
        return $this->relationFields = $this->relationFields ? : $stream->assignments->getRelationFields();
    }

    /**
     * Compile relation fields data
     *
     * @param StreamModel $stream
     * @return string
     */
    protected function compileRelationFieldsData(StreamModel $stream)
    {
        $string = "array(";

        foreach ($this->getRelationFields($stream) as $assignment) {

            $relationArray = $assignment->getType()->relation();

            $key = $this->adjustValue($assignment->fieldSlug);

            $value = $this->adjustValue($relationArray['method']);

            $string .= "\n{$this->s(8)}{$key} => {$value},";
        }

        $string .= "\n{$this->s(4)})";

        return $string;
    }

    /**
     * Fetch the compiled template for a model
     *
     * @param  string $template Path to template
     * @param  string $className
     * @return string Compiled template
     */
    protected function getTemplate($data = array())
    {
        return str_replace(array_keys($data), $data, file_get_contents($this->getTemplatePath()));
    }

    public function getTemplatePath()
    {
        return app_path('assets/generator/EntryModelTemplate.txt');
    }
}
