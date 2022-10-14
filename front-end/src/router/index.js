import Vue from 'vue';
import VueRouter from 'vue-router';

import store from '../store/index';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    redirect: 'login',
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    meta: { requiresAuth: true },
    component: () => import('@/views/dashboard/Dashboard.vue'),
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/pages/Login.vue'),
    meta: {
      requiresAuth: false,
      layout: 'blank',
    },
  },
  {
    path: '/pages/register',
    name: 'pages-register',
    component: () => import('@/views/pages/Register.vue'),
    meta: {
      requiresAuth: false,
      layout: 'blank',
    },
  },
  {
    path: '/error-404',
    name: 'error-404',
    component: () => import('@/views/Error.vue'),
    meta: {
      requiresAuth: false,
      layout: 'blank',
    },
  },

  // start of custom
  {
    path: '/service',
    name: 'service',
    meta: { requiresAuth: true },
    component: () => import('@/views/service/Service.vue'),
  },
  {
    path: '/borrow',
    name: 'borrow',
    meta: { requiresAuth: true },
    component: () => import('@/views/borrow/Borrow.vue'),
  },
  {
    path: '/office',
    name: 'office',
    meta: { requiresAuth: true },
    component: () => import('@/views/office/Office.vue'),
  },
  {
    path: '/users',
    name: 'users',
    meta: { requiresAuth: true },
    component: () => import('@/views/users/Users.vue'),
  },
  {
    path: '/equipment',
    name: 'equipment',
    meta: { requiresAuth: true },
    component: () => import('@/views/equipments/Equipments.vue'),
  },
  {
    path: '/borrow-report',
    name: 'borrow-report',
    meta: { requiresAuth: true },
    component: () => import('@/views/report/borrow/BorrowReport.vue'),
  },
  {
    path: '/service-report',
    name: 'service-report',
    meta: { requiresAuth: true },
    component: () => import('@/views/report/service/ServiceReport.vue'),
  },
  {
    path: '/inventory',
    name: 'inventory',
    meta: { requiresAuth: true },
    component: () => import('@/views/inventory/Inventory.vue'),
  },
  {
    path: '*',
    redirect: 'error-404',
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  //  var authenticated = false;
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!store.state.auth.userCredential.authenticated) {
      next({
        name: 'login',
      });
    } else {
      next();
    }
  }
  next();
});

export default router;
