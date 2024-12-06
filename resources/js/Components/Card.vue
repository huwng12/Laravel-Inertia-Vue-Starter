<script setup>
import { router } from '@inertiajs/vue3';

const params = route().params
const props = defineProps({
    listing: Object,
});
console.log(props.listing)
const searchUser = (id) => {
    router.get(route('home', { search: params.search, user_id: id, tag: params.tag }, { preserveScroll: true }));
}

const searchTag = (tag) => {
    router.get(route('home', { search: params.search, user_id: params.user_id, tag: tag }, { preserveScroll: true }));
}
</script>

<template>
    <div class="bg-white rounded-lg shadow-lg overflow-hidden 
    dark:bg-slate-800 w-full h-full flex flex-col justify-between">
        <div class="w-full h-full">
            <!-- Image -->
            <Link :href="route('listings.show', listing.id)">
            <img :src="listing.image
                ? `/storage/${listing.image}`
                : `/storage/images/listing/default.jpg`"
                class="w-full h-[194px] object-fit object-cover object-center bg-slate-300">
            </Link>
        </div>

        <!-- Title & user -->
        <div class="p-4">
            <Link :href="route('listings.show', listing.id)">
            <h3 class="font-bold text-xl mb-2">
                {{ listing.title.substring(0, 40) }}...
            </h3>
            </Link>

            <p>Listed on {{ new Date(listing.created_at).toLocaleDateString() }} by
                <button class="text-link" @click="searchUser(listing.user.id)">
                    {{ listing.user.name }}
                </button>
            </p>
        </div>
        <!-- Tags -->
        <div class="flex items-center justify-between ">
            <div v-if="listing.tags" class="flex items-center gap-3 px-4 pb-4">
                <div v-for="tag in listing.tags.split(',').slice(0, 3)" :key="tag">
                    <button @click="searchTag(tag)"
                        class="text-white bg-slate-500 rounded-full px-2 px-py hover:bg-slate-700 dark:hover:bg-slate-900">
                        {{ tag }}
                    </button>
                </div>
            </div>
            <div class="mr-2 mb-3">
                <a><i class="fa-solid fa-comment text-slate-500 mr-1"></i>{{ listing.comments.length }} </a>
            </div>
        </div>
    </div>
</template>