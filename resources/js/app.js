import { createApp } from 'vue/dist/vue.esm-bundler.js'

import App from './App.vue';
import router from './router';
import ToastService from 'primevue/toastservice';

import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/tailwind-light/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';                   // optional
import TieredMenu from 'primevue/tieredmenu';

import ConfirmDialog from 'primevue/confirmdialog'
import InputText from 'primevue/inputtext';
import Avatar from 'primevue/avatar';
import Button from 'primevue/button';
import AutoComplete from 'primevue/autocomplete';
import Menu from 'primevue/menu';
import Dialog from 'primevue/dialog';
import Tooltip from 'primevue/tooltip';
import Toast from 'primevue/toast';
import FileUpload from 'primevue/fileupload';

import axios from './plugins/axios-static'
import VueAxios from 'vue-axios'

const app = createApp({
    components: {
        App
    }
});
app.component('ConfirmDialog', ConfirmDialog);
app.component('InputText', InputText);
app.component('Toast', Toast);
app.component('TieredMenu', TieredMenu);
app.component('FileUpload', FileUpload);
app.component('AutoComplete', AutoComplete);
app.component('Button', Button);
app.component('Dialog', Dialog);
app.component('Avatar', Avatar);
app.component('Menu', Menu);
app.directive('tooltip', Tooltip);
app.directive('DataTable', DataTable);
app.directive('Column', Column);
app.directive('ColumnGroup', ColumnGroup);
app.directive('Row', Row);

app.use(VueAxios, axios);

app.use(ToastService);
app.use(router);
app.use(PrimeVue);

app.mount('#app')
