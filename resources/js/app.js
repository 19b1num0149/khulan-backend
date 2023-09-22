import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import './bootstrap';
import 'flowbite';
import mitt from 'mitt';

import Breadcrumbs from './components/bread_crumbs.vue';
import Alert from './components/Alert.vue';
import Pagination from './components/Pagination.vue';
import i18n from './i18n';
import Loader from './components/Loader.vue';
import NoData from './components/NoData.vue';

import Layout from '@/layout/MasterLayout.vue' 

createInertiaApp({
    progress: {
        delay: 250,
        color: '#3b82f6',
        showSpinner: true,

    },
    title: title => `Negdeye - ${title}`,
    resolve: name => {
        const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
        let page = pages[`./pages/${name}.vue`]
        page.default.layout = name==='Login' ? undefined : Layout
        return page
    },
    setup({ el, App, props, plugin }) {
        const emitter = mitt()
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .component('Breadcrumbs', Breadcrumbs)
            .component('Alert', Alert)
            .component('Pagination', Pagination)
            .component('Loader', Loader)
            .component('NoData', NoData)
            // .mount(el)
        app.config.globalProperties.emitter = emitter
        app.mount(el)
    },
})