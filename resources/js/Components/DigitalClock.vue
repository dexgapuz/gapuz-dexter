<template>
    <div class="w-full lg:w-1/4 m-auto p-7 border-4 border-green-300 bg-green-400">
        <p class="font-bold text-white text-3xl flex justify-center">{{ currentTime.toLocaleDateString() }}</p>
        <p class="font-bold text-white text-6xl flex justify-center">{{ currentTime.toLocaleTimeString() }}</p>
    </div>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount, ref } from 'vue';

const currentTime = ref(new Date());
const interval = ref(null);

onBeforeMount(() => {
    interval.value = setInterval(() => {
        currentTime.value = new Date();
    }, 1000)
});

onBeforeUnmount(() => {
    clearInterval(interval.value);
});

</script>
