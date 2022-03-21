import { createRouter, createWebHistory } from 'vue-router'


const routes = [
  {
    path: '/',
    name: 'Home',
    hash: '#main',
    component: () => import('../components/MainPage.vue'),
    //alias: ["/company/"]
    //alias: ["/company", "/company_one_day", "/company_full_day", "private_person", "private_one_day", "private_full_day", "private_stud_full_day", "finish"]

  },
  {
    path: '/:pathMatch(.*)*',
    component: () => import('../views/NotFound.vue')
  },

]



const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
 /* scrollBehavior (to) {

    if (to.hash) {
      //return {selector: to.hash}
      //Or for Vue 3:

      return {el: to.hash, top: 100,}
    }
  }*/

})

export default router
