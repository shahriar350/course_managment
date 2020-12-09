require('./bootstrap');

window.Vue = require('vue');
//vue bootstrap start
import { BootstrapVue } from 'bootstrap-vue'
Vue.use(BootstrapVue)
//vue bootstrap end
Vue.use(require('vue-moment'));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('nav_bar', require('./admin/navbar.vue').default);
Vue.component('setup', require('./admin/setup.vue').default);
Vue.component('teacher', require('./admin/components/teacher.vue').default);
Vue.component('course', require('./admin/components/course.vue').default);
Vue.component('schedule', require('./admin/components/schedule.vue').default);


//filter start
Vue.filter('firstcap', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})
//filter end
const app = new Vue({
    el: '#app',
});
