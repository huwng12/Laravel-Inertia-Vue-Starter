<script setup>
import Title from '../Components/Title.vue'
import PaginationLinks from '../Components/PaginationLinks.vue'
import SessionMessages from '../Components/SessionMessages.vue'
import { router } from '@inertiajs/vue3';

const params = route().params;

const props = defineProps({
    listings: Object,
    status: String
})
const deleteListing = (id) => {
    if (confirm('Are you sure you want to delete this listing?')) {
        router.delete(route('listings.destroy', id));
    }
}

const showDisapprovedListing = (e) => {
    if (e.target.checked) {
        router.get(route('dashboard', { disapproved: true }))
    } else {
        router.get(route('dashboard', { disapproved: null }))
    }
}
</script>

<template>

    <Head title="- Dashboard" />
    <div v-if="listings">
        <div v-if="Object.keys(listings.data).length">
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <Title>Dashboard</Title>
                    <div class="flex items-end gap-4">

                        <p>Approved <i class="fa-solid fa-circle-check text-green-500"></i></p>
                        <p>Pending Approved <i class="fa-solid fa-circle-xmark text-red-500"></i></p>
                    </div>
                </div>
                <!-- Show disapproved listings -->
                <div class="flex items-center gap-1 hover:bg-slate-300 dark:hover:bg-slate-800 rounded-md px-2 py-1">
                    <input id="showDisapprovedListing" @input="showDisapprovedListing" :checked="params.disapproved"
                        class="rounded-full border-1 outline-0 text-indigo-500 ring-indigo-500 border-slate-700 cursor-pointer"
                        type="checkbox"></input>
                    <label for="showDisapprovedListing"
                        class="block font-bold text-sm cursor-pointer text-slate-700 dark:text-slate-300">Show
                        disapproved
                        listings</label>
                </div>
                <SessionMessages :status="status" />
                <table
                    class="w-full table-fixed border-collapse overflow-hidden rounded-md text-sm ring-1 ring-slate-300 dark:ring-slate-800 bg-white shadow-lg">
                    <thead class="text-slate-600 dark:text-slate-400 bg-slate-300 dark:bg-slate-900 text-sm uppercase">
                        <tr>
                            <th class="w-3/4 text-left p-3">Title</th>
                            <th class="w-1/4 text-right pr-3 py-3">View</th>
                            <th class="w-1/5 text-right pr-3 py-3">Edit</th>
                            <th class="w-1/5 text-right pr-3 py-3">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="listing in listings.data" :key="listing.id">
                            <td class="flex w-3/4 text-left p-3">
                                <Link class="flex items-center gap-2">
                                <img :src="listing.image ? `/storage/${listing.image}` : `/storage/images/listing/default.jpg`"
                                    class="w-10 h-10 rounded-full object-cover object-center" alt="listing image">
                                <h4 class="font-bold text-black">{{ listing.title }}
                                    <i
                                        :class="listing.approved ? 'fa-solid fa-circle-check text-green-500' : 'fa-solid fa-circle-xmark text-red-500'">
                                    </i>
                                </h4>
                                </Link>
                            </td>
                            <td class="w-1/4 text-right pr-3 py-3">
                                <div>
                                    <Link v-if="$page.props.auth.user.role === 'admin' || (listing.approved)"
                                        :href="route('listings.show', listing.id)" class="text-link">View</Link>
                                </div>
                            </td>
                            <td class="w-1/5 text-right pr-3 py-3">
                                <div>
                                    <Link :href="route('listings.edit', listing.id)" class="text-link">Edit</Link>
                                </div>
                            </td>
                            <td class="w-1/5 text-right pr-3 py-3 text-red-500">
                                <div>
                                    <button type="button" @click.prevent="deleteListing(listing.id)">Delete</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <PaginationLinks :paginator="listings" />
            </div>
        </div>
        <div v-else>
            There is no listing available
        </div>
    </div>
</template>