import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
//import DadataSuggestions from 'vue-dadata-suggestions'
import "bootstrap/dist/css/bootstrap.min.css";
import './assets/css/main.css'
import './assets/css/media.css'



createApp(App).use(store).use(router).mount('#app')