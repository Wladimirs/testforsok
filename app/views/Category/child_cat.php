<li class="list-group-item">
    <a href="/category/category?id=<?= $id ?>"><?= h($category['name']) ?></a>
    <?php if (isset($category['childs'])): ?>
        <ul class="list-group list-group-flush">
            <?= $this->getCatHtml($category['childs'], '&nbsp;' . $tab . '-', false) ?>
        </ul>
    <?php endif; ?>
</li>