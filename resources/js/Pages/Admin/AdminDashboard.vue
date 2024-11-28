<script setup>
import PaginationLinks from '../../Components/PaginationLinks.vue';
import RoleSelect from '../../Components/RoleSelect.vue';
import SessionMessages from '../../Components/SessionMessages.vue';
import InputField from '../../Components/InputField.vue';
import { useForm, router } from "@inertiajs/vue3";

const params = route().params;
const props = defineProps({
    users: Object,
    status: String
})

const form = useForm({
    search: '',
    role: params.role || '',
})
const submit = () => {
    router.get(route('admin.index'), { search: form.search });
}

const showOnlyRole = (e) => {
    const roleValue = e.target.value;
    if (!roleValue) {
        router.get(route('admin.index', { ...params, role: null }));
    } else {
        router.get(route('admin.index', { ...params, role: roleValue }));
    }
}

</script>

<template>

    <Head title="- Admin" />
    <SessionMessages :status="status" />
    <div class="flex mb-2 justify-between">
        <form @submit.prevent="submit" class="flex items-center gap-2">
            <InputField v-model="form.search" label="" icon="magnifying-glass" placeholder="Search" type="search">
            </InputField>
            <Link v-if="params.search" :href="route('admin.index', { ...params, search: null, page: null })"
                class="flex items-center rounded-md bg-indigo-500 text-white px-2 py-1">
            {{ params.search }} <i class="fas fa-times ml-2"></i>
            </Link>
        </form>

        <!-- Show only role -->
        <div class="flex items-center">
            <p class="mr-2">Show only</p>
            <form @change="showOnlyRole">
                <label for="roles" class="sr-only">Roles:</label>
                <select v-model="form.role" name="roles"
                    class="text-slate-800 bg-slate-200 border-0 outline-0 rounded-lg text-sm py-1">
                    <option value="">All</option>
                    <option value="admin">Admin</option>
                    <option value="general">General</option>
                    <option value="suspended">Suspended</option>
                </select>
            </form>
        </div>

    </div>
    <table class="bg-white dark:bg-slate-800 w-full rounded-lg overflow-hidden ring-1 ring-slate-300">
        <thead>
            <tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
                <th class="w-3/6 p-3">Name</th>
                <th class="w-2/6 p-3">Role</th>
                <th class="w-1/6 p-3">Listings</th>
                <th class="w-1/6 p-3 text-right">View</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-300 divide-dashed">
            <tr v-for="(user, index) in users.data" :key="index">
                <td class="w-3/6 py-5 px-3">
                    <div class="font-bold mb-1">{{ user.name }}</div>
                    <div class="font-light">{{ user.email }}</div>
                </td>
                <td class="w-2/6 py-5 px-3">
                    <RoleSelect :user="user" />
                </td>
                <td class="w-1/6 py-5 px-3 gap-6">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1">{{ user.listings.filter(l => l.approved).length }} <i
                                class="fa-solid fa-circle-check text-green-500"></i></div>
                        <div class="flex items-center gap-1">{{ user.listings.filter(l => !l.approved).length }} <i
                                class="fa-solid fa-circle-xmark text-red-500"></i>
                        </div>
                    </div>
                </td>
                <td class="w-1/6 py-5 px-5 text-right">
                    <Link :href="route('user.show', user.id)" class="fa-solid fa-up-right-from-square text-indigo-500">
                    </Link>
                </td>
            </tr>
        </tbody>

    </table>
    <PaginationLinks class="mt-6" :paginator="users" />
</template>