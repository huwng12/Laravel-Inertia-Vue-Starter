<script setup>
import { switchTheme } from "../theme";
import NavLink from "../Components/NavLink.vue";
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { defineProps } from "vue";

const page = usePage();
console.log(page.component);  // Use the data returned by usePage

const user = computed(() => page.props.auth.user);
const show = ref(false);
const showMoreButton = ref(false);

const showMore = () => {
    showMoreButton.value = !showMoreButton.value;
};

const props = defineProps({
    categories: Object
});

</script>

<template>

    <div v-show="show" @click="show = false" class="fixed inset-0 z-40"></div>
    <header class="bg-slate-800 text-white">
        <nav class="p-6 mx-auto w-full flex items-center justify-between">
            <NavLink routeName="home" componentName="Home">Home</NavLink>
            <!-- Categories -->
            <div class="flex relative items-center text-lg gap-6 ">
                <div v-for="(category, i) in categories.slice(0, 6)" :key="i" class="font-bold">
                    <a :href="route('category.index', { categoryId: category.id })"
                        class="hover:bg-slate-700 p-4 rounded-lg cursor-pointer" :class="{
                            'bg-slate-700': $page.url === `/category/${category.id}`,
                            'hover:bg-slate-700': true
                        }">
                        {{ category.name }}
                    </a>
                </div>
                <div v-if="categories.length > 6" class="dropdown m-menu-fw ">
                    <a href="#" @click.prevent="showMore" class="dropdown-toggle font-bold">
                        More <span><i class="fa fa-angle-down"></i></span>
                    </a>
                </div>
                <ul v-show="showMoreButton"
                    class="absolute grid grid-cols-4 w-auto z-40 dropdown-menu bg-slate-800 text-white rounded-lg border-slate-300 border overflow-hidden overflow-y-auto max-h-64">
                    <li v-for="(category, index) in categories.slice(6)" :key="category.id">
                        <a :href="route('category.index', { categoryId: category.id })"
                            class="block px-4 py-2 w-full hover:bg-slate-700"
                            :class="{ 'bg-slate-700': $page.url === `/category/${category.id}`, 'hover:bg-slate-700': true }">{{
                                category.name
                            }}</a>
                    </li>
                </ul>
            </div>


            <div class="flex items-center space-x-6">
                <!-- Auth -->
                <div v-if="user" class="relative flex items-center justify-between gap-2">
                    <div @click="show = !show"
                        class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 cursor-pointer"
                        :class="{ 'bg-slate-700': show }">
                        <p>{{ user.name }}</p>
                        <i class="fa-solid fa-angle-down"></i>
                    </div>
                    <Link v-if="user.role === 'admin'" :href="route('admin.index')"
                        class="hover:bg-slate-700 w-6 h-6 grid place-items-center rounded-full hover:outline outline-1 outline-white">
                    <i class="fa-solid fa-lock"></i>
                    </Link>

                    <div v-if="show" @click="show = false"
                        class="absolute z-50 top-16 right-0 bg-slate-800 text-white rounded-lg border-slate-300 border overflow-hidden w-40">
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