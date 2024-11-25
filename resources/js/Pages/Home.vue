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
const form = useForm({
    search: props.searchTerm,
});
const search = () => {
    router.get(route('home'), { search: form.search, user_id: params.user_id });
}

</script>

<template>

    <Head title="- Listing Page" />

    <div class="flex items-center justify-between mb-4">
        <div>filters</div>
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