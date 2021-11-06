require('./bootstrap');

import Vue from 'vue';
import VueRouter from "vue-router";
import {routes} from "./route";
import layout from "./layout";
import LoadScript from 'vue-plugin-load-script';
import VueHead from 'vue-head'

Vue.use(VueHead)
Vue.use(LoadScript);
Vue.use(VueRouter);

const router = new VueRouter({
    routes: routes,
    mode: 'history'
})

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(layout)
});
