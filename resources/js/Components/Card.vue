<script setup>
import { router } from '@inertiajs/vue3';

const params = route().params
defineProps({
    listing: Object,
});

const searchUser = (id) => {
    router.get(route('home', { search: params.search, user_id: id, tag: params.tag }, { preserveScroll: true }));
}

const searchTag = (tag) => {
    router.get(route('home', { search: params.search, user_id: params.user_id, tag: tag }, { preserveScroll: true }));
}
</script>

<template>
    <div class="bg-white rounded-lg shadow-lg overflow-hidden 
    dark:bg-slate-800 h-full flex flex-col justify-between">
        <div>
            <!-- Image -->
            <Link :href="route('listings.show', listing.id)">
            <img :src="listing.image
                ? `storage/${listing.image}`
                : `storage/images/listing/default.jpg`" class="w-full h-full object-cover object-center bg-slate-300">
            </Link>
        </div>

        <!-- Title & user -->
        <div class="p-4">
            <h3 class="font-bold text-xl mb-2">
                {{ listing.title.substring(0, 40) }}...
            </h3>
            <p>Listed on {{ new Date(listing.created_at).toLocaleDateString() }} by
                <button class="text-link" @click="searchUser(listing.user.id)">
                    {{ listing.user.name }}
                </button>
            </p>
        </div>
        <!-- Tags -->
        <div v-if="listing.tags" class="flex items-center gap-3 px-4 pb-4">
            <div v-for="tag in listing.tags.split(',')" :key="tag">
                <button @click="searchTag(tag)"
                    class="text-white bg-slate-500 rounded-full px-2 px-py hover:bg-slate-700 dark:hover:bg-slate-900">
                    {{ tag }}
                </button>
            </div>
        </div>
    </div>
</template>