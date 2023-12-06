<?php require_once "layout/header.php"; ?>
<body class="app">
<section class="tab-components" id="app">
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Создание прав</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row">
                <form method="post" action="/admin/permissions" class="w-40">
                    <div class="card-style mb-3">
                        <h6 class="mb-25">Создание роли</h6>
                        <div class="input-style-2">
                            <label>
                                <input type="text" name="name" placeholder="Название права">
                            </label>
                            <span class="icon"> <i class="lni lni-information"></i> </span>
                        </div>
                        <div>
                            <button type="submit" class="main-btn success-btn-outline square-btn btn-hover">Добавить</button>
                        </div>
                    </div>
                </form>
                <div class="card-style mb-3 w-50">
                    <h6 class="mb-10">Созданные права</h6>
                    <p class="text-sm mb-20">
                        Здесь показаны ранее созданные права
                    </p>
                    <div class="table-wrapper table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><h6>Название</h6></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($permissions as $permission): ?>
                                <tr>
                                    <td>
                                        <p><?= $permission->name ?> </p>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>
</body>

<?php require_once "layout/footer.php"; ?>
