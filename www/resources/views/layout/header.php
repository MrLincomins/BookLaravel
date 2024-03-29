<?php

use Illuminate\Support\Facades\Auth;
use App\Services\PermissionService;

$permissions = [
    'CHANGE_BOOKS' => 1,
    'DELETE_BOOKS' => 2,
    'CREATE_BOOKS' => 4,
    'ISSUE_RETURN_BOOKS' => 8,
    'MANAGE_USERS' => 16,
];
//Потом это всё менять буду
$user = Auth::user();
$permission = new PermissionService();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link
        rel="shortcut icon"
        type="image/x-icon"
    />
    <title>библиотека</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="/resources/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/resources/css/lineicons.css"/>
    <link rel="stylesheet" href="/resources/css/materialdesignicons.min.css"/>
    <link rel="stylesheet" href="/resources/css/fullcalendar.css"/>
    <link rel="stylesheet" href="/resources/css/fullcalendar.css"/>
    <link rel="stylesheet" href="/resources/css/main.css"/>
    <link rel="stylesheet" href="/resources/css/flud.css"/>
</head>
<body>
<!-- ======== sidebar-nav start =========== -->
<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="/">
            <img class="logo" src="/resources/images/logo.png" width="180" height="40"/>
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item nav-item-has-children">
                <a
                    href="#0"
                    data-bs-toggle="collapse"
                    data-bs-target="#ddmenu_1"
                    aria-controls="ddmenu_1"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
              <span class="icon">
                    <i class="lni lni-github-original"></i>
              </span>
                    <span class="text">GitHub</span>
                </a>
                <ul id="ddmenu_1" class="collapse show dropdown-nav">
                    <li>
                        <a href="https://github.com/MrLincomins/Book" target="_blank" class="active"> Ссылка на гит </a>
                    </li>
                </ul>
            </li>
            <?php if (!empty(@$user->unique_key)) { ?>
                <li class="nav-item nav-item-has-children">
                    <a
                        href="#0"
                        class="collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#ddmenu_2"
                        aria-controls="ddmenu_2"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
              <span class="icon">
                  <i class="mdi mdi-book"></i>
              </span>
                        <span class="text">Книги</span>
                    </a>
                    <ul id="ddmenu_2" class="collapse dropdown-nav">
                        <li>
                            <a href="/books"> Все книги </a>
                        </li>
                        <li>
                            <a href="/books/year"> Поиск по году </a>
                        </li>
                        <?php if (@$user->status == 1 || $permission->hasPermission($permissions['CREATE_BOOKS'])) { ?>
                            <li>
                                <a href="/books/create"> Добавить книгу </a>
                            </li>
                            <li>
                                <a href="/books/genre"> Добавить жанр </a>
                            </li>
                        <?php } ?>
                        <?php if (@$user->status == 1 || $permission->hasPermission($permissions['ISSUE_RETURN_BOOKS'])) { ?>
                            <li>
                                <a href="/books/surrender"> Выданные книги </a>
                            </li>
                            <li>
                                <a href="/books/reserve"> Резервированные книги </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <?php if (@$user->status) { ?>
                <li class="nav-item nav-item-has-children">
                    <a
                        href="#0"
                        class="collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#ddmenu_6"
                        aria-controls="ddmenu_6"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
              <span class="icon">
                  <i class="mdi mdi-account-circle"></i>
              </span>
                        <span class="text">Пользователь</span>
                    </a>
                    <ul id="ddmenu_6" class="collapse dropdown-nav">
                        <li>
                            <a href="/account"> Аккаунт </a>
                        </li>
                        <?php if ($permission->hasPermission($permissions['MANAGE_USERS'])) { ?>
                            <li>
                                <a href="/library/users">Управление учениками</a>
                            </li>
                        <?php } ?>
                        <?php if (!@$user->unique_key && @$user->status != 1) { ?>
                            <li>
                                <a href="/library/application">Подать заявку в библиотеку</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <li class="nav-item nav-item-has-children">
                <a
                    href="#0"
                    class="collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#ddmenu_3"
                    aria-controls="ddmenu_3"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
              <span class="icon">
                <svg
                    width="22"
                    height="22"
                    viewBox="0 0 22 22"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                      d="M12.9067 14.2908L15.2808 11.9167H6.41667V10.0833H15.2808L12.9067 7.70917L14.2083 6.41667L18.7917 11L14.2083 15.5833L12.9067 14.2908ZM17.4167 2.75C17.9029 2.75 18.3692 2.94315 18.713 3.28697C19.0568 3.63079 19.25 4.0971 19.25 4.58333V8.86417L17.4167 7.03083V4.58333H4.58333V17.4167H17.4167V14.9692L19.25 13.1358V17.4167C19.25 17.9029 19.0568 18.3692 18.713 18.713C18.3692 19.0568 17.9029 19.25 17.4167 19.25H4.58333C3.56583 19.25 2.75 18.425 2.75 17.4167V4.58333C2.75 3.56583 3.56583 2.75 4.58333 2.75H17.4167Z"
                  />
                </svg>
              </span>
                    <span class="text">Авторизация</span>
                </a>
                <ul id="ddmenu_3" class="collapse dropdown-nav">
                    <?php if (empty(@$user->status)) { ?>
                        <li>
                            <a href="/login"> Войти </a>
                        </li>
                        <li>
                            <a href="/register"> Регистрация </a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($user->status)) { ?>
                        <li>
                            <a href="/logout"> Выход из аккаунта </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <?php if (@$user->status == 2 and @$user->unique_key) { ?>
                <li class="nav-item nav-item-has-children">
                    <a
                        href="#0"
                        class="collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#ddmenu_10"
                        aria-controls="ddmenu_10"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
              <span class="icon">
                  <i class="mdi mdi-cog"></i>
              </span>
                        <span class="text">Библиотека</span>
                    </a>
                    <ul id="ddmenu_10" class="collapse dropdown-nav">
                        <li>
                            <a href="/library/exit">Выход из библиотеки</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>

            <?php if (@$user->status == 1) { ?>
                <li class="nav-item nav-item-has-children">
                    <a
                        href="#0"
                        class="collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#ddmenu_9"
                        aria-controls="ddmenu_9"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
              <span class="icon">
                  <i class="mdi mdi-cog"></i>
              </span>
                        <span class="text">Панель библиотекаря</span>
                    </a>
                    <ul id="ddmenu_9" class="collapse dropdown-nav">
                        <?php if (@$user->unique_key) { ?>
                            <li>
                                <a href="/library/entrance">Поданные заявки в библиотеку</a>
                            </li>
                            <li>
                                <a href="/library/roles">Создание и просмотр ролей</a>
                            </li>
                            <li>
                                <a href="/library/logs">История изменений в библиотеке</a>
                            </li>
                            <li>
                                <a href="/library/users">Управление учениками</a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="/library">Создать библиотеку</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>


            <span class="divider"><hr/></span>


            <span class="divider"><hr/></span>

            <li class="nav-item">
                <a href="https://edu.tatar.ru/nsav/page2300.htm">
              <span class="icon">
                  <i class="lni lni-school-bench"></i>
              </span>
                    <span class="text">Ссылка на школу</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<main class="main-wrapper">
    <!-- ========== header start ========== -->
    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-6">
                    <div class="header-left d-flex align-items-center">
                        <div class="menu-toggle-btn mr-20">
                            <button
                                id="menu-toggle"
                                class="main-btn primary-btn btn-hover"
                            >
                                <i class="lni lni-chevron-left me-2"></i> Меню
                            </button>
                        </div>
                        <div class="header-search d-none d-md-flex">
                            <form method="GET" action="/books/search">
                                <input name="tittle" type="text" placeholder="Поиск книг..."/>
                                <button><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-6">
                    <div class="header-right">
                        <!-- notification start -->
                        <div class="notification-box ml-15 d-none d-md-flex">
                            <?php
                            $notification = \App\Models\Notification::where('user_id', Auth::id())->where('read', 0)->orderBy('created_at', 'desc')->first();
                            if (!$notification) {
                                $notification = \App\Models\Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
                            }
                            ?>
                            <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="lni lni-alarm"></i>
                                <?php if (@$notification->read == 0 && $notification): ?>
                                    <span>1</span>
                                <?php endif; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                                <?php if($notification): ?>
                                    <li>
                                        <a href="/notifications" id="notification-link-<?= @$notification->id ?>" data-read="<?= @$notification->read ?>">
                                            <div class="image">
                                                <img src="/resources/images/149452.png" alt="">
                                            </div>
                                            <div class="content">
                                                <h6 class="mr-2"><?= @$notification->sender ?><span
                                                        class="text-regular"><?= @$notification->event_name ?></span></h6>
                                                <p>
                                                    <?= @$notification->message ?>
                                                </p>
                                                <span><?= @$notification->updated_at ?></span>
                                            </div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="profile-box ml-15">
                            <button
                                class="dropdown-toggle bg-transparent border-0"
                                type="button"
                                id="profile"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <div class="profile-info">
                                    <div class="info">
                                        <?php if (!empty(@$user->name)): ?>
                                            <h6><?php echo @$user->name ?></h6>
                                        <?php else: ?>
                                            <h6>Пользователь</h6>
                                        <?php endif; ?>
                                        <div class="image">
                                            <img
                                                src="/resources/images/149452.png"
                                            />
                                            <span class="status"></span>
                                        </div>
                                    </div>
                                </div>
                                <i class="lni lni-chevron-down"></i>
                            </button>
                            <ul
                                class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="profile"
                            >
                                <?php if (!empty(@$user->name)) { ?>
                                    <li>
                                        <a href="/account">
                                            <i class="lni lni-user"></i> Профиль
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/logout"> <i class="lni lni-exit"></i> Выход </a>
                                    </li>
                                <?php } else { ?>
                                    <li>
                                        <a href="/login"> <i class="lni lni-exit"></i> Вход </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <!-- profile end -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div id="loader" class="loader">
        <div class="spinner"></div>
    </div>

    <div class="overlay"></div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.8"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        const notificationButton = document.querySelector('#notification');
        notificationButton.addEventListener('shown.bs.dropdown', (event) => {
            markAsRead(<?= @$notification->id ?>);
        });

        function markAsRead(notificationId) {
            const notificationLink = document.getElementById(`notification-link-${notificationId}`);
            if (notificationLink.dataset.read === "0") {

                axios.put(`/notifications/${notificationId}`)
                    .then(response => {
                        if (response.data) {
                            const notificationIndicator = document.querySelector('#notification span');
                            if (notificationIndicator) {
                                notificationIndicator.style.display = 'none';
                            }
                        } else {
                            console.error('Не удалось отметить уведомление как прочитанное');
                        }
                    })
                    .catch(error => {
                        console.error('Произошла ошибка при отметке уведомления как прочитанного', error);
                    });
            }
        }
    </script>
