<script setup>
import { switchTheme } from "../theme";
import NavLink from "../Components/NavLink.vue";
import { computed, ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const user = computed(() => usePage().props.auth.user);
const showState = ref({ show: false, showMore: false });

const toggle = (key) => (showState.value[key] = !showState.value[key]);

defineProps({ categories: Object });
</script>

<template>
    <div v-show="showState.show" @click="toggle('show')" class="fixed inset-0 z-40"></div>
    <div v-show="showState.showMore" @click="toggle('showMore')" class="fixed inset-0 z-40"></div>

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
                    <a href="#" @click.prevent="toggle('showMore')" class="font-bold">
                        More <span><i class="fa fa-angle-down"></i></span>
                    </a>
                </div>
                <ul v-show="showState.showMore"
                    class="absolute left-0 top-full mt-4 grid grid-cols-4 w-auto z-40 bg-slate-800 text-white rounded-lg border-slate-300 border overflow-y-auto max-h-64">
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
                    <Link class="relative inline-block mx-2" :href="route('notification.index')">
                    <i class="fa-solid fa-bell"></i>
                    <span
                        class="absolute bottom-3 left-3 flex h-5 w-5 items-center justify-center bg-red-500 rounded-full text-xs text-white">2</span>
                    </Link>

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
