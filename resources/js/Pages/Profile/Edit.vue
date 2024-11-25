<script setup>
import DeleteAccount from './Sections/DeleteAccount.vue';
import UpdateInfo from './Sections/UpdateInfo.vue';
import UpdatePassword from './Sections/UpdatePassword.vue';
defineProps({
    user: Object,
    status: String,
});
</script>

<template>

    <Head title="- Profile"></Head>
    <UpdateInfo :user="user" :status="status" />
    <UpdatePassword :user="user" :status="status" />
    <DeleteAccount />
</template>