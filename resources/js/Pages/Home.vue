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
    router.get(route('home'), { search: form.search, user_id: params.user_id, tag: params.tag });
}

const shouldShowHotNews = computed(() => {
    return props.hot_news && !props.searchTerm && !params.user_id && !params.tag;
});

const filterLinks = computed(() => {
    const links = [];
    if (params.tag) links.push({ label: params.tag, href: route('home', { ...params, tag: null, page: null }) });
    if (params.search) links.push({ label: params.search, href: route('home', { ...params, search: null, page: null }) });
    if (params.user_id) links.push({ label: userName.value, href: route('home', { ...params, user_id: null, page: null }) });
    return links;
})
</script>

<template>

    <Head title="- Listing Page" />

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

    <div v-if="shouldShowHotNews">
        <CategoryTitle :label="'Hot News'" />
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="col-span-2">
                <HotNews :listing="hot_news[0]" />
            </div>
            <div class="col-span-1 flex flex-col gap-y-3">
                <HotNews v-for="(news, index) in hot_news.slice(1, 3)" :key="index" :listing="news" variant="small">
                </HotNews>
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