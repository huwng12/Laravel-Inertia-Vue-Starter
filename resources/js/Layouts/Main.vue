<script setup>
import { switchTheme } from "../theme";
import NavLink from "../Components/NavLink.vue";
import { computed, onMounted, ref } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";

// Get current user
const user = computed(() => usePage().props.auth.user);
const showState = ref({ show: false, showMore: false, showNotification: false });

const notificationCount = ref(0);
const notification = ref([]);
const newNotification = ref({});

// Fetch notifications from the backend
const fetchNotification = async () => {
    const response = await fetch("/notification");
    const data = await response.json();
    notification.value = data.data;
    const unread = data.data.filter(n => n.is_read == 0);
    console.log('user: ', unread);

    notificationCount.value = unread.length;
};

// Listen for real-time notifications using Laravel Echo
if (user.value && user.value.id) {
    const notificationId = 'notifications.' + user.value.id;
    window.Echo.private(notificationId).listen("NotificationCreated", (e) => {
        notificationCount.value++;
        newNotification.value = {
            id: e.notification.notification_id,
            title: e.notification.title,
            message: e.notification.message,
            type: e.notification.type,
            is_read: e.notification.is_read,
        };
        notification.value.unshift(newNotification.value);
    });
}
const toggle = (key) => (showState.value[key] = !showState.value[key]);

const truncate = (text, length) => {
    return text.length > length ? text.substring(0, length) + "..." : text;
};

const handleUpdateIsRead = (id, is_read) => {
    if (is_read === 0) {
        router.put(route('notification.update', id), {}, {
            onSuccess: () => {
                const index = notification.value.findIndex(n => n.id === id);
                if (index !== -1) {
                    notification.value[index].is_read = 1;
                    notificationCount.value--;
                }
                console.log('handleUpdateIsRead: ', notification.value);
            },
            onError: (errors) => {
                console.error('Error updating notification:', errors);
            }
        });
    }
};


// On component mounted, fetch notifications and check login session
onMounted(() => {
    fetchNotification();
    // Check if user logged in and session exists
    if (sessionStorage.getItem('user_logged_in') || localStorage.getItem('user_logged_in')) {
        fetchNotification();
    }
    window.addEventListener('userLoggedIn', fetchNotification);
});

defineProps({ categories: Object });

</script>

<template>
    <div v-show="showState.show" @click="toggle('show')" class="fixed inset-0 z-40"></div>
    <div v-show="showState.showMore" @click="toggle('showMore')" class="fixed inset-0 z-40"></div>
    <div v-show="showState.showNotification" @click="toggle('showNotification')" class="fixed inset-0 z-40"></div>

    <header class="bg-slate-800 text-white">
        <nav class="p-6 mx-auto w-full flex items-center justify-between">
            <NavLink routeName="home" componentName="Home">Home</NavLink>

            <!-- Categories -->
            <div class="flex relative items-center text-lg gap-6 ">
                <div v-for="(category, i) in categories.slice(0, 6)" :key="i" class="font-bold">
                    <Link :href="route('category.index', { categoryId: category.id })"
                        class="hover:bg-slate-700 p-4 rounded-lg cursor-pointer" :class="{
                            'bg-slate-700': $page.url === `/category/${category.id}`, 'hover:bg-slate-700': true
                        }">
                    {{ category.name }}
                    </Link>
                </div>
                <div v-if="categories.length > 6">
                    <a href="#" @click.prevent="toggle('showMore')"
                        class="font-bold hover:bg-slate-700 p-4 rounded-lg cursor-pointer">
                        More <span><i class="fa fa-angle-down"></i></span>
                    </a>
                </div>
                <ul v-show="showState.showMore"
                    class="absolute left-0 top-full mt-6 grid grid-cols-4 w-auto z-40 bg-slate-800 text-white rounded-lg border-slate-300 border overflow-y-auto max-h-64">
                    <li v-for="category in categories.slice(6)" :key="category.id">
                        <Link @click="toggle('showMore')" :href="route('category.index', { categoryId: category.id })"
                            class="block px-4 py-2 w-full hover:bg-slate-700"
                            :class="{ 'bg-slate-700': $page.url === `/category/${category.id}` }">
                        {{ category.name }}
                        </Link>
                    </li>
                </ul>
            </div>


            <!-- Auth -->
            <div class="flex items-center space-x-6">
                <div v-if="user" class="relative flex items-center justify-between gap-3">
                    <!-- Notification -->
                    <div class="relative mx-2 cursor-pointer hover:bg-slate-700 w-6 h-6 grid place-items-center rounded-full hover:outline outline-1 outline-white"
                        @click="toggle('showNotification')">
                        <i class="fa-solid fa-bell "></i>
                        <span v-if="notificationCount > 0"
                            class="absolute bottom-3 left-3 flex h-5 w-5 items-center justify-center bg-red-500 rounded-full text-xs text-white">
                            {{ notificationCount }}</span>
                    </div>

                    <div v-if="showState.showNotification"
                        class="absolute right-0 top-full mt-2 w-80 max-h-[320px] overflow-y-auto bg-white shadow-lg rounded-md z-50 ">
                        <div class="space-y-1">
                            <Link v-if="notification.length" v-for="notify in notification" :key="notify.id" :class="[
                                'block flex items-center justify-between space-x-3 p-2 text-sm bg-white',
                                notify.type == 1 ? 'text-red-600' : ' text-slate-700',
                                notify.type == 2 ? 'hover:bg-slate-300 cursor-pointer' : '',
                                notify.is_read == 0 ? 'font-extrabold' : ''
                            ]" @click="handleUpdateIsRead(notify.id, notify.is_read)"
                                :href="notify.type == 2 ? route('listings.show', notify.listing_id) : ''">
                            <div>
                                <p class="font-bold">{{ truncate(notify.title, 30) }}</p>
                                <p class="break-words">{{ truncate(notify.message, 100) }}</p>
                            </div>
                            <i v-if="notify.is_read == 0" class="fa-solid fa-circle text-blue-500"></i>
                            </Link>
                            <div v-else
                                class="bg-white text-slate-700 p-2 text-sm border-b border-slate-200 hover:bg-slate-200 cursor-pointer">
                                You have no notification
                            </div>
                        </div>
                    </div>


                    <!-- Management -->
                    <div @click="toggle('show')"
                        class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 cursor-pointer"
                        :class="{ 'bg-slate-700': showState.show }">
                        <p>{{ user.name }}</p>
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                    <Link v-if="user.role === 'admin'" :href="route('admin.index')"
                        class="hover:bg-slate-700 w-6 h-6 grid place-items-center rounded-full hover:outline outline-1 outline-white">
                    <i class="fa-solid fa-lock"></i>
                    </Link>


                    <div v-if="showState.show" @click="toggle('show')"
                        class="absolute z-50 top-16 right-0 bg-slate-800 text-white rounded-lg border-slate-300 border overflow-hidden w-40">
                        <Link v-if="$page.props.auth.user.role === 'admin'" :href="route('notification.index')"
                            class="block w-full px-6 py-3 hover:bg-slate-700 text-lefts">
                        Send Notification</Link>
                        <Link v-if="$page.props.auth.user.role === 'admin'" :href="route('category.list')"
                            class="block w-full px-6 py-3 hover:bg-slate-700 text-lefts">
                        Category</Link>
                        <Link :href="route('listings.create')"
                            class="block w-full px-6 py-3 hover:bg-slate-700 text-lefts">
                        New Listing</Link>
                        <Link :href="route('profile.edit')"
                            class="block w-full px-6 py-3 hover:bg-slate-700 text-lefts">
                        Profile</Link>
                        <Link :href="route('dashboard')" class="block w-full px-6 py-3 hover:bg-slate-700 text-lefts">
                        Dashboard</Link>

                        <Link :href="route('logout')" method="post" as="button"
                            class="block w-full px-6 py-3 hover:bg-slate-700 text-left">Logout</Link>
                    </div>
                </div>

                <!-- Guest -->
                <div v-else class="space-x-6">
                    <NavLink routeName="login" componentName="Auth/Login">Login</NavLink>
                    <NavLink routeName="register" componentName="Auth/Register">Register</NavLink>
                </div>

                <button @click="switchTheme"
                    class="hover:bg-slate-700 w-6 h-6 grid place-items-center rounded-full hover:outline outline-1 outline-white">
                    <i class="fa-solid fa-circle-half-stroke"></i>
                </button>
            </div>
        </nav>
    </header>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>
