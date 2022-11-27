<template>
    <app-layout>
        <template #header class="mb-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar de Estudio
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <jet-form-section
                @submitted="updateEstudio"
            >
                <template #title> Estudio</template>
                <template #description> Modificar Estudio</template>
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
const props = defineProps(['grupos', 'tipoventas', 'categorias','estudio']);
const form = useForm({
    nombre:props.estudio.data.attributes.nombre,
    clave: props.estudio.data.attributes.clave,
    tipoventa_id:props.estudio.data.attributes.tipoventa_id,
    grupo_id:props.estudio.data.attributes.grupo_id,
    categoria_id:props.estudio.data.attributes.categoria_id,
    costo:props.estudio.data.attributes.costo,
    ganancia:props.estudio.data.attributes.ganancia,
    precio_mostrador: props.estudio.data.attributes.precio_mostrador,
    precio_preferencial:props.estudio.data.attributes.precio_preferencial,
    activo: props.estudio.data.attributes.activo,
    uuid: props.estudio.data.uuid,
});

const ListGrupos = ref(props.grupos);
const ListCategorias= ref(props.categorias);
const ListTipoventas= ref(props.tipoventas);


const calcularGanancia = () => {
    form.precio_mostrador = form.costo + form.ganancia
    form.precio_preferencial = form.costo + form.ganancia
}


const updateEstudio = () => {
    form.put(
        route('admin.estudios/update', { estudio: form.uuid })
    )
    if (form.wasSuccessful) {
        form.reset();
    }
};

</script>
