require('./bootstrap');

import { createApp, h } from 'vue';

import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import AppLayout from "@/Layouts/AppLayout.vue";
import EnInput from "@/Pages/Components/Form/EnInput";
import EnBoton from "@/Pages/Components/Form/EnBoton";
import EnTextArea from "@/Pages/Components/Form/EnTextArea";
import EnModal from "@/Pages/Components/Form/EnModal";
import EnPaginacion from "@/Pages/Components/EnPaginacion";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Enid Service';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .component("Link", Link)
            .component("Head", Head)
            .component("EnInput", EnInput)
            .component("EnBoton", EnBoton)
            .component("EnModal", EnModal)
            .component("EnTextArea", EnTextArea)
            .component("AppLayout", AppLayout)
            .component("EnPaginacion", EnPaginacion)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
