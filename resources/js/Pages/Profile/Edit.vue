<script setup>
import UpdateInfo from './Sections/UpdateInfo.vue';
defineProps({
    user: Object,
});
</script>

<template>

    <Head title=""></Head>
    <UpdateInfo :user="user" />
</template>