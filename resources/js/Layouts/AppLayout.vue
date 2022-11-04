<template>
    <div>
        <Head :title="title" />
        <JetBanner />
        <div class="min-h-screen">
            <navbar></navbar>
            <!-- Page Heading -->
            <header class="bg-white" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>
            <div>
                <!-- Page Content -->
                <side-bar />
                <main>
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
</template>
<script setup>
import JetApplicationMark from "@/Components/ApplicationMark.vue";
import JetBanner from "@/Components/Banner.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Navbar from "./Nav.vue";
import SideBar from "./SideBar.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    title: String,
});

const showingNavigationDropdown = false;

const switchToTeam = (team) => {
    this.$inertia.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    Inertia.post("/logout");
};
</script>
