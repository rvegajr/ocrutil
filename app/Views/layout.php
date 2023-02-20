<!doctype html>
<?php
$url = strtolower((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$urlenv='prod';
if ((str_contains($url, ':8889')) || (str_contains($url, ':8890'))) {
    $urlenv = 'local';
} else if (str_contains($url, 'dev')) {
    $urlenv = 'dev';
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>ABCT - <?= $this->renderSection('title') ?></title>
    <style>
        h5.card-title {
            text-align: center;
            font-size: 30px;
            margin-bottom: 10px;
        }
        h5.mb-5 {
            margin-bottom: 10px!important;
        }
    </style>
    <!-- Bootstrap core CSS -->
    <link href="<?=base_url("resources/packages/bootstrap-5.2.3-dist/css/bootstrap.min.css");?>" rel="stylesheet">
    <link href="<?=base_url("resources/css/ui/ui.base.css");?>" rel="stylesheet" media="all">
    <?php if ($urlenv=="local") { ?>
        <link href="<?=base_url("resources/css/local.css");?>" rel="stylesheet" type="text/css" />
    <?php } else if ($urlenv=="dev") { ?>
        <link href="<?=base_url("resources/css/dev.css");?>" rel="stylesheet" type="text/css" />
    <?php } ?>

</head>

<body">
    <main role="main" class="container">
        <?= $this->renderSection('main') ?>
    </main>

<?= $this->renderSection('pageScripts') ?>
</body>
</html>
