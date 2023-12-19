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
                                        <input v-model="unique_key" type="text" placeholder="Код" />
                                        <span class="icon"> <i class="lni lni-calendar"></i> </span>
                                    </div>
                                    <div class="col-12">
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button class="main-btn primary-btn btn-hover w-100 text-center" @click.prevent="submitForm" data-toggle="modal" data-target="#confirmationModal">
                                                Отправить
                                            </button>
                                        </div>
                                    </div>
                                    <div :class="alertClass" class="mt-4" role="alert" v-if="showAlert">
                                        @{{ alertMessage }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal fade" tabindex="-1" id="confirmationModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Подтверждение</h5>
                            </div>
                            <div class="modal-body">
                                <template v-if="showConfirmationModal">
                                    <h4>Это ваша библиотека?</h4>
                                    <p>Название библиотеки: @{{ libraryData.libraryName }}</p>
                                    <p>Организация: @{{ libraryData.organisation }}</p>
                                    <p>Описание: @{{ libraryData.description }}</p>
                                </template>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="showConfirmationModal = false, libraryData = null">
                                    Нет
                                </button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="confirmLibrary">
                                    Да
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
</body>
<script>
    new Vue({
        el: '#app',
        data: {
            unique_key: '',
            libraryData: null,
            showConfirmationModal: false,
            showAlert: false
        },
        methods: {
            submitForm() {
                this.showLoader();

                axios.post('/library/get', { unique_key: this.unique_key })
                    .then(response => {
                        this.hideLoader();

                            if (response.data === false) {
                                this.scheduleAlert(7000, "Такой библиотеки нет", "alert alert-danger");
                            } else {
                                this.showConfirmationModal = true;
                                this.libraryData = response.data;
                            }
                    })
                    .catch(error => {
                        console.error(error);

                        this.hideLoader();
                    });
            },

            confirmLibrary() {
                this.showLoader();

                axios.post('/library/application', { code: this.unique_key })
                    .then(response => {
                        this.hideLoader();

                        if(response.data === false){
                            this.scheduleAlert(7000, "Произошла ошибка", "alert alert-danger");
                        } else {
                            this.scheduleAlert(7000, "Заявка успешно отправлена", "alert alert-success");
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        this.hideLoader();
                    });
            },
            scheduleAlert(delay, message, alertClass) {
                this.showAlert = true;
                this.alertMessage = message;
                this.alertClass = alertClass;

                setTimeout(() => {
                    this.showAlert = false;
                }, delay);
            },
            showLoader() {
                document.getElementById('loader').style.display = 'block';
            },
            hideLoader() {
                document.getElementById('loader').style.display = 'none';
            },

        },
    });
</script>

@endsection
