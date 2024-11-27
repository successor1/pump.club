import '../css/app.css';
import './bootstrap';

import { wagmiAdapter } from '@/lib/wagmi.js';
import { createInertiaApp } from '@inertiajs/vue3';
import { QueryClient, VueQueryPlugin } from '@tanstack/vue-query';
import { WagmiPlugin } from '@wagmi/vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const queryClient = new QueryClient()
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(WagmiPlugin, { config: wagmiAdapter.wagmiConfig })
            .use(VueQueryPlugin, { queryClient })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
