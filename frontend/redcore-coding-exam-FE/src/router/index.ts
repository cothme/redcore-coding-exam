import { createRouter, createWebHistory } from 'vue-router'
import Signup from '@/components/Signup.vue'
import Login from '@/components/Login.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
        path: '/signup',
        name: 'Register',
        component: Signup
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
  ]
})

export default router
