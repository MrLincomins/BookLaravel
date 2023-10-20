<?php require_once "layout/header.php"; ?>

<body class="app">
<section class="tab-components" id="app">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Управление пользователями</h2>
                    </div>
                </div>
            </div>
        </div>
        <div id="accordion">
            <?php
            $groupedUsers = [];

            foreach ($users as $user) {
                $class = $user->class;
                if (!isset($groupedUsers[$class])) {
                    $groupedUsers[$class] = [];
                }
                $groupedUsers[$class][] = $user;
            }

            // Выводим пользователей в соответствующие Collapse
            foreach ($groupedUsers as $class => $usersInClass) {
                ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <button class="btn" data-toggle="collapse" data-target="#collapse-<?php echo $class; ?>"
                                    aria-expanded="false" aria-controls="collapse-<?php echo $class; ?>">
                                <?php echo $class; ?>
                            </button>
                        </h5>
                    </div>

                    <div id="collapse-<?php echo $class; ?>" class="collapse" aria-labelledby="heading-<?php echo $class; ?>" data-parent="#accordion">
                        <div class="card-style">
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th><h6>Имя</h6></th>
                                        <th><h6>Роль</h6></th>
                                        <th>
                                            <h6 class="text-sm text-medium text-end">
                                                Управление <i class="lni lni-arrows-vertical"></i>
                                            </h6>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($usersInClass as $user) { ?>
                                        <tr>
                                            <td class="min-width">
                                                <p><?php echo $user->name; ?></p>
                                            </td>
                                            <td class="min-width">
                                                <p><?php echo $user->role; ?></p>
                                            </td>
                                            <td>
                                                <div class="action justify-content-end">
                                                    <form method="post" action="/library/users/<?php echo $user->id; ?>">
                                                        <button class="text-danger" type="submit">
                                                            <i class="lni lni-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
</body>

<?php require_once "layout/footer.php"; ?>
