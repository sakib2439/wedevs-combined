import Vue from 'vue';
require('./bootstrap');

import routes from './routes';
import {filters} from './filters'

/* Form Validation */
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

/* Global Pagination */
Vue.component('pagination', require('./components/partial/Pagination.vue').default);

/* Sweet Alert 2 */
import swal from 'sweetalert2';
const Swal = require('sweetalert2')
window.swal = swal;


/* CXLT Toaster notification */
import CxltToastr from 'cxlt-vue2-toastr'
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'

var toastrConfigs = {
    position: 'top right',
    showDuration: 1000,
    timeOut: 3000,
    closeButton: true,
    progressBar: true,
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut',
}
Vue.use(CxltToastr, toastrConfigs)

const app = new Vue({
    el: '#app',
    router: routes,
});
