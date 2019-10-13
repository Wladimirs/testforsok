<div class="container">
    <h1>Registration Page</h1>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Registration</li>
            </ol>
        </div>
    </div>
    <form action="/user/register" method="post" class="form-horizontal" id="myForm">
        <fieldset>
            <legend>New User Registration</legend>
            <hr>
            <div class="form-group">
                <label for="inputSuccess1" class="col-lg-2 control-label">Login</label>
                <div class="col-lg-10">
                    <input name="login" type="text" class="form-control" id="inputSuccess1"
                           value="<?= isset($_SESSION['form_data']['login']) ?
                               h($_SESSION['form_data']['login']) : '' ?>" placeholder="Login"
                           required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputSuccess2" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-10">
                    <input name="password" type="password" class="form-control" id="inputSuccess1"
                           placeholder="Password" required minlength="6">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <a href="/" class="btn btn-primary btn-small">Back</a>
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Submit</button>
                </div>
            </div>
        </fieldset>
    </form>
    <?php if (isset($_SESSION['form_data'])) {
        unset($_SESSION['form_data']);
    } ?>
</div>