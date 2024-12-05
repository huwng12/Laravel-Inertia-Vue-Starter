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
    dark:bg-slate-800 w-[645px] h-[400px] flex flex-col justify-between">
        <div class="relative w-full h-full">
            <!-- Image -->
            <Link :href="route('listings.show', listing.id)">
            <img :src="listing.image
                ? `/storage/${listing.image}`
                : `/storage/images/listing/default.jpg`"
                class="w-[1000px] h-[600px] object-cover object-center bg-slate-300">
            </Link>
            <div class="absolute rounded-md bottom-0 left-[10%] w-[70%] p-[15px_30px] bg-slate-200 bg-opacity-95 ">
                <!-- Title & user -->
                <div class=" p-4">
                    <h3 class="font-bold text-xl mb-2">
                        {{ listing.title.substring(0, 50) }}...
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
                            class="text-white bg-slate-500 rounded-full px-2 py-1 hover:bg-slate-700 dark:hover:bg-slate-900">
                            {{ tag }}
                        </button>
                    </div>
                </div>
            </div>

        </div>


    </div>
</template>