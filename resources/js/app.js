import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';

import login from './components/login.vue';
import router from './router';

const app = createApp({
    components : {
        login,
    }
});
app.use(router);

app.mount('#app');





