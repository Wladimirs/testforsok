<?php

namespace app\controllers;

use app\models\User;
use RedBeanPHP\RedException\SQL;

class UserController extends AppController
{
    /**
     * Checking and loading data from a form into a database
     * @throws \ErrorException
     */
    public function registerAction(): void
    {
        if (!empty($_POST) && !empty($_POST['token']) && $this->tokenMatch($_POST['token'])) {
            // Creating a User Model Object
            $user = new User();

            $data = $_POST;

            // Loading form data into the attributes array of the base Model
            $user->load($data);
            if (!$user->validate($data) || !$user->checkUniqueLogin()) {
                // Displaying errors on the registration page
                $user->getErrors();

                $_SESSION['form_data'] = $data;

                redirect();
            } else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                try {
                    // Saving from the attributes array to the database
                    $user->save('users');

                    $_SESSION['success'] = 'User is registered';

                    redirect('/');
                } catch (SQL $e) {
                    throw new \ErrorException('Error saving new user', 403);
                }
            }
        }
        // Getting a token from the base controller (CSRF protection)
        $token = $this->token;

        // Methods set() and setMeta() send data to the form
        $this->set(compact('token'));

        $this->setMeta('Registration', 'New user registration', 'Registration,User');
    }

    /**
     * User Login Verification
     */
    public function loginAction(): void
    {
        if (!empty($_POST) && !empty($_POST['token']) && $this->tokenMatch($_POST['token'])) {
            $user = new User();

            if ($user->login()) {
                $_SESSION['success'] = 'You are successfully logged in';

                redirect('/');
            } else {
                $_SESSION['error'] = 'This user does not exist';
            }

            redirect();
        }
        // Getting a token from the base controller (CSRF protection)
        $token = $this->token;

        // Methods set() and setMeta() send data to the form
        $this->set(compact('token'));

        $this->setMeta('Login User', 'Login User', 'Login,User');
    }

    /**
     * User Logout
     */
    public function logoutAction(): void
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        redirect('/');
    }
}