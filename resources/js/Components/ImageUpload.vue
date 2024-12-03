<script setup>
import { ref } from 'vue';

const emits = defineEmits(['image']);
const props = defineProps({
    listingImage: String
});
console.log(props.listingImage);
const currentImage = props.listingImage ? `/storage/${props.listingImage}` : null;
const isShowReload = ref(false);

const preview = ref(currentImage);
const oversizedImage = ref(false);

const imageSelected = (e) => {
    preview.value = URL.createObjectURL(e.target.files[0]);
    oversizedImage.value = e.target.files[0].size > 3145728;
    isShowReload.value = true;
    emits('image', e.target.files[0]);
}

const reloadImage = () => {
    preview.value = currentImage;
    oversizedImage.value = false;
    isShowReload.value = false;
    emits('image', null);

}

</script>

<template>
    <div>
        <span class="block text-sm font-medium text-slate-700 dark:text-slate-300"
            :class="{ '!text-red-500': oversizedImage }">
            {{ oversizedImage ? 'The selected image exceeds 3Mb' : 'Image (Max size 3Mb)' }}
        </span>
        <label for="image"
            class="relative block rounded-md mt-1 bg-slate-300 h-[140px] overflow-hidden cursor-pointer border-slate-300 border"
            :class="{ '!border-red-500': oversizedImage }">
            <img :src="preview ?? `/storage/images/listing/default.jpg`"
                class="absolute object-fit object-center h-full w-full" alt="" />
            <button v-if="isShowReload" @click.prevent="reloadImage"
                class="absolute top-2 right-2 bg-white grid place-items-center rounded-full w-8 h-8 hover:bg-slate-600 hover:text-white text-slate-700">
                <i class="fa-solid fa-rotate-left"></i>
            </button>
        </label>
        <input @change="imageSelected" id="image" name="image" type="file" hidden />
    </div>
</template>