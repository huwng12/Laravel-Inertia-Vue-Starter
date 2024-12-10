import "./bootstrap";
import "../css/app.css";
import "../css/style.css";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import CKEditor from '../js/Components/CKEditor.vue';
// import Pusher from 'pusher-js';

import Main from "./Layouts/Main.vue";
import { setThemeOnLoad } from "./theme";

// // Cấu hình Pusher
Pusher.logToConsole = true; // Bật log để debug trong quá trình phát triển
// const pusher = new Pusher('9be9c09afe89e6db88f7', {
//     cluster: 'ap1', 
// });

// // Đăng ký kênh và lắng nghe sự kiện
// const channel = pusher.subscribe('my-channel');
// channel.bind('my-event', (data) => {
//     console.log('Received data:', data);
// });
// // channel.bind('pusher:subscription_succeeded', function() {
// //     console.log('Successfully subscribed to my-channel');
// // });

createInertiaApp({
    title: (title) => `My App ${title}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        
        page.default.layout = page.default.layout || Main;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
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