<script setup>
defineProps({
    status: String,
})
</script>

<template>
    <div class="mb-4 font-medium text-sm text-green-500">
        {{ status }}
    </div>
</template>