<template>
    <div class="flex flex-col min-h-screen justify-center items-center">
        <div class="w-full lg:w-1/4 mb-4 p-7 border-4 border-green-300 bg-green-400">
            <VueDatePicker class="mb-3" @update:model-value="handleDatePicked" @cleared="handleClear"></VueDatePicker>
            <p class="font-bold text-white text-3xl flex justify-center">{{ currentTime.toLocaleDateString() }}</p>
            <p class="font-bold text-white text-6xl flex justify-center">{{ currentTime.toLocaleTimeString() }}</p>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount, ref } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';

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

const handleDatePicked = (data) => {
    if (data) {
        clearInterval(interval.value);
        interval.value = null;
        currentTime.value = data;
    }
}

const handleClear = () => {
    currentTime.value = new Date();
    interval.value = setInterval(() => {
        currentTime.value = new Date();
    }, 1000)
}

</script>
