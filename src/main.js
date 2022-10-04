import { createApp } from 'vue'
import App from './App.vue'
import { plugin as VueInputAutowidth } from 'vue-input-autowidth'

createApp(App).use(VueInputAutowidth).mount('#zbs-account-plugin');
