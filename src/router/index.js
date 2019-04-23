import Vue from 'vue';
import Router from 'vue-router';
import movie from '@/components/movie';
import detail from '@/components/detail';
import data from '@/components/data';
import about from '@/components/about';

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'movie',
      component: movie
    },
    {
      path: '/detail',
      name: 'detail',
      component: detail
    },
    {
      path: '/data',
      name: 'data',
      component: data
    },
    {
      path: '/about',
      name: 'about',
      component: about
    }
  ]
})
