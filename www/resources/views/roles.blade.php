@extends('layout.layout')

@section('content')
    <body class="app">
    <section class="tab-components" id="app">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Создание роли</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row">
                <form method="post" action="{{ url('/library/roles') }}" class="w-40">
                    @csrf
                    <div class="card-style mb-3">
                        <h6 class="mb-25">Создание роли</h6>
                        <div class="input-style-2">
                            <label>
                                <input type="text" name="name" placeholder="Название">
                            </label>
                            <span class="icon"> <i class="lni lni-information"></i> </span>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="1" name="permissions[]"
                                   id="checkbox-1">
                            <label class="form-check-label" for="checkbox-1">
                                Изменение книг и жанров</label>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="2" name="permissions[]"
                                   id="checkbox-2">
                            <label class="form-check-label" for="checkbox-2">
                                Удаление книг и жанров</label>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="4" name="permissions[]"
                                   id="checkbox-3">
                            <label class="form-check-label" for="checkbox-3">
                                Создание книг и жанров</label>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="8" name="permissions[]"
                                   id="checkbox-4">
                            <label class="form-check-label" for="checkbox-4">
                                Выдача книг ученикам, возврат</label>
                        </div>
                        <div class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" value="16" name="permissions[]"
                                   id="checkbox-5">
                            <label class="form-check-label" for="checkbox-5">
                                Просмотр учеников, управление ими</label>
                        </div>
                        <div>
                            <button type="submit" class="main-btn success-btn-outline square-btn btn-hover">Добавить
                            </button>
                        </div>
                    </div>
                </form>
                <div class="card-style mb-3 w-50">
                    <h6 class="mb-10">Созданные роли</h6>
                    <p class="text-sm mb-20">
                        Здесь показаны ранее созданные роли
                    </p>
                    <div class="table-wrapper table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><h6>Название</h6></th>
                                <th><h6>Права</h6></th>
                                <th>
                                    <h6 class="text-sm text-medium text-end">
                                        Управление <i class="lni lni-arrows-vertical"></i>
                                    </h6>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <p>{{ $role->name }} </p>
                                    </td>
                                    <td>
                                        <div class="action">
                                            <button type="button" data-toggle="modal" data-target="#showModal{{ $role->id }}" data-permissions="{{ $role->permissions }}"
                                                    class="text-dark">
                                                <i class="mdi mdi-cursor-default-click"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action justify-content-end">
                                            <form method="post" action="{{ url('/library/roles/' . $role->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="text-danger" type="submit">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" tabindex="-1" id="showModal{{ $role->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Показ прав</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Название роли: {{ $role->name }}</p>
                                                <p>Права:</p>
                                                <?php
                                                $permissions = [
                                                    1 => 'Изменение книг и жанров',
                                                    2 => 'Удаление книг и жанров',
                                                    4 => 'Создание книг и жанров',
                                                    8 => 'Выдача книг ученикам, возврат',
                                                    16 => 'Просмотр учеников, управление ими',
                                                ];
                                                ?>
                                                @foreach($permissions as $key => $value)
                                                    <p>{{ $value }}: {{ ($role->permissions & $key) === $key ? 'Да' : 'Нет' }}</p>
                                                @endforeach
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
    </section>
    </body>

@endsection

