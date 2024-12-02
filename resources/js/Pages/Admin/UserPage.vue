<script setup>
import Title from '../../Components/Title.vue';
import PaginationLinks from '../../Components/PaginationLinks.vue';
import InputField from '../../Components/InputField.vue';
import { useForm, router } from "@inertiajs/vue3";
import SessionMessages from '../../Components/SessionMessages.vue';

const params = route().params;
const props = defineProps({
    user: Object,
    listings: Object,
    status: String,
});
const form = useForm({
    search: params.search,
})

const submit = () => {
    router.get(route('user.show', { user: props.user.id, search: form.search, disapproved: params.disapproved }))
}

const showDisapprovedListing = (e) => {
    if (e.target.checked) {
        router.get(route('user.show', { user: props.user.id, search: params.search, disapproved: true }))
    } else {
        router.get(route('user.show', { user: props.user.id, search: params.search, disapproved: null }))
    }
}

const approveListing = (listing) => {
    let msg = listing.approved ? 'You want to DISAPPROVE this listing?' : 'You want to APPROVE this listing?';
    if (confirm(msg)) {
        router.put(route('admin.approve', listing.id))
    }
}
</script>

<template>

    <Head :title="`- ${user.name} Listings`" />
    <div class="mb-6">
        <Title>"{{ user.name }}" latest listings</Title>
        <SessionMessages :status="status" />

        <div class="flex items-center justify-between mb-2">
            <!-- Search form -->
            <div>
                <form @submit.prevent="submit" class="flex items-center gap-2">
                    <InputField label="" v-model="form.search" icon="magnifying-glass" placeholder="Search"
                        type="search">
                    </InputField>
                    <Link v-if="params.search" :href="route('user.show', { ...params, search: null, page: null })"
                        class="flex items-center rounded-md bg-indigo-500 text-white px-2 py-1">
                    {{ params.search }} <i class="fas fa-times ml-2"></i>
                    </Link>
                </form>
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
        </div>

        <table class="bg-white dark:bg-slate-800 w-full rounded-lg overflow-hidden ring-1 ring-slate-300">
            <thead>
                <tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
                    <th class="w-4/6 p-3">Title</th>
                    <th class="w-2/6 p-3 text-center">Approved</th>
                    <th class="w-1/6 p-3 text-right">View</th>
                </tr>
            </thead>
            <tbody v-if="listings.data.length" class="divide-y divide-slate-300 divide-dashed">
                <tr v-for="(listing, index) in listings.data" :key="index">
                    <td class="w-4/6 py-5 px-3">
                        <div class="font-bold">{{ listing.title }}</div>
                    </td>
                    <td class="w-2/6 py-5 px-3 text-2xl text-center">
                        <button @click.prevent="approveListing(listing)">
                            <i :class="`fa-solid fa-${listing.approved
                                ? 'circle-check text-green-500'
                                : 'circle-xmark text-red-500'}`"></i>
                        </button>
                    </td>
                    <td class="w-1/6 py-5 px-5 text-right">
                        <Link :href="route('listings.show', listing.id)"
                            class="fa-solid fa-up-right-from-square text-indigo-500">
                        </Link>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="3" class="text-center py-5">No listings found.</td>
                </tr>
            </tbody>
        </table>
        <PaginationLinks class="mt-6" :paginator="listings" />
    </div>
</template>