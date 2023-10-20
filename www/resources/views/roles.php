<?php require_once "layout/header.php"; ?>
<body class="app">
<section class="tab-components" id="app">
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Создание роли</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row">
                <form method="post" action="/library/roles" class="w-40">
                    <div class="card-style mb-3">
                        <h6 class="mb-25">Создание роли</h6>
                        <div class="input-style-2">
                            <label>
                                <input type="text" name="name" placeholder="Название">
                            </label>
                            <span class="icon"> <i class="lni lni-information"></i> </span>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="1" name="permissions[]" id="checkbox-1">
                            <label class="form-check-label" for="checkbox-1">
                                Изменение книг и жанров</label>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="2" name="permissions[]" id="checkbox-2">
                            <label class="form-check-label" for="checkbox-2">
                                Удаление книг и жанров</label>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="4" name="permissions[]" id="checkbox-3">
                            <label class="form-check-label" for="checkbox-3">
                                Создание книг и жанров</label>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="8" name="permissions[]" id="checkbox-4">
                            <label class="form-check-label" for="checkbox-4">
                                Выдача книг ученикам, возврат</label>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="16" name="permissions[]" id="checkbox-5">
                            <label class="form-check-label" for="checkbox-5">
                                Доступ к админ панели</label>
                        </div>
                        <div>
                            <button type="submit" class="main-btn success-btn-outline square-btn btn-hover">Добавить</button>
                        </div>
                    </div>
                </form>
                <div class="card-style mb-3 w-50">
                    <h6 class="mb-10">Созданные роли</h6>
                    <p class="text-sm mb-20">
                        Здесь показаны ранее созданные роли
                    </p>
                    <div class="table-wrapper table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><h6>Название</h6></th>
                                <th><h6>Права</h6></th>
                                <th>
                                    <h6 class="text-sm text-medium text-end">
                                        Управление <i class="lni lni-arrows-vertical"></i>
                                    </h6>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($roles as $role): ?>
                                <tr>
                                    <td>
                                        <p><?php echo $role->name ?> </p>
                                    </td>
                                    <td>
                                        <p><?php echo $role->permissions ?> </p>
                                    </td>
                                    <td>
                                        <div class="action justify-content-end">
                                            <form method="post" action="library/role/delete/<?php echo $role->id; ?>">
                                                <button class="text-danger" type="submit">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
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
