<template>
    <div class="flex items-center justify-center">
        <button
            v-bind="$attrs"
            type="button"
            @click="openModal"
            class="flex items-center space-x-2 border border-gray-300 shadow-sm px-3 py-1.5 hover:border-gray-600 focus:outline-none focus:border-gray-600 rounded-lg"
        >
            <PlusIcon
                class="flex-none text-blue-800 -ml-1 w-5 h-5"
                aria-hidden="true"
            />
            <span class="text-sm text-blue-800 flex-1 text-left">..buscar</span>
            <span class="flex-none text-xs font-semibold text-blue-800">{{
                    keyboardShortcut
                }}</span>
        </button>
        <TransitionRoot :show="isOpen" as="template">
            <Dialog
                :open="isOpen"
                @close="closeModal"
                @keydown="navigateResults"
                class="fixed inset-0 z-50 flex justify-center items-start"
            >
                <TransitionChild
                    enter="duration-200 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                    as="template"
                >
                    <DialogOverlay
                        class="fixed inset-0 bg-black bg-opacity-75"
                    ></DialogOverlay>
                </TransitionChild>

                <TransitionChild
                    as="template"
                    enter="duration-200 ease-out"
                    enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95"
                >
                    <div
                        class="flex flex-col overflow-hidden w-full max-w-2xl bg-white rounded-lg mx-4 max-h-[80vh] mt-[10vh] relative"
                    >
                        <form
                            action="#"
                            class="relative flex items-center"
                            @submit.prevent="onSubmit"
                        >
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none"
                            >
                                <PlusIcon
                                    class="flex-none text-gray-700 -ml-1 w-5 h-5"
                                    aria-hidden="true"
                                />
                            </div>
                            <input
                                @input="(e) => search(e.target.value)"
                                @keydown="onTermKeydown"
                                type="text"
                                placeholder="Buscar"
                                class="w-full py-4 pl-12 border-b border-gray-100 placeholder-gray-400"
                            />
                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-3"
                            >
                                <button
                                    @click="closeModal"
                                    type="button"
                                    class="flex items-center p-1.5 uppercase font-semibold tracking-wider text-gray-700 rounded-md border border-gray-200 focus:outline-none focus:border-gray-300 text-xxs"
                                >
                                    Esc
                                </button>
                                <button
                                    @click="toggleModalAddUser()"
                                    type="button"
                                    class="flex items-center p-1.5 uppercase ml-1 rounded-md border border-gray-200 focus:outline-none focus:border-gray-300 text-xxs"
                                >
                                    <PlusIcon
                                        class="flex-none text-gray-700 -ml-1 w-5 h-5"
                                        aria-hidden="true"
                                    />
                                </button>
                            </div>
                        </form>
                        <div class="overflow-auto">
                            <ul
                                v-if="results.length > 0"
                                class="divide-y divide-gray-100"
                            >
                                <li
                                    v-for="(item, index) in results"
                                    :key="index"
                                    :ref="
                                        (el) => {
                                            resultsRefs[index] = el;
                                        }
                                    "
                                    :class="
                                        selectedIndex === index
                                            ? 'italic'
                                            : ''
                                    "
                                    @mousemove="selectedIndex = index"
                                    class="flex items-center px-4 py-2.5 relative"
                                    @click="selectUsuario(item)"
                                >
                                    <span class="absolute inset-0"></span>
                                    <div class="ml-3">
                                        <div
                                            class="font-semibold text-gray-600"
                                        >
                                            {{ item.nombre }}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <p
                                v-if="results.length === 0"
                                class="p-10 text-lg text-center text-gray-400"
                            >
                                Sin resultados a??n...
                            </p>
                        </div>
                    </div>
                </TransitionChild>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script>
import {nextTick, computed, onMounted, onUnmounted, ref} from "vue";
import {PlusIcon, } from "@heroicons/vue/24/solid";
import JetNavLink from "@/Components/NavLink.vue";
import { estudioStore } from "@/stores/estudioStore";
import {
    Dialog,
    DialogOverlay,
    TransitionRoot,
    TransitionChild,
} from "@headlessui/vue";
import axios from "axios";
import {debounce} from "lodash";

export default {
    components: {
        PlusIcon,
        Dialog,
        DialogOverlay,
        TransitionRoot,
        TransitionChild,
        JetNavLink,
    },
    setup(props, context) {
        // const store = useStore();
        const stateStore = estudioStore();
        const isOpen = computed(() => stateStore.statusDialogSearchEstudio);
        const isAppleOS = () => {
            const platform =
                navigator?.userAgentData?.platform ||
                navigator?.platform ||
                "unknown";
            return /(Mac|iPhone|iPod|iPad)/i.test(platform);
        };
        onMounted(() => {
            window.addEventListener("keydown", onKeyDown);
        });
        const keyboardShortcut = isAppleOS() ? "???K" : "Ctrl+K";
        // const isOpen = ref(false);

        const results = ref([]);
        const resultsRefs = ref([]);
        const selectedIndex = ref(0);
        const search = debounce(async (term) => {
            let res = await axios.get("/admin/estudios/search/", {
                params: {
                    term,
                },
            });
            results.value = res.data;
            await nextTick();
            resultsRefs.value = [];
        }, 250);

        const onTermKeydown = (event) => {
            if (["ArrowUp", "ArrowDown", "Enter"].includes(event.code)) {
                event.preventDefault();
            }
        };
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
                    stateStore.exchangeDialogSearchEstudio();
                    // store.dispatch(
                    //     "solicitudesStore/selectUsuario",
                    //     results.value[selectedIndex.value]
                    // );
                    break;
            }

            resultsRefs.value[selectedIndex.value]?.scrollIntoView(false);
        };
        const onKeyDown = (event) => {
            // event.preventDefault();
            if (isOpen.value) return;

            if ((event.metaKey || event.ctrlKey) && event.key === "k") {
                stateStore.exchangeDialogSearchEstudio();
                // store.dispatch("solicitudesStore/toggleModalSearchUser");
                event.preventDefault();
            }
        };
        const onSubmit = () => {
            if (results.value[selectedIndex.value]) {
                window.location = results.value[selectedIndex.value].url;
            }
        };

        const closeModal = () => {
            console.log("Disparamos acction del Store")
            stateStore.exchangeDialogSearchEstudio();
            // store.dispatch("solicitudesStore/toggleModalSearchUser");
        };
        const openModal = () => {
            stateStore.exchangeDialogSearchEstudio();
        }
        onUnmounted(() => window.removeEventListener("keydown", onKeyDown));

        return {
            // ...mapActions("solicitudesStore", [
            //     "toggleModalAddUser",
            //     "selectUsuario",
            //     "toggleModalSearchUser",
            // ]),
            isOpen,
            navigateResults,
            onSubmit,
            onTermKeydown,
            results,
            resultsRefs,
            search,
            selectedIndex,
            closeModal,
            keyboardShortcut,
            openModal,
        };
    },
};
</script>

