<template>
    <app-layout>
        <template #header class="mb-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alta de Estudio
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <jet-form-section
                @submit.prevent="saveEstudio"
            >
                <template #title> Estudio</template>
                <template #description> Alta de Estudio</template>
                <!-- nombre -->
                <template #form class="col-span-2">
                    <div class="grid grid-cols-3 gap-4 grid-flow-row items-center justify-center">
                            <div class="flex flex-col">
                                <jet-label for="nombre" value="Nombre" />
                                <jet-input
                                    id="nombre"
                                    type="text"
                                    class="mt-1 block w-full uppercase"
                                    v-model="form.nombre"
                                    autocomplete="nombre"
                                    autofocus
                                />
                                <jet-input-error
                                    :message="form.errors.nombre"
                                    class="mt-2"
                                />
                            </div>
                            <div class="flex flex-col"><!-- clave -->
                                    <jet-label for="clave" value="Clave de estudio" />
                                    <jet-input
                                        id="clave"
                                        type="text"
                                        class="mt-1 block w-full uppercase"
                                        v-model="form.clave"
                                        autocomplete="clave"
                                    />
                                    <jet-input-error
                                        :message="form.errors.clave"
                                        class="mt-2"
                                    />
                            </div>
                            <!-- costo -->
                            <div class="flex flex-col">
                                <jet-label for="costo" value="Costo" />
                                <CurrencyInput
                                    v-model="form.costo"
                                    :options="{ currency: 'MXN', locale:'es-MX' , autoDecimalDigits: true}"
                                    @blur="calcularGanancia"
                                    disabled
                                />
                                <jet-input-error
                                    :message="form.errors.costo"
                                    class="mt-2"
                                />
                            </div>
                        <!-- ganancia -->
                            <div class="flex flex-col">
                                <jet-label for="ganancia" value="Ganancia Pesos" />
                                <CurrencyInput
                                    v-model="form.ganancia"
                                    :options="{ currency: 'MXN', locale:'es-MX', autoDecimalDigits: true}"
                                    @blur="calcularGanancia"
                                />
                                <jet-input-error
                                    :message="form.errors.ganancia"
                                    class="mt-2"
                                />
                            </div>
                        <!-- Precio venta publico -->
                        <div class="flex flex-col">
                            <jet-label for="grupo_id" value="Precio de venta público general" />
                            <CurrencyInput
                                v-model="form.precio_mostrador"
                                :options="{ currency: 'MXN', locale:'es-MX', autoDecimalDigits: true}"
                            />
                            <jet-input-error
                                :message="form.errors.precio_mostrador"
                                class="mt-2"
                            />
                        </div>
                        <!-- precio_preferencial -->
                        <div class="flex flex-col">
                            <jet-label for="precio_preferencial" value="Precio de venta preferencial" />
                            <CurrencyInput
                                v-model="form.precio_preferencial"
                                :options="{ currency: 'MXN', locale:'es-MX', autoDecimalDigits: true}"
                            />
                            <jet-input-error
                                :message="form.errors.precio_preferencial"
                                class="mt-2"
                            />
                        </div>
                                <!-- Categoria -->
                                <div class="">
                                    <div class="flex flex-col">
                                        <jet-label for="tipo_categoria" value="Categoría"
                                                   class="text-lg font-semibold"/>
                                        <BaseListbox
                                            :options="ListCategorias"
                                            placeholder="Seleccione Categoría"
                                            v-model="form.categoria_id"
                                        />
                                        <jet-input-error
                                            :message="form.errors.categoria_id"
                                            class="mt-2"
                                        />
                                    </div>
                                </div>
                        <!-- Grupo -->
                            <div class="flex flex-col">
                                <jet-label for="tipo_estudio" value="Grupo de Estudio"
                                           class="text-lg font-semibold"/>
                                <BaseListbox
                                    :options="ListGrupos"
                                    placeholder="Seleccione Grupo"
                                    v-model="form.grupo_id"
                                />
                                <jet-input-error
                                    :message="form.errors.grupo_id"
                                    class="mt-2"
                                />
                            </div>
                        <!-- Activo -->
                        <div class="flex flex-col justify-center items-center">
                            <jet-label for="Activo" value="Activo" />
                            <Switch
                                v-model="form.activo"
                                name="enabled"
                                :class="form.activo ? 'bg-teal-900' : 'bg-gray-200'"
                                class="relative inline-flex h-6 w-11 items-center rounded-full"
                            >
                                <span class="sr-only">Activar</span>
                                <span
                                    :class="form.activo ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block h-4 w-4 transform rounded-full bg-white"
                                />
                            </Switch>
                        </div>
                    </div>
                    <ModalSearch/>
                    <div class="grid grid-cols-2 gap-4 grid-flow-row items-start ring-1 max-h-64 h-64 overflow-y-scroll">
                        <div class="overflow-y-auto">
                            <div class="flex flex-col overflow-y-auto">
                                <div class="flex flex-row justify-around bg-blue-400">
                                    <div class="italic">Estudios en Paquete</div>
                                    <div class="italic">Total {{form.items.length}}</div>
                                </div>
                                <div class="bg-white rounded shadow ml-4 mr-4 ">
                                    <table class="w-full table-fixed overflow-y-auto">
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
                                                    />Cantidad
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
                                                    />Costo
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
                                            <tr v-for="(paquete, i) in form.items"
                                                class="hover:bg-gray-100 focus-within:bg-gray-100"
                                            >
                                                <td class="p-3 text-sm text-gray-700"> {{paquete.nombre}}</td>
                                                <td class="p-3 text-sm text-gray-700"> {{paquete.cantidad}}</td>
                                                <td class="p-3 text-sm text-gray-700">
                                                    <span class="w-20">
                                                        ${{paquete.costo}}
                                                    </span>
                                                </td>
                                                <button class="bg-red-200 rounded-md ring-1 m-4 p-2 " @click.prevent="deleteItem(i)"> Eliminar </button>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="m-2.5 bg-blue-400 rounded-md flex flex-row items-start justify-around">
                                    <span>Items</span>
                                    <span>Select</span>
                                    <div class="flex flex-row m-2 w-64 items-start ">
                                        <div class="relative flex-1 items-start">
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
                                                placeholder="Buscar estudios..."
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
                                                    v-for="(result, index) in results" :key="index"
                                                    class="ml-4 uppercase"
                                                    :class="selectedIndex === index ? 'bg-gray-100': ''"
                                                >
                                                    <button
                                                        preserve-state
                                                        @mousedown.prevent
                                                        class="p-4 text-sm font-medium border-b border-gray-200 cursor-pointer hover:bg-orange-50 block"
                                                        :class="selectedIndex === index ? 'italic': ''"
                                                        @click.prevent="addItem(result.item)"
                                                    >
                                                        {{
                                                            result.item.data.attributes
                                                                .nombre
                                                        }}
                                                    </button>
                                                </li>

                                                <li
                                                    v-if="!results.length"
                                                    class="ml-2 p-2 rounded-b-lg shadow my-0 text-sm"
                                                >
                                                    Ningún estudio para:
                                                    <strong>{{ term }}.</strong>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <!-- fin buscar -->
                            </div>
                            <div class="grid grid-cols-4">
                                    <div v-for="item in AllItems" class="grid">
                                           <button class="bg-green-200 rounded-md ring-1 m-4 p-2 lowercase" @click.prevent="addItem(item)"> {{item.data.attributes.nombre}} </button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template #actions>
                    <jet-action-message
                        :on="form.recentlySuccessful"
                        class="mr-3"
                    >
                        Guardado!!
                    </jet-action-message>
                    <jet-section-border />
                    <jet-button
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Guardar
                    </jet-button>
                </template>
            </jet-form-section>
        </div>
    </app-layout>
</template>
<script setup>
import {ref, onMounted, watch} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Components/PrimaryButton.vue";
import JetFormSection from "@/Components/FormSectionVentas.vue"
import JetInput from "@/Components/TextInput.vue";
import CurrencyInput  from "@/Components/CurrencyInput.vue";
import JetInputError from "@/Components/InputError.vue";
import JetLabel from "@/Components/InputLabel.vue";
import JetActionMessage from "@/Components/ActionMessage.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import JetSectionBorder from "@/Components/SectionBorder.vue";
import {ComboboxLabel, Switch} from "@headlessui/vue";
import BaseListbox from "@/Components/Shared/BaseListbox.vue";
import ModalSearch from "../../Components/Dialogs/ModalSearch.vue";
import { useFuse } from "@vueuse/integrations/useFuse";
import { SunIcon, MagnifyingGlassIcon, XMarkIcon} from "@heroicons/vue/20/solid";
import {Inertia} from "@inertiajs/inertia";
import JetNavLink from "@/Components/NavLink.vue";


const props = defineProps(['grupos', 'categorias', 'items']);
const form = useForm({
    nombre:null,
    clave: null,
    tipoventa_id:1,
    grupo_id:null,
    categoria_id:null,
    costo:0,
    ganancia:0,
    precio_mostrador: 0,
    precio_preferencial:0,
    activo: true,
    items: []
});

const selectedIndex = ref(0);
const term = ref("");
const options = {
    fuseOptions: {
        includeScore: true,
        keys: ["data.attributes.nombre"],
    },
};
const { results } = useFuse(term, props.items.data.estudios, options);
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
            let elem = event.target;
            elem.click.prevent=addItem(results.value[selectedIndex.value].item)
            console.log(elem)
            // addItem(results.value[selectedIndex.value].item)
            event.prevent
            break;
    }
}

const reset = () => {
    term.value = "";
};
const ListGrupos = ref(props.grupos);
const ListCategorias= ref(props.categorias);
const it = ref(null);

// const AllItems = computed(() => {
//         return props.items
//     })


const AllItems = ref(props.items.data.estudios);
const calcularGanancia = () => {
    form.precio_mostrador = form.costo + form.ganancia
    form.precio_preferencial = form.costo + form.ganancia
}
const paquetes = ref(null);

onMounted (() => {
    paquetes.value = [...props.items.data.estudios];
})

const addItem =  (item) => {
    form.items.push({
        id: item.data.id,
        uuid: item.data.uuid,
        nombre: item.data.attributes.nombre,
        costo: item.data.attributes.costo,
        cantidad: 1,
    })

    // console.log(props.items.data.estudios.length)
    AllItems.value.splice(AllItems.value.findIndex( e => e.data.uuid === item.data.uuid), 1);
    // console.log(props.items.data.estudios.length)
    // console.log(paquetes.value.length)
}
const deleteItem = (index) => {
    let element = form.items[index];
    let item = paquetes.value.find(e => e.data.uuid === element.uuid)
    form.items.splice(index,1);
    AllItems.value.push(item)
}
const saveEstudio = () => {
    console.log(form);
    form.transform((data) => ({
        ...data,
    })).post(route("admin.estudios/storepaquete"), {
        preserveState: true,
    });
    if (form.wasSuccessful) {
        form.reset();
    }
};
watch(form.items, () => {
    let subtotal = 0;
    form.items.forEach((i)=> {
        subtotal = subtotal + parseFloat(i.costo)
    })
    parseFloat(subtotal)
    form.costo = subtotal;
})
</script>
