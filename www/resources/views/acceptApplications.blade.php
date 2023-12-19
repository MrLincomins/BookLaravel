@extends('layout.layout')

@section('content')
    <body>
    <div id="loader" class="loader"></div>
    <template id="app">
        <div class="notification-wrapper">
            <div class="container-fluid">
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title mb-30">
                                <h2>Заявки в библиотеку</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-style" v-if="notifications.length > 0">
                    <div class="single-notification" v-for="notification in notifications" :key="notification.id">
                        <div class="notification">
                            <div class="image primary-bg">
                                <span>@{{ getFirstLetter(notification.nameUser) }}</span>
                            </div>
                            <a class="content">
                                <h6>@{{ notification.nameUser }}</h6>
                                <p class="text-sm text-gray">
                                    Класс ученика: @{{ getUserClass(notification.idUser) }}
                                </p>
                                <span
                                    class="text-sm text-medium text-gray ">@{{ calculateTimeAgo(notification.created_at) }}</span>
                            </a>
                        </div>
                        <div class="action">
                            <a @click="acceptApplication(notification.idUser, notification.unique_key, notification.id)" class="main-btn success-btn btn-hover mx-2"><i class="lni lni-checkmark"></i></a>
                            <a @click="deleteApplication(notification.id)" class="main-btn danger-btn btn-hover"><i class="lni lni-close"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
    </body>
    <script>
        new Vue({
            el: '#app',
            data: {
                notifications: [],
                users: [],
            },
            mounted() {
                this.fetchNotifications();
                this.getNotifications();
            },
            methods: {
                fetchNotifications() {
                    this.showLoader();
                    axios
                        .get('/library/entrance/get')
                        .then((response) => {
                            this.hideLoader();
                            this.notifications = response.data['applications'];
                            this.users = response.data['users'];
                        })
                        .catch((error) => {
                            this.hideLoader();
                            console.error(error);
                        });
                },

                getNotifications() {
                    axios
                        .get('/library/entrance/get')
                        .then((response) => {
                            this.notifications = response.data['applications'];
                            this.users = response.data['users'];
                            setTimeout(() => {
                                this.getNotifications();
                            }, 5000);
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                },
                getUserClass(notificationId) {
                    const user = this.users.find(user => user.id === notificationId);
                    return user ? user.class : 'Класс не найден';
                },
                getFirstLetter(name) {
                    return name ? name.charAt(0) : '';
                },
                calculateTimeAgo(createdAt) {
                    if (!createdAt) return '';

                    const currentDate = new Date();
                    const notificationDate = new Date(createdAt);
                    const timeDifference = currentDate - notificationDate;
                    const minutesDifference = Math.floor(timeDifference / 60000);

                    if (minutesDifference < 60) {
                        return `${minutesDifference} минут назад`;
                    } else {
                        const hoursDifference = Math.floor(minutesDifference / 60);
                        if (hoursDifference < 24) {
                            return `${hoursDifference} часов назад`;
                        } else {
                            const daysDifference = Math.floor(hoursDifference / 24);
                            return `${daysDifference} дней назад`;
                        }
                    }
                },
                acceptApplication(idUser, uniqueKey,applicationId ) {
                    this.showLoader();
                    axios.post('/library/entrance', {
                        idUser: idUser,
                        unique_key: uniqueKey,
                        id: applicationId,
                    })
                        .then(response => {
                            this.hideLoader();
                            if (response.data === true) {
                                this.notifications = this.notifications.filter(notification => notification.id !== applicationId);
                            }
                        })
                        .catch(error => {
                            this.hideLoader();
                            console.error(error);
                        });
                },
                deleteApplication(applicationId) {
                    this.showLoader();
                    axios.delete('/library/entrance', {
                        data: {
                            id: applicationId,
                        }
                    })
                        .then(response => {
                            this.hideLoader();
                            if (response.data === true) {
                                this.notifications = this.notifications.filter(notification => notification.id !== applicationId);
                            }
                        })
                        .catch(error => {
                            this.hideLoader();
                            console.error(error);
                        });
                },
                showLoader() {
                    document.getElementById('loader').style.display = 'block';
                },
                hideLoader() {
                    document.getElementById('loader').style.display = 'none';
                },
            }
        });
    </script>
@endsection
