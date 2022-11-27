<template>
    <app-layout>
        <template #header class="mb-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alta de Estudio
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <jet-form-section
                @submitted="saveEstudio"
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
import {ref, computed} from "vue";
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
const props = defineProps(['grupos', 'tipoventas', 'categorias']);
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
});

const ListGrupos = ref(props.grupos);
const ListCategorias= ref(props.categorias);
const ListTipoventas= ref(props.tipoventas);
const p_ganancia = ref(20);
const unformatted = ref(null);
const formatted = ref(null);
const formattedCashMoney = computed({
    get() {
        return formatted.value;
    },
    set(newVal) {
        let val = removeMask(newVal)
        formatted.value = wearMask(unformatted.value)
    }
})

const calcularGanancia = () => {
    form.precio_mostrador = form.costo + form.ganancia
    form.precio_preferencial = form.costo + form.ganancia
    // let porcentajeDecimal = parseFloat(p_ganancia.value /100);
    // form.ganancia = parseFloat(parseFloat(form.costo) * porcentajeDecimal);
    // form.precio_mostrador = parseFloat(parseFloat(form.costo) + parseFloat(form.costo * porcentajeDecimal));
    // form.precio_preferencial = parseFloat(parseFloat(form.costo) + parseFloat(form.costo * porcentajeDecimal));
}

const formatCashMoney = (event) => {
    console.log("@keydown")
    let key = event.key;
    if (!/^\d+/g.test(key)) {
        event.preventDefault();
        return
    }
    formatted.value = wearMask(event.target.value)

}

const formatInput = (event) => {
    console.log("Event @input")
    unformatted.value = removeMask(event.target.value)
    formatted.value = wearMask(event.target.value)
}
const wearMask = (str) => {
    let num = decimalize(str);
    return num;
    // num = separateByThousandths(num,",");
}
const removeMask = (str) => {
    return str.replace(/\D+/g,"")
}

const decimalize = (numstr) => {
    console.log(`numstr.length Inicial: ${numstr.length}`)
    if (numstr.length > 1) {
        let dp = numstr.substring(numstr.length - 2, numstr.length) //Centavos
        let denom = numstr.substring(2,numstr.length - 2) //Pesos
        console.log(`numstr.length: ${numstr.length}`)
        console.log(`denom: ${denom}`)
        let x = 1;
        // if (denom.substring(0,1) === "0") {
        //     denom = denom.substring(0, denom.length ) ///denom = 0
        //     console.log(`${x}:${denom}`)
        // }

        // console.log(`dp:${dp}`)
        console.log(`cantidad:${denom}${dp}`)
        return 0
        // return `$ ${denom}${dp}`
    } else {
        return 0
        // return `$ 0.0${numstr}`
    }
}

const separateByThousandths = (str, delimiter) => {
    return str.replace(/\B(?=(\d{3})+(?!\d))/g, `${delimiter}`);
}
const saveEstudio = () => {
    form.transform((data) => ({
        ...data,
    })).post(route("admin.estudios/store"), {
        preserveState: true,
    });
    if (form.wasSuccessful) {
        form.reset();
    }
};
</script>
