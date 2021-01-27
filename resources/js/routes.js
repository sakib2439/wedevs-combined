import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from './components/home.vue';
import ProductIndex from './components/product/index.vue';
import ProductCreate from './components/product/create.vue';
import ProductEdit from './components/product/edit.vue';

const routes = new VueRouter({
	mode: 'history',
	routes: [
		{ path: '/', component: Home},
		{ path: '/products', component: ProductIndex},
		{ path: '/products/create', component: ProductCreate},
		{ path: '/products/edit/:id', component: ProductEdit, name: 'edit-product'},
	]
});

export default routes;