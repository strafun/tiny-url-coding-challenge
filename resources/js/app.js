import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { globalCookiesConfig } from 'vue3-cookies'
import Layout from './Layout.vue'


globalCookiesConfig({
    expireTimes: "30d",
    path: "/",
    domain: "",
    secure: true,
    sameSite: "None",
})

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        page.default.layout = page.default.layout || Layout
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
