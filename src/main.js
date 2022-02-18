import { createApp } from 'vue'
import App from './App.vue'
import DadataSuggestions from 'vue-dadata-suggestions'
import "bootstrap/dist/css/bootstrap.min.css";
import './assets/css/main.css'
import './assets/css/media.css'



createApp(App).use(DadataSuggestions,{
    token: '350aab47868019c3ba7ddd532caccc6801b559ba',
    type: 'PARTY'
}).mount('#app')