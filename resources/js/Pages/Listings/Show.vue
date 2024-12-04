<script setup>
import Container from '../../Components/Container.vue'
import Comment from '../../Components/Comment.vue'
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
    listing: Object,
    user: Object,
    canModify: Boolean,
    comments: Object,
    status: String,
    category_name: String
})
console.log(props.listing);
const deleteListing = () => {
    if (confirm('Are you sure you want to delete this listing?')) {
        router.delete(route('listings.destroy', listing.id))
    }
}

const shortenLink = (link) => {
    if (link.length > 40) {
        return link.slice(0, 40) + '...';
    }
}

const approved = (listing) => {
    let msg = listing.approved ? 'Do you want to DISAPPROVE this listing?' : 'Do you want to APPROVE this listing?';
    if (confirm(msg)) {
        router.put(route('admin.approve', listing.id))
    }
}
</script>

<template>

    <Head title="- Listing Details" />

    <!-- Admin -->
    <div v-if="$page.props.auth.user && $page.props.auth.user.role === 'admin'"
        class="flex items-center justify-between mb-6 p-6 bg-slate-800 text-white rounded-md font-medium">
        <p>This listing is {{ listing.approved ? "Approved" : "Disapproved" }}</p>
        <button @click.prevent="approved(listing)" class="px-3 py-1 rounded-md text-white"
            :class="listing.approved ? 'bg-red-500' : 'bg-green-500'">{{
                listing.approved ? 'Disapproved it' : 'Approved it'
            }}</button>
    </div>

    <!-- Breadcrumbs -->
    <div class="mb-4">
        <Link class="text-link font-bold" :href="route('home')">Home</Link>
        >
        <Link class="text-link font-bold" :href="route('category.index', { categoryId: listing.category_id })">
        {{ category_name }}
        </Link>
        >
        <a class="text-link font-bold">
            {{ listing.title ? listing.title.substring(0, 50) + ' ...' : listing.title }}
        </a>
    </div>

    <Container class="gap-4">
        <div class="flex gap-4 mb-6">
            <div class="w-1/4 rounded-md overflow-hidden">
                <img :src="props.listing.image ? `/storage/${listing.image}` : `/storage/images/listing/default.jpg`"
                    class="w-full h-full object-cover object-center">
            </div>

            <div class="w-3/4">
                <!-- Listing Info -->
                <div class="mb-6">
                    <div class="flex items-end justify-between mb-2">
                        <p class="w-full text-slate-400 border-b">Title</p>
                        <div v-if="canModify" class="pl-4 flex gap-2">
                            <Link :href="route('listings.edit', { listing })"
                                class="rounded-md bg-green-500 px-4 py-2 border text-white hover:outline outline-green-500 outline-offset-2">
                            Edit</Link>
                            <button @click="deleteListing"
                                class="rounded-md bg-red-500 px-4 py-2 border text-white hover:outline outline-red-500 outline-offset-2">
                                Delete</button>
                        </div>
                    </div>

                    <p class="text-2xl font-bold mb-4">{{ listing.title }}</p>
                </div>

                <!-- Contact Info -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <p class="w-full text-slate-400 border-b">Contact Info</p>
                    </div>
                    <!-- Email -->
                    <div v-if="listing.email" class="flex items-center mb-2 gap-2">
                        <i class="fa-solid fa-at"></i>
                        <p>Email:</p>
                        <a :href="`mailto:{{ listing.email }}`" class="text-link">{{ listing.email }}</a>
                    </div>
                    <!-- External Link -->
                    <div v-if="listing.link" class="flex items-center mb-2 gap-2">
                        <i class="fa-solid fa-up-right-from-square"></i>
                        <p>External Link:</p>
                        <a :href="listing.link" target="_blank" class="text-link">{{ shortenLink(listing.link) }}</a>
                    </div>
                    <!-- Name -->
                    <div v-if="user.name" class="flex items-center mb-2 gap-2">
                        <i class="fa-solid fa-user"></i>
                        <p>Edited by:</p>
                        <a :href="route('home', { user_id: user.id })" class="text-link">{{ user.name
                            }}</a>
                    </div>

                </div>

                <!-- Tag -->
                <div class="mb-6">
                    <p class="w-full text-slate-400 border-b mb-2">Tags</p>
                    <div class="flex items-center gap-3">
                        <div v-for="tag in listing.tags.split(',')" :key="tag">
                            <Link :href="route('home', { tag })"
                                class="rounded-full text-white bg-indigo-500 px-2 py-1 hover:bg-slate-700 dark:hover:bg-slate-900">
                            {{
                                tag }}
                            </Link>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <!-- Description -->
        <p v-html="listing.desc"></p>

    </Container>
    <Comment :listing="listing" :comments="comments" class="w-full" />
</template>