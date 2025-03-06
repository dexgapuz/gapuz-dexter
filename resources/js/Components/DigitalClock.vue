<template>
    <div class="flex flex-col min-h-screen justify-center items-center">
        <div class="w-full lg:w-1/4 mb-4 p-7 border-4" :class="scheduleResponse.isOpen ? 'border-green-300 bg-green-400' : 'border-rose-300 bg-rose-400'">
            <VueDatePicker class="mb-3" v-model="selectedDateTime" @update:model-value="handleDatePicked" @cleared="handleClear"></VueDatePicker>
            <p class="font-bold text-white text-3xl flex justify-center">{{ currentDateTime.toLocaleDateString() }}</p>
            <p class="font-bold text-white text-6xl flex justify-center">{{ currentDateTime.toLocaleTimeString() }}</p>
        </div>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" v-if="!scheduleResponse.isOpen">
            <strong class="font-bold">{{ scheduleResponse.message }}</strong>
        </div>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" v-if="scheduleResponse.isOpen">
            <strong class="font-bold">{{ scheduleResponse.message }}</strong>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount, reactive, ref, watch } from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';

const currentDateTime = ref(new Date());
const selectedDateTime = ref();
const interval = ref(null);
const scheduleResponse = reactive({
    isOpen: false,
    message: ''
});

onBeforeMount(() => {
    interval.value = setInterval(() => {
        currentDateTime.value = new Date();
    }, 1000)
});

onBeforeUnmount(() => {
    clearInterval(interval.value);
});

watch(currentDateTime, (dateTime, prevTime) => {
    getSchedule();
});

const handleDatePicked = (data) => {
    if (data) {
        clearInterval(interval.value);
        interval.value = null;
        currentDateTime.value = data;
    }
}

const handleClear = () => {
    currentDateTime.value = new Date();
    interval.value = setInterval(() => {
        currentDateTime.value = new Date();
    }, 1000)
}

const getSchedule = () => {
    const params = new URLSearchParams();
    const dateFormat = currentDateTime.value.toLocaleString('sv').replace(' ', 'T');
    params.append('date', dateFormat);

    fetch(`/schedule?${params}`, {
        method: 'GET'
    })
    .then(response => response.json())
    .then((data) => {
        scheduleResponse.isOpen = data.isOpen;
        scheduleResponse.message = data.message;
    });
}

</script>
