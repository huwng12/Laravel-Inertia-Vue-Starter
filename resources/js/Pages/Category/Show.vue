<script setup>
import CategoryCard from '../../Components/CategoryCard.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';
import InputField from '../../Components/InputField.vue';
import { router, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const params = route().params;
const props = defineProps({
    listings: Object,
    searchTerm: String,
    category_name: String,
});
const userName = computed(() => {
    if (params.user_id) {
        return props.listings.data.find(listing => listing.user.id == params.user_id).user.name
    }
    return null;
})
const form = useForm({
    search: props.searchTerm,
});
const search = () => {
    router.get(route('category.index', { categoryId: props.listings.data[0].category_id }), { search: form.search, user_id: params.user_id, tag: params.tag });
}

const filterLinks = computed(() => {
    const links = [];
    if (params.tag) links.push({ label: params.tag, href: route('category.index', { ...params, tag: null, page: null }) });
    if (params.search) links.push({ label: params.search, href: route('category.index', { ...params, search: null, page: null }) });
    if (params.user_id) links.push({ label: userName, href: route('category.index', { ...params, user_id: null, page: null }) });
    return links;
})

</script>

<template>

    <Head title="- Category Page" />
    <div class="mb-4">
        <a class="text-link font-bold" :href="route('home')">Home</a>
        >
        <a class="text-link font-bold">
            {{ category_name }}
        </a>
    </div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <div v-for="(link, index) in filterLinks" :key="index">
                <Link :href="link.href" class="flex items-center rounded-md bg-indigo-500 text-white px-2 py-1">
                {{ link.label }} <i class="fas fa-times ml-2"></i>
                </Link>
            </div>
        </div>
        <div class="w-1/4">
            <form @submit.prevent="search">
                <InputField icon="search" type="search" placeholder="Search..." v-model="form.search" />
            </form>
        </div>
    </div>

    <div v-if="Object.keys(listings.data).length">
        <div class="grid grid-cols-3 gap-4">
            <div v-for="listing in listings.data" :key="listing.id">
                <CategoryCard :listing="listing" />
            </div>
        </div>
        <PaginationLinks class="mt-6" :paginator="listings" />
    </div>
    <div v-else>
        There is no listing
    </div>

</template>