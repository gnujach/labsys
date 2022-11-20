<template>
    <app-layout>
        <template #header class="mb-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alta de Paciente
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <jet-form-section
                @submitted="updatePaciente"
            >
                <template #title> Paciente</template>
                <template #description> Alta de Paciente</template>
                <!-- nombre -->
                <template #form>
                    <div class="col-span-6 sm:col-span-4">
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
                    <!-- ap1 -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="ap1" value="Primer Apellido" />
                        <jet-input
                            id="ap1"
                            type="text"
                            class="mt-1 block w-full uppercase"
                            v-model="form.ap1"
                            autocomplete="ap1"
                        />
                        <jet-input-error
                            :message="form.errors.ap1"
                            class="mt-2"
                        />
                    </div>
                    <!-- ap2 -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="ap2" value="Segundo Apellido" />
                        <jet-input
                            id="ap2"
                            type="text"
                            class="mt-1 block w-full uppercase"
                            v-model="form.ap2"
                            autocomplete="ap2"
                        />
                        <jet-input-error
                            :message="form.errors.ap2"
                            class="mt-2"
                        />
                    </div>
                    <!-- genero -->
                    <div
                        class="col-span-6 sm:col-span-4"
                        v-if="generos && generos.length > 0"
                    >
                        <jet-label for="genero" value="Género" />
                        <BaseListbox
                            :options="generos"
                            placeholder="Seleccione Género"
                            v-model="form.genero"
                        />
                        <jet-input-error
                            :message="form.errors.genero"
                            class="mt-2"
                        />
                    </div>
                    <!-- edad -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="edad" value="Edad" />
                        <jet-input
                            id="edad"
                            type="text"
                            class="mt-1 block w-full uppercase"
                            v-model="form.edad"
                            autocomplete="edad"
                        />
                        <jet-input-error
                            :message="form.errors.edad"
                            class="mt-2"
                        />
                    </div>
                    <!-- direccion -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="direccion" value="Direccion" />
                        <jet-input
                            id="direccion"
                            type="text"
                            class="mt-1 block w-full uppercase"
                            v-model="form.direccion"
                            autocomplete="direccion"
                        />
                        <jet-input-error
                            :message="form.errors.direccion"
                            class="mt-2"
                        />
                    </div>
                    <!-- tel -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="tel" value="Número Telefónico" />
                        <jet-input
                            id="tel"
                            type="text"
                            class="mt-1 block w-full uppercase"
                            v-model="form.tel"
                            autocomplete="tel"
                        />
                        <jet-input-error
                            :message="form.errors.tel"
                            class="mt-2"
                        />
                    </div>
                    <!-- correo -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="correo" value="Correo Electrónico" />
                        <jet-input
                            id="correo"
                            type="text"
                            class="mt-1 block w-full italic"
                            v-model="form.correo"
                            autocomplete="correo"
                        />
                        <jet-input-error
                            :message="form.errors.correo"
                            class="mt-2"
                        />
                    </div>

                    <!-- Activo -->
                    <div class="col-span-6 sm:col-span-4">
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
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Components/PrimaryButton.vue";
import JetFormSection from "@/Components/FormSection.vue"
import JetInput from "@/Components/TextInput.vue";
import JetInputError from "@/Components/InputError.vue";
import JetLabel from "@/Components/InputLabel.vue";
import JetActionMessage from "@/Components/ActionMessage.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import JetSectionBorder from "@/Components/SectionBorder.vue";
import {ComboboxLabel, Switch} from "@headlessui/vue";
import BaseListbox from "@/Components/Shared/BaseListbox.vue";
const props = defineProps({
    paciente:Object
});
const form = useForm({
    nombre:props.paciente.data.attributes.nombre,
    ap1: props.paciente.data.attributes.ap1,
    ap2: props.paciente.data.attributes.ap2,
    tel:props.paciente.data.attributes.tel,
    direccion:props.paciente.data.attributes.direccion,
    correo:props.paciente.data.attributes.correo,
    genero:props.paciente.data.attributes.genero,
    edad:props.paciente.data.attributes.edad,
    activo: Boolean(props.paciente.data.attributes.activo),
    uuid: props.paciente.data.uuid,
});
const generos = [{
    id: 'Másculino',
    nombre: "Másculino"
},
    {
        id: 'Femenino',
        nombre: "Femenino"
    }
    ,'Femenino'
];
const updatePaciente = () => {
    form.put(
        route('admin.pacientes/update', { paciente: form.uuid })
    )
    if (form.wasSuccessful) {
        form.reset();
    }
};
</script>
