<?php
$parent_id = \R::getAssoc('SELECT parent_id FROM categories');
?>
    <option value="<?= $id; ?>"
        <?php if ($id == $parent_id) {
            echo ' selected';
        } ?><?php if (isset($_GET['id']) && $id == $_GET['id']) {
        echo ' disabled';
    } ?>><?= $tab . h($category['name']) ?>
    </option>
<?php if (isset($category['childs'])) : ?>
    <?= $this->getCatHtml($category['childs'], '&nbsp;' . $tab . '-') ?>
<?php endif; ?>