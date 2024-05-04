import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../screens/LoginPage.vue'
import Signup from '../screens/SignUp.vue'
import HomePage from '../screens/HomePage.vue'



Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'login',
    component: Login
  },
  {
    path: '/signup',
    name: 'signup',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: Signup
  },
  {

    path:'/home',
    name:'home',
    component:HomePage
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
