<template>
    <app-layout>
        <template #header class="mb-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modificación de Puesto de Trabajo
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <jet-form-section
                @submit.prevent="
                    form.put(
                        route('admin.puestos/update', { puesto: form.uuid })
                    )
                "
            >
                <template #title> Puesto de trabajo </template>
                <template #description>
                    Modificación de puesto de trabajo <canvas></canvas>
                </template>
                <!-- nombre -->
                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="nombre" value="Nombre" />
                        <jet-input
                            id="nombre"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nombre"
                            autocomplete="nombre"
                        />
                        <jet-input-error
                            :message="form.errors.nombre"
                            class="mt-2"
                        />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <Switch
                            v-model="enabled"
                            class="relative inline-flex h-6 w-11 items-center rounded-full ui-checked:bg-blue-600 ui-not-checked:bg-gray-200"
                        >
                            <span class="sr-only">Enable notifications</span>
                            <span
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition ui-checked:translate-x-6 ui-not-checked:translate-x-1"
                            />
                        </Switch>
                        Activo
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 pt-4"></div>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Components/PrimaryButton.vue";
import JetFormSection from "@/Components/FormSection.vue";
import JetInput from "@/Components/TextInput.vue";
import JetInputError from "@/Components/InputError.vue";
import JetLabel from "@/Components/InputLabel.vue";
import JetActionMessage from "@/Components/ActionMessage.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { usePrevalidate } from "@/Composables/usePreValidate.js";
import JetSectionBorder from "@/Components/SectionBorder.vue";
import { ref, onMounted } from "vue";
import { Switch } from "@headlessui/vue";

const props = defineProps({
    puesto: Object,
});
const form = useForm({
    nombre: props.puesto.data.attributes.nombre,
    activo: Boolean(props.puesto.data.attributes.activo),
    uuid: props.puesto.data.uuid,
    id: props.puesto.data.id,
});
const enabled = ref(false);
const uuid = ref(null);
// function rellena(form, puesto) {
//     form.nombre = puesto.data.attributes.nombre;
//     form.uuid = puesto.data.uuid;
//     form.activo = Boolean(puesto.data.attributes.activo);
//     form.id = puesto.data.id;
// }
const savePuestoInformation = () => {
    form.transform((data) => ({
        ...data,
        activo: enabled,
    })).put(
        route("admin.puestos/update", {
            puesto: uuid,
        }),
        {
            errorBag: "updatePuestoInformation",
            preserveScroll: false,
        }
    );
};

// onMounted(function () {
//     console.log(form.activo);
//     uuid.value = props.puesto.data.uuid;
//     // return rellena(form, props.puesto);
// });
</script>
