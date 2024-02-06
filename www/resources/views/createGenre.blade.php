@extends('layout.layout')

@section('content')
    <div class="container px-4" id="app">
        <div class="row gx-5">
            <div class="col-5 mt-4">
                <div class="card-style mb-25">
                    <h6 class="mb-25">Добавление жанров</h6>
                    <div class="input-style-1">
                        <label>Название жанра</label>
                        <input v-model="newGenre" type="text" placeholder="Название жанра">
                    </div>
                    <button @click="addGenre" class="main-btn primary-btn btn-hover">Добавить</button>
                </div>
            </div>
            <div class="col-lg-6 mt-4">
                <div class="card-style mb-30">
                    <h6 class="mb-10">Жанры</h6>
                    <p class="text-sm mb-20">
                        Здесь показаны жанры, которые добавлены в библиотеку
                    </p>
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                            <tr>
                                <th><h6>Название</h6></th>
                                <th class="action justify-content-end"><h6>Action</h6></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="genre in genres">
                                <td>
                                    @{{ genre.genre }}
                                </td>
                                <td>
                                    <div class="action justify-content-end">
                                        <button @click="deleteGenre(genre.id)" class="text-danger">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                newGenre: '',
                genres: @json($genres),
                toasts: []
            },
            methods: {
                loadGenres() {
                    this.showLoader();
                    axios.get('/books/genre/show')
                        .then(response => {
                            this.genres = JSON.parse(response.data.data);
                        })
                        .catch(error => {
                            console.error('Ошибка при загрузке жанров', error);
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                addGenre() {
                    this.showLoader();
                    axios.post('/books/genre', {genre: this.newGenre})
                        .then(response => {
                            if(response.data.status === 'success') {
                                this.genres.push({genre: this.newGenre});
                                this.loadGenres();
                                this.newGenre = '';
                            }

                            this.showToast(response.data.status, response.data.message)
                        })
                        .catch(error => {
                            this.showToast('error', 'Ошибка при добавлении жанра')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                deleteGenre(id) {
                    this.showLoader();
                    axios.delete(`/books/genre/${id}`)
                        .then(response => {
                            if(response.data.status === 'success') {
                                const index = this.genres.findIndex(genre => genre.id === id);
                                this.genres.splice(index, 1);
                                this.loadGenres();
                            }
                            this.showToast(response.data.status, response.data.message)
                        })
                        .catch(error => {
                            this.showToast('error', 'Ошибка при удалении жанра')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
            },
        });
    </script>
@endsection
