<script setup>
// const props = defineProps(['listingImage']);
// const preview = ref(props.listingImage ? `/storage/images/user/${props.listingImage}` : `/storage/images/user/user.png`);
</script>

<template>
    <div>
        <label for="image" class="block rounded-md bg-slate-300 overflow-hidden cursor-pointer">
            <img :src="`/storage/images/user/user.png`" alt="" class="object-fit object-center h-[150px] w-[150px]" />
        </label>
        <input @change="imageSelected" id="image" name="image" type="file" hidden />
    </div>
</template>