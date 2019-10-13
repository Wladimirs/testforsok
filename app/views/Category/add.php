<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
            <h1>Category Add Page</h1>
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
                <li class="breadcrumb-item active">Category Add</li>
            </ol>
        </div>
    </div>
    <form action="/category/add" method="post" class="form-horizontal" id="myForm">
        <fieldset>
            <legend>Category Add</legend>
            <hr>
            <div class="form-group">
                <label class="form-control-label" for="inputSuccess1">Category Name</label>
                <input type="text" name="name" class="form-control"
                       id="inputSuccess1" value="<?= isset($_SESSION['form_data']['name']) ?
                    h($_SESSION['form_data']['name']) : '' ?>" placeholder="Category Name" required>
            </div>
            <div class="form-group">
                <label for="inputSuccess2">Category Text</label>
                <textarea class="form-control" name="text" id="inputSuccess2" rows="3"
                          value="<?= isset($_SESSION['form_data']['text']) ?
                              h($_SESSION['form_data']['text']) : '' ?>" required></textarea>
            </div>
            <div class="form-group">
                <select class="custom-select" name="parent_id">
                    <option value="0">Parent Category</option>
                    <?= $html ?>
                </select>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <a href="/category/view" class="btn btn-primary btn-small">Back</a>
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Save</button>
                </div>
            </div>
        </fieldset>
    </form>
    <?php if (isset($_SESSION['form_data'])) {
        unset($_SESSION['form_data']);
    } ?>
</div>