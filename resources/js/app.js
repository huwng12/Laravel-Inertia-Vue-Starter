import "./bootstrap";
import "../css/app.css";
import "../css/style.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import CKEditor from '../js/Components/CKEditor.vue';
import Pusher from 'pusher-js';

import Main from "./Layouts/Main.vue";
import { setThemeOnLoad } from "./theme";


createInertiaApp({
    title: (title) => `My App ${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        
        page.default.layout = page.default.layout || Main;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // Lấy user_id từ $page.props trong context của Inertia
        const userId = props.initialPage.props.auth.user.id;
        // console.log('User ID:', userId);

        // Cấu hình Pusher
        const pusher = new Pusher('e09691a78203784895db', {
            cluster: 'ap1', 
        });

        // Đăng ký kênh và lắng nghe sự kiện
        const channel = pusher.subscribe('private-user.' + userId);
        channel.bind('notification.created', (data) => {
            console.log('New Notification:', data);
        });

        app.use(plugin)
            .use(ZiggyVue)
            .component("Head", Head)
            .component("Link", Link)
            .component('CKEditor', CKEditor)
            .mount(el);
            
    },
    progress: {
        color: "#fff",
        showSpinner: true,
    },
});

setThemeOnLoad();