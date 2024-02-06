const showAlert = {
    showAlert(message, bool) {
        this.statusMessage = message;
        this.isSuccess = bool;

        setTimeout(() => {
            this.statusMessage = '';
            this.isSuccess = false;
        }, 4000);
    }
};
Vue.mixin({
    methods: showAlert
});
