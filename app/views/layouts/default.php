<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/public/assets/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/public/assets/css/custom.min.css">
    <?= $this->getMeta(); ?>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $content; ?>

<!--Display all queries RedBeanPHP-->
<?php
/*$logs = \R::getDatabaseAdapter()
    ->getDatabase()
    ->getLogger();

debug($logs->grep('SELECT'));*/
?>

<script src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/public/assets/js/jquery.min.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/public/assets/js/popper.min.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/public/assets/js/bootstrap.min.js"></script>
<script src="<?php $_SERVER['DOCUMENT_ROOT'] ?>/public/assets/js/custom.js"></script>
<script>
    $("#btnSubmit").click(function (event) {

        // Fetch form to apply custom Bootstrap validation
        var form = $("#myForm")

        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }

        form.addClass('was-validated');

    });
</script>
</body>
</html>