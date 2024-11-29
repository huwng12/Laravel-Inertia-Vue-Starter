<script setup>
import { useForm } from '@inertiajs/vue3';
import TextArea from '../Components/TextArea.vue'
import Container from '../Components/Container.vue'
import SessionMessages from './SessionMessages.vue';

const props = defineProps({
    comments: Object,
    listing: Object,
});
const form = useForm({
    comment: ''
});

const DateAddedComment = (date) => {
    const now = new Date();
    const commentDate = new Date(date);
    const diffTime = now - commentDate;
    const diffMinute = Math.ceil(diffTime / (1000 * 60));
    const diffHour = Math.ceil(diffTime / (1000 * 60 * 60));
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    if (diffMinute < 60) {
        return `${diffMinute} minutes ago`;
    } else if (diffHour < 24) {
        return `${diffHour} hours ago`;
    } else if (diffDays < 7) {
        return `${diffDays} days ago`;
    }
    return new Date(date).toLocaleDateString();
};

const submitComment = () => {
    form.post(route('comment.store', props.listing.id), {
        preserveScroll: true,
    });
    form.reset();
};

</script>

<template>
    <Container class="container mt-6">
        <p class="w-full text-gray-500 border-b pb-2 pointer-events-none">Comments</p>
        <form @submit.prevent="submitComment" class="items-center space-y-4 mb-6">
            <TextArea class="mt-2" rows="2" placeholder="Add a comment" icon="comment" v-model="form.comment" />
            <div class="flex">
                <button type="submit" :disabled="form.processing"
                    class="px-6 py-2 rounded-lg bg-slate-950 text-white disabled:bg-slate-300 disabled:cursor-wait">
                    Submit
                </button>
                <SessionMessages v-if="form.recentlySuccessful" :status="'Comment added successfully'" class="m-4" />

            </div>
        </form>

        <div>
            <div v-for="comment in comments" :key="comment.id" class="flex py-4 space-x-4 items-start">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <img src="https://via.placeholder.com/150" alt="avatar" class="w-12 h-12 rounded-full">
                </div>
                <!-- Comment Content -->
                <div class="flex flex-col">
                    <!-- Name and Date -->
                    <div class="flex items-center space-x-2">
                        <p class="text-slate-600 font-semibold dark:text-slate-400">{{ comment.name }}</p>
                        <p class="text-slate-400 text-sm ">{{ DateAddedComment(comment.created_at) }}</p>
                    </div>
                    <!-- Comment Text -->
                    <p class="text-slate-700 dark:text-slate-300 word-break: break-all overflow-hidden">
                        {{ comment.comment }}</p>
                </div>
            </div>
        </div>
    </Container>
</template>
