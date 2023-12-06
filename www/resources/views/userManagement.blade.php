@extends('layout.layout')

@section('content')

    <body class="app">
    <div id="loader" class="loader"></div>
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
                @php
                    $groupedUsers = [];

                    foreach ($users as $user) {
                    $class = $user->class;
                    if (!isset($groupedUsers[$class])) {
                    $groupedUsers[$class] = [];
                    }
                    $groupedUsers[$class][] = $user;
                    }
                @endphp

                @foreach ($groupedUsers as $class => $usersInClass)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <button class="btn" data-toggle="collapse" data-target="#collapse-{{ $class }}"
                                        aria-expanded="false" aria-controls="collapse-{{ $class }}">
                                    {{ $class }}
                                </button>
                            </h5>
                        </div>

                        <div id="collapse-{{ $class }}" class="collapse" aria-labelledby="heading-{{ $class }}"
                             data-parent="#accordion">
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
                                        @foreach ($usersInClass as $user)
                                            <tr>
                                                <td class="min-width">
                                                    <p>{{ $user->name }}</p>
                                                </td>
                                                <td class="min-width">
                                                    <p>{{ $user->role }}</p>
                                                </td>
                                                <td>
                                                    <div class="action justify-content-end">
                                                        <button type="button" data-toggle="modal"
                                                                data-target="#showModal{{ $user->id }}"
                                                                @click="selectedUserId = {{ $user->id }}">
                                                            <i class="lni lni-user"></i>
                                                        </button>
                                                        <form method="post"
                                                              action="{{ url('/library/users/' . $user->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="text-danger" type="submit">
                                                                <i class="lni lni-trash-can"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" tabindex="-1" id="showModal{{ $user->id }}"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Выбор роли</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="select-style-1">
                                                                <label>Выбор роли пользователя</label>
                                                                <div class="select-position">
                                                                    <select v-model="selectedRole">
                                                                        <option value="">Никакая</option>
                                                                        @foreach ($roles as $role)
                                                                            <option
                                                                                value="{{ $role->id }}">{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Отмена
                                                                    </button>
                                                                    <button type="button" class="btn btn-primary"
                                                                            @click="updateUserRole">Готово
                                                                    </button>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <div class="alert"
                                                                         :class="{ 'alert-success': isSuccess, 'alert-danger': !isSuccess }"
                                                                         v-if="statusMessage">
                                                                        @{{ statusMessage }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    </body>
    <script>
        new Vue({
            el: '#app',
            data: {
                selectedRole: null,
                selectedUserId: null,
                statusMessage: '',
                isSuccess: false
            },
            methods: {
                updateUserRole() {
                    this.showLoader();
                    axios.post('/library/users/', {
                        idUser: this.selectedUserId,
                        idRole: this.selectedRole,

                    })
                        .then(response => {
                            this.hideLoader();
                            if (response.data) {
                                this.showAlert('Роль успешно обновлена', true);
                            } else {
                                this.showAlert('Ошибка при обновлении роли', false);
                            }
                        })
                        .catch(error => {
                            this.hideLoader();
                            this.showAlert('Ошибка при обновлении роли', false);
                            console.error('Ошибка при обновлении роли', error);
                        });
                },
                showLoader() {
                    document.getElementById('loader').style.display = 'block';
                },
                hideLoader() {
                    document.getElementById('loader').style.display = 'none';
                },
                showAlert(message, bool) {
                    this.statusMessage = message;
                    this.isSuccess = bool;

                    setTimeout(() => {
                        this.statusMessage = '';
                        this.isSuccess = false;
                    }, 4000);
                },
            },
        });
    </script>
@endsection

