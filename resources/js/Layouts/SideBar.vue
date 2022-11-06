<template>
    <div class="hidden md:flex md:flex-1 items-start" v-if="statusSideBar">
        <TransitionRoot :show="statusSideBar">
            <Dialog
                class="bg-gray-200 md:block fixed z-20 inset-0 top-[3.225rem] left-0 right-auto w-60 overflow-y-auto opacity-90 border-r border-gray-300"
                as="div"
                @close="toggleNavBar"
                :open="statusSideBar"
                :initialFocus="completeButtonRef"
            >
                <TransitionChild
                    enter="transition ease-in-out duration-200 transform"
                    enter-from="-translate-x-full"
                    enter-to="translate-x-0"
                    leave="transition ease-in-out duration-200 transform"
                    leave-from="translate-x-0"
                    leave-to="-translate-x-full"
                    as="div"
                >
                    <div
                        v-if="
                            $page.props.auth.permissions.includes(
                                'manage-users'
                            )
                        "
                    >
                        <nav class="mt-2 px-2">
                            <NavItem
                                :item="item"
                                v-for="item in navItems"
                                :key="item.label"
                            />
                        </nav>
                    </div>
                </TransitionChild>
                <TransitionChild
                    enter="transition-opacity ease-linear duration-200"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="transition-opacity ease-linear duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                    as="div"
                >
                    <DialogOverlay></DialogOverlay>
                </TransitionChild>
            </Dialog>
        </TransitionRoot>
    </div>
</template>
<script setup>
import NavItem from "@/Components/NavItem.vue";
import {
    ClipboardIcon,
    HeartIcon,
    HomeIcon,
    NewspaperIcon,
    PhotoIcon,
} from "@heroicons/vue/24/outline";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogOverlay,
} from "@headlessui/vue";
import { computed, ref } from "vue";
import { todoStore } from "@/stores/mainStore";
const stateStore = todoStore();
const statusSideBar = computed(() => stateStore.statusSideBar);
const toggleNavBar = () => stateStore.exchangeSideBar();
let completeButtonRef = ref(null);
const navItems = [
    {
        href: "/dashboard",
        active: false,
        label: "Home",
        children: [],
        icon: HomeIcon,
    },
    {
        href: "#",
        active: false,
        label: "Administración",
        children: [
            {
                href: "/admin/usuarios",
                active: false,
                label: "Administración de Usuarios",
                children: [],
                icon: HomeIcon,
            },
            {
                href: "/admin/roles",
                active: false,
                label: "Roles en el sistema",
                children: [],
                icon: HeartIcon,
            },
            {
                href: "/admin/puestos",
                active: false,
                label: "Administración de Puestos",
                children: [],
                icon: HeartIcon,
            },
            {
                href: "/dashboard",
                active: false,
                label: "Administración de Departamentos",
                children: [],
                icon: HeartIcon,
            },
        ],
    },
    {
        href: "#",
        active: false,
        label: "Solicitudes",
        children: [
            {
                href: "/dashboard",
                active: false,
                label: "Solicitudes",
                children: [],
                icon: ClipboardIcon,
            },
        ],
    },
];
const navItems2 = [
    { href: "#", active: false, label: "Home", children: [], icon: HomeIcon },
    {
        href: "#",
        active: false,
        label: "Posts",
        children: [
            {
                href: "/dashboard",
                active: false,
                label: "Solicitudes",
                children: [],
                icon: ClipboardIcon,
            },
            {
                href: "#",
                active: false,
                label: "All posts",
                children: [],
                icon: null,
            },
            {
                href: "#",
                active: false,
                label: "Add new",
                children: [],
                icon: null,
            },
            {
                href: "#",
                active: false,
                label: "Categories",
                children: [],
                icon: null,
            },
        ],
        icon: NewspaperIcon,
    },
    {
        href: "#",
        active: false,
        label: "Media",
        children: [
            {
                href: "#",
                active: false,
                label: "Library",
                children: [],
                icon: null,
            },
            {
                href: "#",
                active: false,
                label: "Add new",
                children: [
                    {
                        href: "#",
                        active: false,
                        label: "Third level",
                        children: [],
                        icon: null,
                    },
                ],
                icon: null,
            },
        ],
        icon: PhotoIcon,
    },
];
</script>
