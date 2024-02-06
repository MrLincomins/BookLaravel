@extends('layout.layout')

@section('content')

<div class="container-fluid" id="app">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title d-flex align-items-center flex-wrap mb-30">
                    <h2 class="mr-40">Выдача книги ученику</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/books">books</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                surrender
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="invoice-wrapper">
        <div class="row">
            <div class="col-7">
                <div class="invoice-card card-style mb-6">
                    <div class="invoice-header">
                        <div class="invoice-address">
                            <div class="address-item pt-3">
                                <h1>{{ $book->tittle }}</h1>
                                <p class="text">
                                    <span class="text-medium">Автор:</span>
                                    {{ $book->author }}
                                </p>
                                <p class="text">
                                    <span class="text-medium">Жанр:</span>
                                    {{ $book->genre }}
                                </p>
                                <p class="text">
                                    <span class="text-medium">Год:</span>
                                    {{ $book->year }}
                                </p>
                            </div>
                            <div class="invoice-for">
                            </div>
                            <div class="logo col-14">
                                <img src="{{ $book->picture }}" alt=""/>
                            </div>
                        </div>
                        <div class="form-elements-wrapper">
                            <div class="col-lg-9" style="margin-top: 10%;">
                                <div class="card-style">
                                    <h6 class="mb-25">Введите id ученика</h6>
                                    <div class="input-style-1">
                                        <input v-model="idUser" form="id" type="text" name='iduser' placeholder="id"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-action">
                        <ul class="d-flex flex-wrap align-items-center justify-content-center">
                            <li class="m-2">
                                <a href="/books" class="main-btn primary-btn-outline btn-hover">
                                    Отмена
                                </a>
                            </li>
                            <li class="m-2">
                                <form method="post" id="id" action="/books/surrender/{{ $book->id }}" @submit.prevent="surrender">
                                    @csrf
                                    <button class="main-btn primary-btn btn-hover" type="submit">
                                        Выдать
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
</div>
<script src="/resources/js/loader.js"></script>
<script src="/resources/js/toast.js"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            toasts: [],
            book: @json($book),
            idUser: null,
        },
        methods: {
            surrender() {
                this.showLoader();
                axios.post(`/books/surrender/${this.book.id}`, { iduser: this.idUser })
                    .then(response => {
                        if (response.data.status) {
                            this.showToast(response.data.status, response.data.message)
                        } else if (response.data.redirect) {
                            window.location.href = response.data.redirect;
                        } else {
                            this.showToast('error', 'Неизвестная ошибка при резервации')
                        }
                    })
                    .catch(error => {
                        this.showToast('error', 'Неизвестная ошибка при резервации')
                    })
                    .finally(() => {
                        this.hideLoader();
                    });
            },
        },
    });
</script>
@endsection
