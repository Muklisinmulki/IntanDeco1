import '../css/app.css';
import './bootstrap';
import 'flowbite';
import '@fortawesome/fontawesome-free/css/all.min.css';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { route } from 'ziggy-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin);
            
        // Make route globally available
        app.config.globalProperties.$route = route;
            
        return app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
