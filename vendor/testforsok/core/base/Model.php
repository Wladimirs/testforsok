<?php

namespace testforsok\base;

use testforsok\Db;
use RedBeanPHP\RedException\SQL;
use Valitron\Validator;

abstract class Model
{
    // An array of model properties that matches the names of the fields in the table
    public $attributes = [];

    // Array with application errors
    public $errors = [];

    // Array of data validation rules
    public $rules = [];

    public function __construct()
    {
        // Connecting the Model to the database
        Db::instance();
    }

    /**
     * Loading data from a template form into a Model
     * @param $data
     */
    public function load($data): void
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    /**
     * Saving data from a template form to a database
     * @param $table
     * @param bool $valid
     * @return int|string
     * @throws SQL
     */
    public function save($table, $valid = true)
    {
        if ($valid) {
            $tbl = \R::dispense($table);
        } else {
            $tbl = \R::xdispense($table);
        }

        // Getting all the data from the registration fields
        foreach ($this->attributes as $name => $value) {
            $tbl->$name = $value;
        }
        // Saving data to a database table
        return \R::store($tbl);
    }

    /**
     * Editing data from a template form to a database
     * @param $table
     * @param $id
     * @return int|string
     * @throws SQL
     */
    public function update($table, $id)
    {
        $bean = \R::load($table, $id);
        foreach ($this->attributes as $name => $value) {
            $bean->$name = $value;
        }
        return \R::store($bean);
    }

    /**
     * Data validation method (uses the vlucas / valitron library connected via composer)
     * @param $data
     * @return bool|null
     */
    public function validate($data): ?bool
    {
        $val = new Validator($data);
        $val->rules($this->rules);
        if ($val->validate()) {
            return true;
        }
        $this->errors = $val->errors();
        return false;
    }

    /**
     * Error output through the session
     */
    public function getErrors(): void
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>$item.</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }
}