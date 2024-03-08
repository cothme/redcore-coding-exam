import { createRouter, createWebHistory } from 'vue-router';
import Signup from '@/components/Signup.vue';
import Login from '@/components/Login.vue';
import Home from '@/components/Home.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/signup',
      name: 'Register',
      component: Signup,
      meta: { auth: false },

    },
    {
      path: '/login',
      name: 'Login',
      component: Login,
      meta: { auth: false },
    },
    {
      path: '/',
      name: 'Home',
      component: Home,
      meta: { auth: true },
    }
  ]
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('accessToken');
  if (to.meta.auth && !isAuthenticated) {
    next('/login');
    alert('Login first')
  }
  else if (!to.meta.auth && isAuthenticated && (to.name === 'Login' || to.name === 'Register')) {
    next('/');
    alert('Logout first')
  } else {
    next();
  }
});

export default router;
