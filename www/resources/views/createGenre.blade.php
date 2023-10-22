@extends('layout.layout')

@section('content')
    <div class="container px-4" id="app">
        <div id="loader" class="loader"></div>
        <div class="row gx-5">
            <div class="col-5 mt-4">
                <div class="card-style mb-25">
                    <h6 class="mb-25">Добавление жанров</h6>
                    <div class="input-style-1">
                        <label>Название жанра</label>
                        <input v-model="newGenre" type="text" placeholder="Название жанра">
                    </div>
                    <button @click="addGenre" class="main-btn primary-btn btn-hover">Добавить</button>
                    <div v-if="showPopup" class="alert alert-primary mt-2">
                        <p>@{{ popupMessage }}</p>
                    </div>
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
    </div>
    <script>
        new Vue({
            el: '#app',
            data: {
                newGenre: '',
                genres: [],
                showPopup: false,
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
                            if (response.data.status) {
                                this.genres.push({genre: this.newGenre});

                                this.loadGenres();
                                this.newGenre = '';
                                this.showSuccessPopup('Вы успешно добавили жанр');
                            } else {
                                this.showSuccessPopup('Ошибка при добавлении жанра');
                            }
                        })
                        .catch(error => {
                            this.showSuccessPopup('Ошибка при добавлении жанра');
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                deleteGenre(id) {
                    this.showLoader();
                    axios.delete(`/books/genre/${id}`)
                        .then(response => {
                            if (response.data.status) {

                                const index = this.genres.findIndex(genre => genre.id === id);
                                this.genres.splice(index, 1);

                                this.loadGenres();
                                this.showSuccessPopup(response.data.message);
                            } else {
                                this.showSuccessPopup(response.data.message);
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                showSuccessPopup(message) {
                    this.popupMessage = message;
                    this.showPopup = true;

                    setTimeout(() => {
                        this.showPopup = false;
                    }, 3000);
                },
                showLoader() {
                    document.getElementById('loader').style.display = 'block';
                },
                hideLoader() {
                    document.getElementById('loader').style.display = 'none';
                }
            },
            mounted() {
                this.loadGenres();
            }
        });
    </script>
@endsection
