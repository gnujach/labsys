<template>
    <app-layout>
        <template #header class="mb-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alta de Puesto de Trabajo
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <jet-form-section
                @focusout="validate"
                @submitted="savePuestoInformation"
            >
                <template #title> Puesto</template>
                <template #description> Alta de Puesto</template>
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
                            autofocus
                        />
                        <jet-input-error
                            :message="form.errors.nombre"
                            class="mt-2"
                        />
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
import JetFormSection from "@/Components/FormSection.vue";
import JetInput from "@/Components/TextInput.vue";
import JetInputError from "@/Components/InputError.vue";
import JetLabel from "@/Components/InputLabel.vue";
import JetActionMessage from "@/Components/ActionMessage.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { usePrevalidate } from "@/Composables/usePreValidate.js";
import JetSectionBorder from "@/Components/SectionBorder.vue";

const form = useForm({
    nombre: null,
});
const { validate } = usePrevalidate(form, {
    method: "post",
    url: route("admin.puestos/store"),
});
const savePuestoInformation = () => {
    form.transform((data) => ({
        ...data,
    })).post(route("admin.puestos/store"), {
        preserveState: false,
    });
    if (form.wasSuccessful) {
        form.reset();
    }
};
</script>
