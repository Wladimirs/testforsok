<?php

namespace app\models;

class Category extends AppModel
{
    // Category template
    protected $tpl;

    public $attributes = [
        'name' => '',
        'text' => '',
        'parent_id' => '',
    ];

    /**
     * Category Name Uniqueness Check
     */
    public function checkUniqueCategory(): bool
    {
        $category = \R::findOne('categories', 'name = ?', [$this->attributes['name']]);

        if ($category) {
            if ($category->name === $this->attributes['name']) {
                $this->errors['unique'][] = 'This name already exists.';
            }

            return false;
        }

        return true;
    }

    /**
     * Category tree for associative array
     * @param $categories
     * @return array
     */
    public function buildTreeCatForAssocArray($categories): array
    {
        $tree = [];

        if (is_array($categories)) {
            foreach ($categories as $id => &$nodes) {
                if (!$nodes['parent_id']) {
                    $tree[$id] = &$nodes;
                } else {
                    $categories[$nodes['parent_id']]['childs'][$id] = &$nodes;
                }
            }
        }

        return $tree;
    }

    /**
     * Getting html category code
     * @param $tree
     * @param string $tab
     * @param bool $select
     * @return string
     */
    public function getCatHtml($tree, $tab = '', $select = true): string
    {
        $str = '';

        foreach ($tree as $id => $category) {
            if (!$select) {
                $str .= $this->catToTemplate($category, $tab, $id);
            } else {
                $str .= $this->catToTemplateSelect($category, $tab, $id);
            }
        }

        return $str;
    }

    /**
     * Generating html code for each category
     * @param $category
     * @param $tab
     * @param $id
     * @return false|string
     */
    protected function catToTemplate($category, $tab, $id)
    {
        ob_start();

        require $this->tpl = APP . '/views/Category/child_cat.php';

        return ob_get_clean();
    }

    /**
     * Generating html code for select category
     * @param $category
     * @param $tab
     * @param $id
     * @return false|string
     */
    protected function catToTemplateSelect($category, $tab, $id)
    {
        ob_start();

        require $this->tpl = APP . '/views/Category/select.php';

        return ob_get_clean();
    }

    /**
     * Category tree for indexed array
     * @param $categories
     * @return array|mixed
     */
    public function buildTreeCategories(&$categories)
    {
        $map = array(
            0 => array('children' => array())
        );

        foreach ($categories as &$category) {
            $category['children'] = array();

            $map[$category['id']] = &$category;
        }

        unset($category);

        foreach ($categories as &$category) {
            $map[$category['parent_id']]['children'][] = &$category;
        }

        return $map[0]['children'] ?? array();
    }

    /**
     * List of parent and its children
     * @param $array
     * @param $id
     * @return array
     */
    public function listParentAndAllChildren($array, $id): array
    {
        return array_filter($array, function ($var) use ($id) {
            return ($var['id'] == $id);
        });
    }

    /**
     * Recursively select all id from the list of parent and its children
     * @param $list
     * @return array
     */
    public function getParentAndAllChildrenId($list): array
    {
        $res = array();

        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($list),
            \RecursiveIteratorIterator::SELF_FIRST) as $k => $v) {
            if ($k === 'id') {
                $res[] = $v;
            }
        }

        return $res;
    }
}