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
                                                                data-target="#booksModal{{ $user->id }}">
                                                            <i class="lni lni-calendar"></i>
                                                        </button>
                                                        <button type="button" data-toggle="modal"
                                                                data-target="#showModal{{ $user->id }}"
                                                                @click="selectedUserId = {{ $user->id }}, showModal = true">
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
                                            <div class="modal fade" tabindex="-1" ref="modal"
                                                 id="showModal{{ $user->id }}"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Выбор роли</h5>
                                                            <div class="action">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                    <span @click="showModal = false" aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
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
                                                                            @click="showModal = false"
                                                                            data-dismiss="modal">Отмена
                                                                    </button>
                                                                    <button type="button" class="btn btn-primary"
                                                                            data-dismiss="modal" @click="updateUserRole">Готово
                                                                    </button>
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
                    @foreach($usersInClass as $user)
                        <div class="modal fade" tabindex="-1" id="booksModal{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Взятые книги: {{ $user->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="text-sm text-medium">Название</th>
                                                <th class="text-sm text-medium">Автор</th>
                                                <th class="text-sm text-medium">Дата выдачи</th>
                                                <th class="text-sm text-medium">Статус</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($user->userBooks as $surrender)
                                                <tr>
                                                    <td>{{ $surrender->book->tittle }}</td>
                                                    <td>{{ $surrender->book->author }}</td>
                                                    <td>{{ $surrender->created_at }}</td>
                                                    <td>@php if($surrender->status){ echo 'У пользователя';} else { echo 'Возвращена';} @endphp</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
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
    </section>
    </body>
    <script src="/resources/js/loader.js"></script>
    <script src="/resources/js/toast.js"></script>

    <script>
        new Vue({
            el: '#app',
            data: {
                selectedRole: null,
                selectedUserId: null,
                showModal: false,
                toasts: []
            },
            methods: {
                updateUserRole() {
                    this.showModal = false
                    this.showLoader();
                    axios.post('/library/users/', {
                        idUser: this.selectedUserId,
                        idRole: this.selectedRole,

                    })
                        .then(response => {
                            this.showToast(response.data.status, response.data.message)
                        })
                        .catch(error => {
                            this.showToast('error', 'Ошибка при обновлении роли')
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

