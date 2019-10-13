<?php

namespace app\models;

use ErrorException;

class User extends AppModel
{
    // An array of both the names of the form fields and the table in the database
    public $attributes = [
        'login' => '',
        'password' => '',
    ];

    // Array of validation rules
    public $rules = [
        'required' => [
            ['login'],
            ['password'],
        ],
        'lengthMin' => [
            ['password', 6],
        ]
    ];

    /**
     * User login uniqueness checks
     * @return bool
     */
    public function checkUniqueLogin(): bool
    {
        $user = \R::findOne('users', 'login = ?', [$this->attributes['login']]);

        if ($user) {
            if ($user->login === $this->attributes['login']) {
                $this->errors['unique'][] = 'This login already exists.';
            }

            return false;
        }

        return true;
    }

    /**
     * Checking fields at login
     * @return bool
     * @throws ErrorException
     */
    public function login(): bool
    {
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;

        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;

        if ($login && $password) {
            $user = \R::findOne('users', 'login = ?', [$login]);
            if ($user && password_verify($password, $user->password)) {
                foreach ($user as $key => $value) {
                    if ($key !== 'password') {
                        $_SESSION['user'][$key] = $value;
                    }
                }

                return true;
            }
        } else {
            throw new ErrorException('Password or username do not match', 401);
        }

        return false;
    }

    /**
     * Logging Check
     * @return bool
     */
    public static function isLogin(): bool
    {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }
}