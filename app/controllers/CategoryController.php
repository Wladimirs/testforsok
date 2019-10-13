<?php

namespace app\controllers;

use app\models\Category;
use app\models\User;
use ErrorException;
use Exception;
use RedBeanPHP\RedException\SQL;

class CategoryController extends AppController
{
    public function __construct($route)
    {
        parent::__construct($route);

        // Category admission only for logged in users
        if (!User::isLogin()) {
            redirect('/');
        }
    }

    /**
     * List of all categories
     */
    public function viewAction(): void
    {
        $cat_model = new Category();

        $categories = \R::getAssoc('SELECT * FROM categories');

        // Formation of parent categories with children
        $tree = $cat_model->buildTreeCatForAssocArray($categories);

        // Creating a template for categories
        $html = $cat_model->getCatHtml($tree, '', false);

        // Methods set() and setMeta() send data to the form
        $this->set(compact('html'));

        $this->setMeta('Categories', 'Table of all categories and subcategories',
            'Table,Categories');
    }

    /**
     * Selected Category
     */
    public function categoryAction(): void
    {
        if (isset($_GET['id'])) {
            $id = $this->getRequestID();

            $category = \R::findOne('categories', 'id = ?', [$id]);

            // Methods set() and setMeta() send data to the form
            $this->set(compact('category'));

            $this->setMeta('Category', 'One category', 'One,Category');
        } else {
            throw new \RuntimeException('Page not found', 404);
        }
    }

    /**
     * Adding new category
     * @throws ErrorException
     */
    public function addAction(): void
    {
        $category = new Category();

        if (!empty($_POST) && !empty($_POST['token']) && $this->tokenMatch($_POST['token'])) {
            $data = $_POST;

            $category->load($data);

            if (!$category->validate($data) || !$category->checkUniqueCategory()) {
                $category->getErrors();

                $_SESSION['form_data'] = $data;

                redirect();
            } else {
                try {
                    $category->save('categories');

                    $_SESSION['success'] = 'Category created';

                    redirect('/category/view');
                } catch (SQL $e) {
                    throw new ErrorException('New category not saved', 403);
                }
            }
        } else {
            $categories = \R::getAssoc('SELECT id,name,parent_id FROM categories');

            $categories = $category->buildTreeCatForAssocArray($categories);

            $html = $category->getCatHtml($categories, '');

            // Getting a token from the base controller (CSRF protection)
            $token = $this->token;

            // Methods set() and setMeta() send data to the form
            $this->set(compact('html', 'token'));
        }

        $this->setMeta('New category', 'Creating New Category', 'New,Category');
    }

    /**
     * Category Editing
     * @throws ErrorException
     * @throws SQL
     */
    public function editAction(): void
    {
        $category = new Category();

        if (!empty($_POST) && !empty($_POST['token']) && $this->tokenMatch($_POST['token'])) {
            // Getting id from post request
            $id = $this->getRequestID(false);

            $data = $_POST;

            $category->load($data);

            if (!$category->validate($data)) {
                $category->getErrors();

                redirect();
            }
            if ($category->update('categories', $id)) {
                $category = \R::load('categories', $id);

                \R::store($category);

                $_SESSION['success'] = 'Changes saved';
            } else {
                throw new ErrorException('Changes not saved', 403);
            }

            redirect();
        } else {
            $categories = \R::getAssoc('SELECT id,name,parent_id FROM categories');

            // Creating a category tree
            $categories = $category->buildTreeCatForAssocArray($categories);

            // Connecting recursive template output for a category tree
            $html = $category->getCatHtml($categories, '');

            // Getting id from get request
            $id = $this->getRequestID();

            // Getting category
            $category = \R::load('categories', $id);

            if ($category->id === 0) {
                throw new \RuntimeException('Page not found', 404);
            }

            // Getting the name of the parent category
            $parent_name = \R::getCell('SELECT name FROM categories WHERE id = ?', [$category->parent_id]);

            // Getting a token from the base controller (CSRF protection)
            $token = $this->token;

            // Methods set() and setMeta() send data to the form
            $this->set(compact('html', 'category', 'parent_name', 'token'));
        }

        $this->setMeta('Edit Category', 'Category Editing', 'Category,Edit');
    }

    /**
     * Delete selected category
     */
    public function deleteAction(): void
    {
        $cat_model = new Category();

        if (isset($_GET['id'])) {
            // Getting id from get request
            $id = $this->getRequestID();

            // Search for child categories in the current category
            //$children = \R::count('categories', 'parent_id = ?', [$id]);

            //$errors = '';

            // If there are any children in the current one, then send the message to the session
            // and redirect
            /*if ($children){
                $errors .= '<li>Removal is not possible because this category has nested categories</li>';
            }

            if ($errors){
                $_SESSION['error'] = "<ul>$errors</ul>";

                redirect();
            }*/

            $categories = \R::getAll('SELECT * FROM categories');

            // Creating a category tree
            $cat_model->buildTreeCategories($categories);

            // Getting list of parent and its children
            $catId = $cat_model->listParentAndAllChildren($categories, $id);

            // Getting all id from the list of parent and its children
            $result = $cat_model->getParentAndAllChildrenId($catId);

            // Delete the entire list
            \R::trashBatch('categories', $result);

            $_SESSION['success'] = 'Category deleted successfully';

            redirect('/category/view');
        } else {
            throw new \RuntimeException('Page not found', 404);
        }
    }
}