<template>
    <jet-form-section @submitted="updateRolInformation">
        <template #title> Información de Rol </template>

        <template #description> Nuevo rol de usuario </template>

        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nombre" />
                <jet-input
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    max-length="12"
                />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
            <!-- Permissions-->
            <div class="col-span-6 sm:col-span-4" v-if="permissions">
                <jet-label for="permission" value="Permisos" />
                <BaseListboxName
                    :options="permissions"
                    :multiple="multiple"
                    placeholder="Selecciona Permisos del Rol"
                    v-model="form.permissions"
                />
                <jet-input-error
                    :message="form.errors.permissions"
                    class="mt-2"
                />
            </div>
        </template>
        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Guardar.
            </jet-action-message>

            <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Guardar
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script setup>
import JetButton from "@/Components/PrimaryButton.vue";
import JetFormSection from "@/Components/FormSection.vue";
import JetInput from "@/Components/TextInput.vue";
import JetInputError from "@/Components/InputError.vue";
import JetLabel from "@/Components/InputLabel.vue";
import JetActionMessage from "@/Components/ActionMessage.vue";
import JetSecondaryButton from "@/Components/SecondaryButton.vue";
import JetSectionBorder from "@/Components/SectionBorder.vue";
import BaseListboxName from "@/Components/Shared/BaseListboxName.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, computed } from "vue";

const multiple = ref(true);
const props = defineProps({
    permissions: Object,
    role: Object,
    permisosUsuario: Object,
});

const form = useForm({
    name: props.role.data.name,
    permissions: props.permisosUsuario,
});

function updateRolInformation() {
    form.put(
        route("admin.roles/update", {
            role: props.role.data.id,
        })
    );
    if (form.wasSuccessful) {
        form.reset();
    }
}
</script>
