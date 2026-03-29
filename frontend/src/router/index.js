import { createRouter, createWebHistory } from 'vue-router'
import AppLayout from '../layouts/AppLayout.vue'
import AuthLayout from '../layouts/AuthLayout.vue'
import LoginView from '../views/auth/LoginView.vue'
import RegisterView from '../views/auth/RegisterView.vue'
import DashboardView from '../views/dashboard/DashboardView.vue'
import TransactionsView from '../views/transactions/TransactionsView.vue'
import TransferView from '../views/transfer/TransferView.vue'

const routes = [
  {
    path: '/',
    component: AuthLayout,
    children: [
      {
        path: 'login',
        name: 'login',
        component: LoginView,
        meta: {
          title: 'Login',
        },
      },
      {
        path: 'register',
        name: 'register',
        component: RegisterView,
        meta: {
          title: 'Cadastro',
        },
      },
    ],
  },
  {
    path: '/',
    component: AppLayout,
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: '',
        redirect: '/dashboard',
        name: 'home',
      },
      {
        path: 'dashboard',
        name: 'dashboard',
        component: DashboardView,
        meta: {
          title: 'Dashboard',
        },
      },
      {
        path: 'transactions',
        name: 'transactions',
        component: TransactionsView,
        meta: {
          title: 'Transacoes',
        },
      },
      {
        path: 'transfer',
        name: 'transfer',
        component: TransferView,
        meta: {
          title: 'Transferencias',
        },
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  if (to.meta.requiresAuth && !token) {
    return next('/login')
  }

  next()
})

router.afterEach((to) => {
  document.title = `${to.meta.title ?? 'Wallet P2P'} | Wallet P2P`
})

export default router