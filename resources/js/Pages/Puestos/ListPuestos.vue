<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Administración de Puestos
            </h2>
            <div class="py-12">
                <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden sm:rounded-lg">
                        <div class="p-6 sm:px-20 lg:px-2 bg-white">
                            <div
                                class="relative grid gap-5 sm:grid-flow-col lg:grid-cols-3 md:justify-between"
                            >
                                <Card
                                    title="Total"
                                    :descripcion="
                                        puestos.data.puestos.length.toString()
                                    "
                                    href="#"
                                />
                                <Card
                                    title="Total"
                                    descripcion="Una descripcion"
                                    href="#"
                                />
                                <Card
                                    title="Total"
                                    descripcion="Una descripcion"
                                    href="#"
                                />
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="mt-8 flex flex-row m-2 w-64">
                                <div class="relative flex-1">
                                    <label for="search" class="sr-only"
                                        >Buscar</label
                                    >
                                    <input
                                        @keyup.esc="reset()"
                                        v-model="term"
                                        @blur="reset()"
                                        id="search"
                                        class="px-8 w-64 h-10 text-sm placeholder-gray-500 text-gray-700 rounded border border-gray-300 focus:border-orange-400 focus:outline-none focus:ring-0"
                                        autocomplete="off"
                                        name="search"
                                        placeholder="Buscar puestos..."
                                        type="text"
                                    />
                                    <button
                                        v-if="term"
                                        @click="reset()"
                                        class="absolute top-0 right-0 mt-2 text-orange-500 hover:text-orange-600 focus:outline-none"
                                    >
                                        <XMarkIcon class="w-6 h-6" />
                                    </button>
                                    <button
                                        @click="reset()"
                                        class="absolute top-0 left-2 mt-2 text-gray-600 hover:text-gray-600 focus:outline-none"
                                    >
                                        <MagnifyingGlassIcon class="w-6 h-6" />
                                    </button>
                                    <ul
                                        v-if="term"
                                        class="absolute right-0 left-0 z-10 mb-4 w-64 flex flex-col rounded-b-lg border border-t-0 border-b-0 border-gray-200 shadow-lg bg-white"
                                    >
                                        <li
                                            v-for="(result, index) in results"
                                            :key="index"
                                            class="ml-4 uppercase"
                                        >
                                            <jet-nav-link
                                                @mousedown.prevent
                                                :href="
                                                    result.item.data.links.self
                                                "
                                                class="p-4 text-sm font-medium border-b border-gray-200 cursor-pointer hover:bg-orange-50 block"
                                            >
                                                {{
                                                    result.item.data.attributes
                                                        .nombre
                                                }}
                                            </jet-nav-link>
                                        </li>

                                        <li
                                            v-if="!results.length"
                                            class="ml-2 p-2 rounded-b-lg shadow my-0 text-sm"
                                        >
                                            Ningún Puesto para:
                                            <strong>{{ term }}.</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div
                                class="w-full flex md:justify-end justify-start"
                            >
                                <jet-nav-link
                                    :href="route('admin.puestos/create', {})"
                                    ><button
                                        class="border-green-700 border bg-white rounded mr-4 w-32 mb:w-42 p-1 hover:bg-aqua transition duration-500"
                                    >
                                        <div class="flex flex-row">
                                            <plus-icon
                                                class="block w-6 h-6 fill-gray-400"
                                            />
                                            <p class="font-bold">
                                                Agregar Puesto de trabajo
                                            </p>
                                        </div>
                                    </button>
                                </jet-nav-link>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded shadow overflow-x-auto ml-4 mr-4"
                        >
                            <table class="w-full">
                                <tr class="text-left font-bold bg-aqua">
                                    <th class="px-6 pt-6 pb-4">
                                        <div
                                            class="flex content-center items-center"
                                        >
                                            <SunIcon
                                                class="w-8 h-8 mr-2 text-indigo-900"
                                            />Nombre
                                        </div>
                                    </th>
                                    <th class="px-6 pt-6 pb-4">
                                        <div class="flex items-end justify-end">
                                            <SunIcon
                                                class="w-8 h-8 mr-2 text-indigo-900"
                                            />Acciones
                                        </div>
                                    </th>
                                </tr>
                                <tr
                                    v-for="puesto in puestos.data.puestos"
                                    :key="puesto.data.id"
                                    class="hover:bg-gray-100 focus-within:bg-gray-100"
                                    :class="[
                                        puesto.data.attributes.activo == 0
                                            ? 'text-gray-400'
                                            : '',
                                    ]"
                                >
                                    <td class="border-t">
                                        <p class="pl-4 font-bold uppercase">
                                            {{ puesto.data.attributes.nombre }}
                                        </p>
                                    </td>
                                    <td class="border-t">
                                        <div
                                            class="flex flex-row items-center justify-end text-gray-400 focus-within:text-gray-600 mr-4"
                                        >
                                            <QueueListIcon
                                                class="w-5 h-5 ml-3 pointer-events-none"
                                            />
                                            <jet-nav-link
                                                :href="
                                                    route(
                                                        'admin.puestos/edit',
                                                        {
                                                            puesto: puesto.data
                                                                .uuid,
                                                        }
                                                    )
                                                "
                                            >
                                                <PencilIcon
                                                    class="w-5 h-5 ml-3 pointer-events-none"
                                                />
                                            </jet-nav-link>
                                            <EyeIcon
                                                v-if="
                                                    puesto.data.attributes
                                                        .activo
                                                "
                                                class="w-5 h-5 ml-3 pointer-events-none"
                                            />
                                            <CheckBadgeIcon
                                                v-else
                                                class="w-5 h-5 ml-3 pointer-events-none"
                                            />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 pt-4">
                            <pagination :meta="puestos.meta" />
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetNavLink from "@/Components/NavLink.vue";
import Pagination from "@/Components/Shared/Pagination.vue";
import { fuseComposable } from "../../Composables/fuseComposable";
import { useFuse } from "@vueuse/integrations/useFuse";
import { ref, onMounted, computed, reactive } from "vue";
import {
    QueueListIcon,
    PencilIcon,
    EyeIcon,
    CheckBadgeIcon,
    PlusIcon,
    SunIcon,
    XMarkIcon,
    MagnifyingGlassIcon,
} from "@heroicons/vue/24/outline";
import { useMouse } from "@vueuse/core";
import Card from "@/Components/Shared/Card.vue";

const props = defineProps({
    puestos: Object,
});

const term = ref("");

const options = {
    fuseOptions: {
        includeScore: true,
        keys: ["data.attributes.nombre"],
    },
};

const { results } = useFuse(term, props.puestos.data.puestos, options);

const reset = () => {
    term.value = "";
};
</script>
