<script setup>
defineProps({
    label: String,
})
</script>

<template>
    <div class="relative items-center mb-2">
        <div class="mr-4 font-bold text-lg">{{ label }}</div>
        <div class="absolute left-[15%] right-0 top-1/2 transform -translate-y-1/2 border-t-2 border-gray-500 z-0">
        </div>
    </div>
</template>