require('./bootstrap');

window.Vue = require('vue');
//vue bootstrap start
import { BootstrapVue, BIcon, BIconPersonCircle } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.component('BIcon',BIcon)
Vue.component('BIconPersonCircle',BIconPersonCircle)
//vue bootstrap end
Vue.use(require('vue-moment'));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('take_course', require('./student/take_course.vue').default);
Vue.component('teacher_schedule', require('./components/teacher_schedule.vue').default);

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
