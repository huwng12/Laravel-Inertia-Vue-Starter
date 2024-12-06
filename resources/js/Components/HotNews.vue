<script setup>
import { router } from '@inertiajs/vue3';

const params = route().params
defineProps({
    listing: Object,
    variant: {
        type: String,
        default: 'default'
    }
});

const searchUser = (id) => {
    router.get(route('home', { search: params.search, user_id: id, tag: params.tag }, { preserveScroll: true }));
}

const searchTag = (tag) => {
    router.get(route('home', { search: params.search, user_id: params.user_id, tag: tag }, { preserveScroll: true }));
}
</script>

<template>
    <div :class="['bg-white rounded-lg shadow-lg overflow-hidden dark:bg-slate-800',
        variant === 'small' ? 'w-full h-full' : 'w-[645px] h-[400px]'
    ]">
        <div class="relative w-full h-full">
            <!-- Image -->
            <Link :href="route('listings.show', listing.id)">
            <img :src="listing.image
                ? `/storage/${listing.image}`
                : `/storage/images/listing/default.jpg`" :class="[
                    'object-fit object-cover object-center bg-slate-300', variant === 'small' ? 'w-full h-[194px]' : 'w-full h-full'
                ]">
            </Link>
            <div
                class="absolute rounded-md bottom-0 left-[10%] w-[85%] p-[10px] bg-slate-200 dark:bg-slate-600 dark:bg-opacity-95 bg-opacity-85">
                <!-- Title & user -->
                <div class="p-4">
                    <Link :href="route('listings.show', listing.id)">
                    <h3 :class="['font-bold mb-2'], variant === 'small' ? 'text-sm' : 'text-2xl'">
                        {{ listing.title.substring(0, 50) }}...
                    </h3>
                    </Link>
                    <p v-if="variant != 'small'">Listed on {{ new Date(listing.created_at).toLocaleDateString() }} by
                        <button class="text-link" @click="searchUser(listing.user.id)">
                            {{ listing.user.name }}
                        </button>
                    </p>
                </div>
                <!-- Tags -->
                <div v-if="listing.tags && variant != 'small'" class="flex items-center gap-3 px-4 pb-4">
                    <div v-for="tag in listing.tags.split(',')" :key="tag">
                        <button @click="searchTag(tag)"
                            class="text-white bg-indigo-600 rounded-full px-2 py-1 hover:bg-slate-700 dark:hover:bg-indigo-500">
                            {{ tag }}
                        </button>
                    </div>
                </div>
            </div>

        </div>


    </div>
</template>