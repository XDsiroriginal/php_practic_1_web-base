<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="display-1 fw-bold text-primary">403</h1>
            <h2 class="h4 mb-3">Отказ в доступе</h2>
            <p class="text-muted mb-4">
                У вас недостаточно прав для просмотра этой страницы.
            </p>
            <a href="<?= app()->route->getUrl('/hello') ?>" class="btn btn-primary">На главную</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>