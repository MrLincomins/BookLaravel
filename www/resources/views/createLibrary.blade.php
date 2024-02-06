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
                                    <h2>Создание библиотеки</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-elements-wrapper">
                        <form action="/library" method="POST" enctype="multipart/form-data" @submit.prevent="createLibrary">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Поля ввода</h6>
                                        <div class="input-style-2">
                                            <label>Название библиотеки</label>
                                            <input v-model="libraryData.name" name="name" type="text" placeholder="Название библиотеки"/>
                                            <span class="icon"> <i class="lni lni-key"></i> </span>
                                        </div>
                                        <div class="input-style-1">
                                            <label>Описание библиотеки</label>
                                            <textarea v-model="libraryData.description" name="description" maxlength="500" placeholder="описание" rows="5"></textarea>
                                        </div>
                                        <div class="input-style-2">
                                            <label>Школа/Организация</label>
                                            <input v-model="libraryData.organisation" name="organisation" type="text" placeholder="Название школы/организации"/>
                                            <span class="icon"> <i class="lni lni-key"></i> </span>
                                        </div>
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button class="main-btn primary-btn btn-hover w-100 text-center"
                                                        type="submit">
                                                    Создать
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
                libraryData: {!! json_encode(['name' => '', 'description' => '', 'organisation' => '']) !!}
            },
            methods: {
                createLibrary() {
                    this.showLoader();
                    axios.post(`/library`, this.libraryData)
                        .then(response => {
                            if (response.data.status === 'error') {
                                this.showToast(response.data.status, response.data.message)
                            } else if (response.data.redirect) {
                                window.location.href = response.data.redirect;
                            } else {
                                this.showToast('error', 'Неизвестная ошибка при создании библиотеки')
                            }
                        })
                        .catch(error => {
                            this.showToast('error', 'Неизвестная ошибка при создании библиотеки')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
            },
        });
    </script>
@endsection

