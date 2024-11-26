<script setup>
import Container from '../../Components/Container.vue'
import Title from '../../Components/Title.vue'

const props = defineProps({
    listing: Object,
    user: Object,
    canModify: Boolean
})
const deleteListing = () => {
    if (confirm('Are you sure you want to delete this listing?')) {
        router.delete(route('listings.destroy', listing.id))
    }
}
</script>

<template>

    <Head title="- Listing Details" />

    <Container class="flex gap-4">
        <div class="w-1/4 rounded-md overflow-hidden">
            <img :src="props.listing.image ? `/storage/${listing.image}` : `/storage/images/listing/default.jpg`"
                class="w-full h-full object-cover object-center">
        </div>

        <div class="w-3/4">
            <!-- Listing Info -->
            <div class="mb-6">
                <div class="flex items-end justify-between mb-2">
                    <p class="w-full text-slate-400 border-b">Listing Details</p>
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
                <p>{{ listing.desc }}</p>
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
                    <a :href="listing.link" target="_blank" class="text-link">{{ listing.link }}</a>
                </div>
                <!-- Name -->
                <div v-if="user.name" class="flex items-center mb-2 gap-2">
                    <i class="fa-solid fa-up-right-from-square"></i>
                    <p>External Link:</p>
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
    </Container>
</template>