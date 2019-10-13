<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
            <h1>Category Page</h1>
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
                <li class="breadcrumb-item active">Category</li>
            </ol>
        </div>
    </div>
    <nav class="nav">
        <a class="nav-link btn btn-primary" href="/category/edit?id=<?= $category['id'] ?>">Edit</a>
        <a class="nav-link btn btn-danger" href="/category/delete?id=<?= $category['id'] ?>">Delete</a>
    </nav>
    <table class="table table-hover">
        <thead>
        <tr>
            <th style="width: 15%">Category Name</th>
            <th style="width: 85%">Category Text</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($category)): ?>
            <tr>
                <td><?= h($category['name']) ?></td>
                <td><?= h($category['text']) ?></td>
            </tr>
        <?php else: ?>
            <tr>
                <td>Empty</td>
                <td>Empty</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <p><a href="/category/view" class="btn btn-primary">Back</a></p>
</div>