@extends('layout.layout')

@section('content')
    <section class="tab-components" id="app">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="container-fluid">
            <section class="table-components">
                <div class="container-fluid">
                    <div class="title-wrapper pt-30">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="title mb-30">
                                    <h2>Изменить книгу</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-elements-wrapper">
                        <form id="editBookForm" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Поля ввода</h6>
                                        <div class="input-style-2">
                                            <label>Название книги</label>
                                            <input v-model="bookData.tittle" name="tittle" type="text"
                                                   placeholder="Название книги"/>
                                            <span class="icon"> <i class="lni lni-bookmark"></i> </span>
                                        </div>
                                        <div class="input-style-2">
                                            <label>Автор</label>
                                            <input v-model="bookData.author" name="author" type="text"
                                                   placeholder="Автор"/>
                                            <span class="icon"> <i class="lni lni-user"></i> </span>
                                        </div>
                                        <div class="input-style-2">
                                            <label>Год</label>
                                            <input v-model="bookData.year" name="year" type="text" placeholder="Год"/>
                                            <span class="icon"> <i class="lni lni-calendar"></i> </span>
                                        </div>
                                        <div class="select-style-1">
                                            <label>Выбрать жанр</label>
                                            <div class="select-position">
                                                <select v-model="bookData.genre" class="light-bg" name="genre">
                                                    <option v-for="item in genres" :value="item">@{{ item }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-style-2">
                                            <label>ISBN</label>
                                            <input v-model="bookData.isbn" name="isbn" type="text" placeholder="ISBN"/>
                                            <span class="icon"> <i class="lni lni-paperclip"></i> </span>
                                        </div>
                                        <div class="input-style-2">
                                            <label>Число книг</label>
                                            <input v-model="bookData.count" name="count" type="text"
                                                   placeholder="Число книг"/>
                                            <span class="icon"> <i class="lni lni-calculator"></i> </span>
                                        </div>
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button class="main-btn primary-btn btn-hover w-100 text-center"
                                                        type="button" @click="editBook">
                                                    Изменить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    <script src="/resources/js/loader.js"></script>
    <script src="/resources/js/toast.js"></script>
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

        new Vue({
            el: '#app',
            data: {
                bookData: {
                    tittle: '{{ $book->tittle }}',
                    author: '{{ $book->author }}',
                    year: '{{ $book->year }}',
                    genre: '{{ $book->genre }}',
                    isbn: '{{ $book->isbn }}',
                    count: '{{ $book->count }}'
                },
                toasts: [],
                genres: {!! json_encode($genres->pluck('genre')) !!}
            },
            methods: {
                editBook() {
                    this.showLoader();
                    this.bookData.year = parseInt(this.bookData.year);
                    this.bookData.isbn = parseInt(this.bookData.isbn);
                    axios.post(`/books/edit/{{ $book->id }}`, this.bookData)
                        .then(response => {
                            this.showToast(response.data.status, response.data.message)
                            if (response.data.status === 'success') {
                                setTimeout(function () {
                                    window.location.href = '/books';
                                }, 5000);
                            }
                        })
                        .catch(error => {
                            this.showToast('error', 'Ошибка при изменении книги')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                }
            }
        });
    </script>
@endsection
