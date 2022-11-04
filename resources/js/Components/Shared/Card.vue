<template>
    <div
        class="flex flex-col justify-between overflow-hidden text-left shadow-xl group"
    >
        <div class="p-5">
            <div class="flex flex-row justify-between">
                <div
                    class="flex items-center justify-center w-10 h-10 mb-4 rounded-full bg-indigo-50"
                >
                    <SunIcon class="w-8" />
                </div>
                <p class="mb-2 font-bold">{{ title }}</p>
            </div>
            <p class="text-sm leading-5 text-gray-900">
                {{ descripcion }}
            </p>
        </div>
        <div
            class="w-full h-1 ml-auto duration-300 origin-left transform scale-x-0 bg-deep-purple-accent-400 group-hover:scale-x-100"
        ></div>
    </div>
</template>
<script setup>
import { SunIcon } from "@heroicons/vue/24/outline";
const props = defineProps({
    title: String,
    descripcion: String,
    href: String,
});
</script>
