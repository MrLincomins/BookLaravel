@extends('layout.layout')

@section('content')
    <body>
    <section class="tab-components" id="app">
        <div class="container-fluid offset-md-1">
            <section class="table-components">
                <div class="container-fluid">
                    <div class="title-wrapper pt-30">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="title mb-30">
                                    <h2>Регистрация</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-elements-wrapper">
                        <form action="/register" method="POST" @submit.prevent="register">
                            @csrf
                            <div class="row">
                                <div class="col-lg-10">
                                    <!-- input style start -->
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Поля ввода</h6>
                                        <div class="input-style-2">
                                            <label>ФИО</label>
                                            <input v-model="userData.name" name="name" type="text" placeholder="ФИО"/>
                                            <span class="icon"> <i class="lni lni-user"></i>
                                        </div>
                                        <!-- end input -->
                                        <div class="input-style-2">
                                            <label>Класс</label>
                                            <input v-model="userData.class" name="class" type="text"
                                                   placeholder="Класс"/>
                                            <span class="icon"> <i class="lni lni-briefcase"></i> </span>
                                        </div>
                                        <!-- end input -->
                                        <div class="select-style-1">
                                            <label>Выберите статус</label>
                                            <div class="select-position">
                                                <select class="light-bg" name="status" v-model="userData.status">
                                                    <option value="2">Ученик</option>
                                                    <option value="1">Библиотекарь</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- end input -->
                                        <div class="input-style-2">
                                            <label>Пароль</label>
                                            <input v-model="userData.password" name="password" type="password"
                                                   placeholder="Пароль"/>
                                            <span class="icon"> <i class="lni lni-key"></i> </span>
                                        </div>
                                        <!-- end input -->
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button class="main-btn primary-btn btn-hover w-100 text-center"
                                                        type="submit">
                                                    Добавить
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end button -->
                                    </div>
                                    <p align="center">Уже есть аккаунт? <a href="/login" class="btn-registration">Авторизация</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="toasts">
                    <div v-for="(toast, index) in toasts" :key="index" class="toast-notification"
                         :class="'toast-' + (index + 1) + ' toast-notification ' + toast.animation">
                        <div class="toast-content">
                            <div class="toast-icon" :style="{ 'background-color': toast.iconColor }">
                                <i class="fas" :class="toast.icon"></i>
                            </div>
                            <div class="toast-msg">@{{ toast.message }}</div>
                        </div>
                        <div class="toast-progress">
                            <div class="toast-progress-bar" :style="{ width: '100%' }"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    </body>
    <script src="/resources/js/loader.js"></script>
    <script src="/resources/js/toast.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                toasts: [],
                userData: {!! json_encode(['name' => '', 'class' => '', 'status' => '', 'password' => '']) !!}
            },
            methods: {
                register() {
                    this.showLoader();
                    axios.post(`/register`, this.userData)
                        .then(response => {
                            if (response.data.status === 'error') {
                                this.showToast(response.data.status, response.data.message)
                            } else if (response.data.redirect) {
                                window.location.href = response.data.redirect;
                            } else {
                                this.showToast('error', 'Неизвестная ошибка при регистрации')
                            }
                        })
                        .catch(error => {
                            this.showToast('error', 'Неизвестная ошибка при регистрации')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
            },
        });
    </script>
@endsection

