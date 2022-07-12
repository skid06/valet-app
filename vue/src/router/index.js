import { createRouter, createWebHashHistory } from "vue-router";
import Dashboard from "../views/Dashboard.vue"
import DefaultLayout from "../components/DefaultLayout.vue"
import Register from "../views/Register.vue"
import Login from "../views/Login.vue"
import store from "../store"

const routes = [
  {
    path: '/',
    redirect: '/dashboard',
    meta: { requiresAuth: true },
    component: DefaultLayout,
    children: [
      { path: '/dashboard', name: 'Dashboard', component: Dashboard }
    ]
  },
  {
    path: '/login',
    name: 'Login',
    meta: { requiresGuest: true },
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    meta: { requiresGuest: true },
    component: Register
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({ name: 'Login' })
  } else if (to.meta.requiresGuest && store.state.user.token) {
    next({ name: 'Dashboard' })
  } else {
    next()
  }
})

export default router