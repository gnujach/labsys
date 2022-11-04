<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Administración de Puestos {{ mouse.x }} + {{ mouse.y }}
            </h2>
            <div class="py-12">
                <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                    <h2>{{ mouse.x }} {{ mouse.y }}</h2>
                </div>
                <div class="mt-8 flex flex-row m-2">
                    <div class="relative flex-1">
                        <label for="search" class="sr-only">Buscar</label>
                        <input
                            @keyup.esc="reset()"
                            @blur="reset()"
                            v-model="term"
                            id="search"
                            class="px-4 w-full h-10 text-sm placeholder-gray-500 text-gray-700 rounded border border-gray-300 focus:border-orange-400 focus:outline-none focus:ring-0"
                            autocomplete="off"
                            name="search"
                            placeholder="Buscar puestos..."
                            type="text"
                        />
                        <ul
                            v-if="term"
                            class="absolute right-0 left-0 z-10 mb-4 w-full flex flex-col rounded-b-lg border border-t-0 border-b-0 border-gray-200 shadow-lg bg-white"
                        >
                            <li
                                v-for="(result, index) in results"
                                :key="index"
                                class="ml-4"
                            >
                                <jet-nav-link
                                    @mousedown.prevent
                                    class="p-4 text-sm font-medium border-b border-gray-200 cursor-pointer hover:bg-orange-50 block"
                                >
                                    {{ result.item }}
                                </jet-nav-link>
                            </li>

                            <li
                                v-if="!results.length"
                                class="ml-4 p-2 rounded-b-lg shadow my-0 text-sm"
                            >
                                Ningún Puesto para:
                                <strong>{{ term }}.</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
    </app-layout>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { reactive, ref } from "vue";
import { useMouse } from "@vueuse/core";
import { useFuse } from "@vueuse/integrations/useFuse";
import JetNavLink from "@/Components/NavLink.vue";

const data = [
    "John Smith",
    "John Doe",
    "Jane Doe",
    "Phillip Green",
    "Peter Brown",
];
const dataJson = [
    {
        title: "Old Man's War",
        author: "John Scalzi",
        tags: ["fiction"],
    },
    {
        title: "The Lock Artist",
        author: "Steve",
        tags: ["thriller"],
    },
];

const term = ref(null);
const options = {
    fuseOptions: {
        includeScore: true,
        keys: ["title", "tags.value"],
    },
};

const { results } = term ? useFuse(term, dataJson, options) : [];
// const results = [];

const mouse = reactive(useMouse());

const reset = () => {
    console.log(results.value);
    term.value = null;
};
</script>
