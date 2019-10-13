<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 text-left">
                <h1>Main Page</h1>
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
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <?php if (empty($_SESSION['user'])): ?>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="lead">New User Registration</p>
                    <p><a href="/user/register" class="btn btn-primary btn-lg">Sign Up</a></p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="lead">User Authorization</p>
                    <p><a href="/user/login" class="btn btn-primary btn-lg">Sign In</a></p>
                </div>
            <?php else: ?>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="lead">Categories</p>
                    <p><a href="/category/view" class="btn btn-primary btn-lg">Categories</a></p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p class="lead">Logout</p>
                    <p><a href="/user/logout" class="btn btn-primary btn-lg">Sign Out</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>