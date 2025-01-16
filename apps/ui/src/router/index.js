import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import About from '../views/About.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/about',
    name: 'About',
    component: About,
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
];

// Create router factory function
export function createAppRouter(eventTracker) {
  const router = createRouter({
    history: createWebHistory(),
    routes,
  });

  router.beforeEach((to, from) => {
    Promise.resolve().then(() => {
      eventTracker?.sendEvent('page_view', {
        from: from.fullPath,
        to: to.fullPath,
        name: to.name
      });
    });

    return true;
  });

  return router;
}

export default createAppRouter; 