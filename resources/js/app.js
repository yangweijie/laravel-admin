require('./bootstrap')

import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/vue2'

var vm = createInertiaApp({
    progress: {
        color: '#29d',
    },
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin)
        new Vue({
            render: h => h(App, props),
        }).$mount(el)
    },
})