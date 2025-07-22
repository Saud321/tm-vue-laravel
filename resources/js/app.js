import './bootstrap';
import { createApp } from 'vue';
import {createPinia} from "pinia";
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import App from './components/App.vue';
import router from "./router.js";


/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */


import * as solidIcons from '@fortawesome/free-solid-svg-icons'
import * as regularIcons from '@fortawesome/free-regular-svg-icons'
import * as brandIcons from '@fortawesome/free-brands-svg-icons'

// Utility to extract only icon definitions
const extractIcons = (icons) =>
    Object.values(icons).filter(i => i.prefix && i.iconName)

library.add(...extractIcons(solidIcons), ...extractIcons(regularIcons), ...extractIcons(brandIcons))

const app = createApp(App);
app.use(ToastPlugin);
app.component('font-awesome-icon', FontAwesomeIcon)
app.use(createPinia())
app.use(router)
app.mount('#app');
