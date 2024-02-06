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
                <div class="w-40">
                    <div class="card-style mb-3">
                        <h6 class="mb-25">Создание роли</h6>
                        <div class="input-style-2">
                            <label>
                                <input type="text" v-model="roleName" placeholder="Название">
                            </label>
                            <span class="icon"> <i class="lni lni-information"></i> </span>
                        </div>
                        <div v-for="(permission, index) in permissions" :key="index"
                             class="form-check form-check-inline checkbox-style checkbox-success mb-20">
                            <input class="form-check-input" type="checkbox" :value="permission.value"
                                   v-model="selectedPermissions" :id="'checkbox-' + permission.value">
                            <label class="form-check-label" :for="'checkbox-' + permission.value">
                                @{{ permission.label }}
                            </label>
                        </div>
                        <div>
                            <button class="main-btn success-btn-outline square-btn btn-hover" @click="addRole">
                                Добавить
                            </button>
                        </div>
                    </div>
                </div>
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
                            <tr v-for="(role, index) in roles" :key="index">
                                <td>
                                    <p>@{{ role.name }} </p>
                                </td>
                                <td>
                                    <div class="action">
                                        <button type="button" @click="showPermissions(role)" class="text-dark">
                                            <i class="mdi mdi-cursor-default-click"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="action justify-content-end">
                                        <button type="button" class="text-danger" @click="deleteRole(role.id)">
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
        <div class="modal fade" tabindex="-1" id="permissionsModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Права роли</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="showModal">
                        <p>Название роли: @{{ selectedRole.name }}</p>
                        <p>Права:</p>
                        <ul>
                            <li v-for="(permission, index) in selectedRolePermissions" :key="index">
                                @{{ permission }}
                            </li>
                        </ul>
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
                roleName: '',
                selectedPermissions: [],
                permissions: [
                    {label: 'Изменение книг и жанров', value: 1},
                    {label: 'Удаление книг и жанров', value: 2},
                    {label: 'Создание книг и жанров', value: 4},
                    {label: 'Выдача книг ученикам, возврат', value: 8},
                    {label: 'Просмотр учеников, управление ими', value: 16}
                ],
                roles: @json($roles),
                toasts: [],
                selectedRole: null,
                selectedRolePermissions: [],
                showModal: false
            },
            methods: {
                loadRoles() {
                    this.showLoader();
                    axios.get('/library/roles/show')
                        .then(response => {
                            this.roles = JSON.parse(response.data.data);
                        })
                        .catch(error => {
                            console.error('Ошибка при загрузке ролей', error);
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                addRole() {
                    this.showLoader();
                    axios.post('/library/roles', {name: this.roleName, permissions: this.selectedPermissions})
                        .then(response => {
                            if (response.data.status === 'success') {
                                this.roles.push({name: this.roleName});
                                this.loadRoles();
                                this.roleName = '';
                                this.selectedPermissions = [];
                            }
                            this.showToast(response.data.status, response.data.message)
                        })
                        .catch(error => {
                            this.showToast('error', 'Ошибка при добавлении роли')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                deleteRole(roleId) {
                    this.showLoader();
                    axios.delete(`/library/roles/${roleId}`)
                        .then(response => {
                            this.showToast(response.data.status, response.data.message)
                            if (response.data.status === 'success') {
                                this.loadRoles();
                            }
                        })
                        .catch(error => {
                            this.showToast('error', 'Ошибка при удалении роли')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                showPermissions: function(role) {
                    this.selectedRole = role;
                    this.selectedRolePermissions = [];

                    this.permissions.forEach(permission => {
                        if ((role.permissions & permission.value) === permission.value) {
                            this.selectedRolePermissions.push(permission.label);
                        }
                    });

                    this.showModal = true;
                    $('#permissionsModal').modal('show');
                }
            },
        });
    </script>
@endsection
