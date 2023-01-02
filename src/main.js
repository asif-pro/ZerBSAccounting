import { createApp } from 'vue'
import App from './App.vue'
// import Verte from 'verte';
// import 'verte/dist/verte.css';

import { plugin as VueInputAutowidth } from 'vue-input-autowidth'



const app = createApp(App);

// app.use(Verte);

app.use(VueInputAutowidth);

app.mount('#zbs-account-plugin');
