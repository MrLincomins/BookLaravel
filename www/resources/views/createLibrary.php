<?php require_once "layout/header.php"; ?>

<div>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание</title>
</head>
<section>
<div id="app">
    <section class="table-components">
        <div class="container text-center border mt-4">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="title mb-30">
                        <h2>Создать библиотеку?</h2>
                    </div>
                </div>
            </div>
            <form method="post" action="/library">
                <button class="btn btn-primary btn-lg" type="submit">Да</button>
            </form>
            <button href="/" type="button" class="btn btn-secondary btn-lg">Нет</button>
        </div>
</div>
</section>
</div>

<?php require_once "layout/footer.php"; ?>

