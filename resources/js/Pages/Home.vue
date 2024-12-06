<script setup>
import Card from '../Components/Card.vue';
import PaginationLinks from '../Components/PaginationLinks.vue';
import InputField from '../Components/InputField.vue';
import { router, useForm } from '@inertiajs/vue3';
import HotNews from '../Components/HotNews.vue';
import CategoryTitle from '../Components/CategoryTitle.vue';
import { computed } from 'vue';

const params = route().params;

const props = defineProps({
    listings: Object,
    searchTerm: String,
    hot_news: Object,
});
const userName = params.user_id ? props.listings.data.find(listing => listing.user.id == params.user_id).user.name : null;
const form = useForm({
    search: props.searchTerm,
});
const search = () => {
    router.get(route('home'), { search: form.search, user_id: params.user_id, tag: params.tag });
}

const shouldShowHotNews = computed(() => {
    return props.hot_news && !props.searchTerm && !params.user_id && !params.tag;
});

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

    <div v-if="shouldShowHotNews">
        <CategoryTitle :label="'Hot News'" />
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="col-span-2">
                <HotNews :listing="hot_news[0]" />
            </div>
            <div class="col-span-1 flex flex-col gap-y-3">
                <div>
                    <HotNews :listing="hot_news[1]" variant="small" />
                </div>
                <div>
                    <HotNews :listing="hot_news[2]" variant="small" />
                </div>
            </div>
        </div>
    </div>


    <div v-if="Object.keys(listings.data).length">
        <CategoryTitle :label="'Latest News'" />
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