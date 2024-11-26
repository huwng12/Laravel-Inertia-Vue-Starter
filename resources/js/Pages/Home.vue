<script setup>
import Card from '../Components/Card.vue';
import PaginationLinks from '../Components/PaginationLinks.vue';
import InputField from '../Components/InputField.vue';
import { router, useForm } from '@inertiajs/vue3';

const params = route().params;
const props = defineProps({
    listings: Object,
    searchTerm: String,
});
// console.log(props.listings.data);
const userName = params.user_id ? props.listings.data.find(listing => listing.user.id == params.user_id).user.name : null;
const form = useForm({
    search: props.searchTerm,
});
const search = () => {
    router.get(route('home'), { search: form.search, user_id: params.user_id, tag: params.tag });
}

</script>

<template>

    <Head title="- Listing Page" />

    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <Link v-if="params.tag" :href="route('home', { ...params, tag: null, page: null })"
                class="flex items-center rounded-md bg-indigo-500 text-white px-2 py-1">
            {{ params.tag }} <i class="fas fa-times ml-2"></i>
            </Link>
            <Link v-if="params.search" :href="route('home', { ...params, search: null, page: null })"
                class="flex items-center rounded-md bg-indigo-500 text-white px-2 py-1">
            {{ params.search }} <i class="fas fa-times ml-2"></i>
            </Link>
            <Link v-if="params.user_id" :href="route('home', { ...params, user_id: null, page: null })"
                class="flex items-center rounded-md bg-indigo-500 text-white px-2 py-1">
            {{ userName }} <i class="fas fa-times ml-2"></i>
            </Link>
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
                <Card :listing="listing" />
            </div>
        </div>
        <PaginationLinks class="mt-6" :paginator="listings" />
    </div>
    <div v-else>
        There is no listing
    </div>
</template>