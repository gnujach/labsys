<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Administración de Pacientes
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
                                        pacientes.data.pacientes.length.toString()
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
                                        @keydown="navigateResults"
                                        @keyup.esc="reset()"
                                        v-model="term"
                                        @blur="reset()"
                                        id="search"
                                        class="px-8 w-64 h-10 text-sm placeholder-gray-500 text-gray-700 rounded border border-gray-300 focus:border-orange-400 focus:outline-none focus:ring-0"
                                        autocomplete="off"
                                        name="search"
                                        placeholder="Buscar clientes..."
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
                                            :class="selectedIndex === index ? 'bg-gray-100': ''"
                                        >
                                            <jet-nav-link
                                                @mousedown.prevent
                                                :href="
                                                    result.item.data.links.self
                                                "
                                                class="p-4 text-sm font-medium border-b border-gray-200 cursor-pointer hover:bg-orange-50 block"
                                                :class="selectedIndex === index ? 'italic': ''"
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
                                            Ningún paciente para:
                                            <strong>{{ term }}.</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div
                                class="w-full flex md:justify-end justify-start"
                            >
                                <jet-nav-link
                                    :href="route('admin.pacientes/create', {})"
                                ><button
                                    class="border-green-700 border bg-white rounded mr-4 w-32 mb:w-42 p-1 hover:bg-aqua transition duration-500"
                                >
                                    <div class="flex flex-row">
                                        <plus-icon
                                            class="block w-6 h-6 fill-gray-400"
                                        />
                                        <p class="font-bold">
                                            Agregar Paciente
                                        </p>
                                    </div>
                                </button>
                                </jet-nav-link>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded shadow overflow-x-auto ml-4 mr-4"
                        >
                            <table class="w-full table-fixed">
                                <thead
                                    class="bg-gray-50 border-b-2 border-gray-200"
                                >
                                <tr
                                    class="p-3 text-sm font-semibold tracking-wide text-left"
                                >
                                    <th
                                        class="p-3 text-sm font-semibold tracking-wide text-left"
                                    >
                                        <div
                                            class="flex content-center items-center"
                                        >
                                            <SunIcon
                                                class="w-8 h-8 mr-2 text-indigo-900"
                                            />Nombre
                                        </div>
                                    </th>
                                    <th
                                        class="p-3 text-sm font-semibold tracking-wide text-left"
                                    >
                                        <div
                                            class="flex content-center items-center"
                                        >
                                            <SunIcon
                                                class="w-8 h-8 mr-2 text-indigo-900"
                                            />Edad
                                        </div>
                                    </th>
                                    <th
                                        class="p-3 text-sm font-semibold tracking-wide text-left"
                                    >
                                        <div
                                            class="flex content-center items-center"
                                        >
                                            <SunIcon
                                                class="w-8 h-8 mr-2 text-indigo-900"
                                            />Género
                                        </div>
                                    </th>
                                    <th
                                        class="p-3 text-sm font-semibold tracking-wide text-left"
                                    >
                                        <div
                                            class="flex content-center items-center"
                                        >
                                            <SunIcon
                                                class="w-8 h-8 mr-2 text-indigo-900"
                                            />Acciones
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                <tr
                                    v-for="paciente in pacientes.data.pacientes"
                                    :key="paciente.data.id"
                                    class="hover:bg-gray-100 focus-within:bg-gray-100"
                                    :class="[
                                        paciente.data.attributes.activo == 0
                                            ? 'text-gray-400'
                                            : '',
                                    ]"
                                >
                                    <td class="p-3 text-sm text-gray-700">
                                        <span
                                            class="p-1.5 text-xs font-medium uppercase tracking-wider text-blue-800 bg-blue-200 rounded-lg bg-opacity-50"
                                        >
                                            {{`${paciente.data.attributes.nombre} ${paciente.data.attributes.ap1} ${paciente.data.attributes.ap2 ? paciente.data.attributes.ap2 :''}`}}
                                        </span>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700">
                                        <p class="font-bold text-blue-500 hover:underline italic uppercase">
                                            {{ paciente.data.attributes.edad }}
                                        </p>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700">
                                        <p class="font-bold text-blue-500 hover:underline italic uppercase">
                                            {{ paciente.data.attributes.genero }}
                                        </p>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700">
                                        <div
                                            class="flex flex-row items-center text-gray-400 focus-within:text-gray-600"
                                        >
                                            <QueueListIcon
                                                class="w-5 h-5 ml-3 pointer-events-none"
                                            />
                                            <jet-nav-link v-if="$page.props.auth.permissions.includes('update-paciente')"
                                                          :href="
                                                    route(
                                                        'admin.pacientes/edit',
                                                        {
                                                            paciente: paciente.data
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
                                                    paciente.data.attributes
                                                        .activo
                                                "
                                                class="w-5 h-5 ml-3 pointer-events-none text-black"
                                            />
                                            <EyeIcon
                                                v-else
                                                class="w-5 h-5 ml-3 pointer-events-none text-gray-300"
                                            />
                                            <button @click="deleteAction(paciente.data.uuid)">
                                                <XMarkIcon
                                                    class="w-5 h-5 ml-3 pointer-events-none text-black"
                                                />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 pt-4">
                            <pagination :meta="pacientes.meta" />
                        </div>
                    </div>
                </div>
            </div>
            <DeleteDialog  @btn-delete="buttonClickDelete()"/>
        </template>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetNavLink from "@/Components/NavLink.vue";
import Pagination from "@/Components/Shared/Pagination.vue";
import { useFuse } from "@vueuse/integrations/useFuse";
import { ref, onMounted, computed, reactive } from "vue";
import {
    QueueListIcon,
    PencilIcon,
    EyeIcon,
    PlusIcon,
    SunIcon,
    XMarkIcon,
    MagnifyingGlassIcon,
} from "@heroicons/vue/24/outline";
import Card from "@/Components/Shared/Card.vue";
import {Inertia} from "@inertiajs/inertia";
import DeleteDialog from "@/Components/Dialogs/DeleteDialog.vue";
import { todoStore } from "@/stores/mainStore";

const stateStore = todoStore();
const props = defineProps({
    pacientes: Object,
});

const term = ref("");
const uuidDelete = ref(null);
const options = {
    fuseOptions: {
        includeScore: true,
        keys: ["data.attributes.cuname"],
    },
};

const { results } = useFuse(term, props.pacientes.data.pacientes, options);


const deleteAction = (uuid) => {
    uuidDelete.value = uuid;
    stateStore.exchangeDialogDelete();
}

const  buttonClickDelete = () => {
    Inertia.delete(route("admin.pacientes/delete", {
        paciente: uuidDelete.value
    }))
    stateStore.exchangeDialogDelete();
}
const reset = () => {
    term.value = "";
};
const selectedIndex = ref(0);
const navigateResults = (event) => {
    switch (event.code) {
        case "ArrowDown":
            if (selectedIndex.value === results.value.length - 1) {
                selectedIndex.value = 0;
            } else {
                selectedIndex.value += 1;
            }
            break;
        case "ArrowUp":
            if (selectedIndex.value === 0) {
                selectedIndex.value = results.value.length - 1;
            } else {
                selectedIndex.value -= 1;
            }
            break;
        case "Enter":
            Inertia.get(route('admin.pacientes/edit', {
                paciente: results.value[selectedIndex.value].item.data.uuid
            }));
            break;
    }
}
</script>
