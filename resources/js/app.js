import './bootstrap.js';

import { createApp } from 'vue';

//pinia setup
import { createPinia } from 'pinia'
const pinia = createPinia()

//vuetify setup
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css'
import { customTheme } from './Bein-Assignment/css/libs/theme.js';

//vue-router setup
import router from './Bein-Assignment/router';

//date picker
import '@vuepic/vue-datepicker/dist/main.css';

import App from './App.vue';


const vuetify = createVuetify({
  components, directives, icons: { defaultSet: 'mdi' },
  theme: {
    defaultTheme: 'customTheme',
    themes: { customTheme },
  }
});

createApp(App).use(vuetify).use(pinia).use(router).mount('#app');