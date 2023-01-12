import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/dashboard',
    component: () => import('layouts/MainLayout.vue'),
    children: [{ path: '', component: () => import('pages/IndexPage.vue') }],
  },
  {
    path: '/admin',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: 'books',
        children: [
          {
            path: 'add',
            component: () => import('src/pages/Master/books_add.vue'),
          },
          {
            path: 'edit/:id',
            component: () => import('src/pages/Master/books_edit.vue'),
          },
          {
            path: '',
            component: () => import('pages/Master/books_index.vue'),
          },
        ],
      },
      {
        path: 'users',
        children: [
          {
            path: 'add',
            component: () => import('src/pages/Master/user_add.vue'),
          },
          {
            path: 'edit/:id',
            component: () => import('src/pages/Master/user_edit.vue'),
          },
          {
            path: '',
            component: () => import('pages/Master/users_index.vue'),
          },
        ],
      },
    ],
  },
  {
    path: '/',
    component: () => import('layouts/GuessLayout.vue'),
    children: [{ path: '', component: () => import('pages/Auth/Login.vue') }],
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
