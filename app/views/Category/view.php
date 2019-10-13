<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 text-left">
            <h1>Categories Page</h1>
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
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1">
            <p><a href="/category/add" class="btn btn-primary">Add</a></p>
        </div>
    </div>
    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>Category Name</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($html)): ?>
            <tr>
                <td>
                    <ul class="list-group list-group-flush">
                        <?= $html ?>
                    </ul>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td>Not categories</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="/" class="btn btn-primary btn-small">Back</a>
</div>