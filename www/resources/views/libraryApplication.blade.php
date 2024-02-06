@extends('layout.layout')

@section('content')
    <body>
    <div id="loader" class="loader"></div>
    <section class="tab-components" id="app">
        <div class="container-fluid">
            <section class="table-components">
                <div class="container-fluid">
                    <div class="title-wrapper pt-30">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="title mb-30">
                                    <h2>Подача заявки в библиотеку</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-elements-wrapper">
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Введите код библиотеки</h6>
                                        <div class="input-style-2">
                                            <input v-model="unique_key" type="text" placeholder="Код"/>
                                            <span class="icon"> <i class="lni lni-calendar"></i> </span>
                                        </div>
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button class="main-btn primary-btn btn-hover w-100 text-center"
                                                        @click.prevent="searchLibrary">
                                                    Отправить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal fade" tabindex="-1" id="confirmationModal" aria-hidden="true" ref="modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Подтверждение</h5>
                                </div>
                                <div class="modal-body">
                                    <template v-if="showModal">
                                        <h4>Это ваша библиотека?</h4>
                                        <p>Название библиотеки: @{{ libraryData.libraryName }}</p>
                                        <p>Организация: @{{ libraryData.organisation }}</p>
                                        <p>Описание: @{{ libraryData.description }}</p>
                                    </template>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            @click="showModal = false, libraryData = null">
                                        Нет
                                    </button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            @click="confirmLibrary" >
                                        Да
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
    </body>
    <script src="/resources/js/loader.js"></script>
    <script src="/resources/js/toast.js"></script>

    <script>
        new Vue({
            el: '#app',
            data: {
                unique_key: '',
                libraryData: null,
                showModal: false,
                toasts: []

            },
            methods: {
                searchLibrary() {
                    this.showLoader();

                    axios.post('/library/get', {unique_key: this.unique_key})
                        .then(response => {
                            if (response.data.status === 'success') {
                                this.libraryData = response.data.library;
                                this.showModal = true;
                            } else {
                                this.showToast(response.data.status, response.data.message)
                            }
                        })
                        .catch(error => {
                            this.showToast('error', 'Ошибка при поиске библиотеки!')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                confirmLibrary() {
                    this.showModal = false
                    this.showLoader();
                    axios.post('/library/application', {code: this.unique_key})
                        .then(response => {
                            this.showToast(response.data.status, response.data.message)
                        })
                        .catch(error => {
                            this.showToast('error', 'Ошибка при отправке заявки!')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
            },
            watch: {
                showModal(val) {
                    $(this.$refs.modal).modal(val ? 'show' : 'hide');
                },
            },
        });
    </script>

@endsection
