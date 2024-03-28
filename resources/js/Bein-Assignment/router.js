import { createRouter, createWebHistory } from 'vue-router';

import PageNotFound from './screens/PageNotFound.vue';
import Dev from './screens/dev/index.vue';

const routes = [
  {
    meta: { title: 'Home' }, path: '/', children: [
      { meta: { title: 'Assignment' }, component: Dev, path: '' },
      { meta: { title: 'Page Not Found' }, path: '/:pathMatch(.*)*', name: 'NotFound', component: PageNotFound },
    ]
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, _, next) => {
  document.title = to.meta.title ?? 'Assignment';
  next();
})

export default router;