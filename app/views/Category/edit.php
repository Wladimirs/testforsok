<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
            <h1>Category Edit Page</h1>
        </div>
        <?php if (!empty($_SESSION['user'])): ?>
            <div class="col-lg-6 col-md-6 col-sm-6 text-right">
                <h3>Name: <?= h($_SESSION['user']['login']) ?></h3>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/category/view">Categories</a></li>
                <li class="breadcrumb-item"><a href="/category/category?id=<?= $category['id'] ?>">Category</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
        </div>
    </div>
    <?php if (isset($category)): ?>
        <form action="/category/edit" method="post" class="form-horizontal" id="myForm">
            <fieldset>
                <legend>Category Change Name</legend>
                <hr>
                <div class="form-group">
                    <div class="form-group">
                        <label class="form-control-label" for="inputSuccess1">Category Name</label>
                        <input type="text" name="name" class="form-control" name="name"
                               value="<?= h($category->name) ?>" id="inputSuccess1"
                               placeholder="Category Name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputSuccess2">Category Text</label>
                    <textarea class="form-control" id="inputSuccess2" name="text"
                              rows="3" required><?= h($category->text) ?></textarea>
                </div>
                <div class="form-group">
                    <select class="custom-select" name="parent_id">
                        <option value="<?= $category->parent_id ?>"><?= h($parent_name) ?></option>
                        <?= $html ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <a href="/category/category?id=<?= $category->id ?>" class="btn btn-primary btn-small">Back</a>
                        <input type="hidden" name="id" value="<?= $category->id ?>">
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <button type="submit" class="btn btn-primary" id="btnSubmit">Save</button>
                    </div>
                </div>
            </fieldset>
        </form>
    <?php endif; ?>
</div>