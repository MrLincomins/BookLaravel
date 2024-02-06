const loader = {
    showLoader() {
        document.getElementById('loader').style.display = 'block';
    },
    hideLoader() {
        document.getElementById('loader').style.display = 'none';

    }
};
Vue.mixin({
    methods: loader
});
