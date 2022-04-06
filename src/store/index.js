import axios from 'axios'
import { createStore } from 'vuex'

export default createStore({
  state: {
    promos:[],

  },
  mutations: {
    getPromos(state, promos){
      state.promos = promos
    }
  },
  actions: {
    getActionPromos({commit}){
      axios('https://pay.karelforum.ru/promo_list.php').then(res => {
        commit('getPromos', res.data);
       // console.log(res.data);
      }).catch(error => {
        console.log(error);
        this.errored = true;
      }).finally(() => (this.loading = false));
    }

  },
  modules: {
  }
})