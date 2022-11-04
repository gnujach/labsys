import { defineStore } from "pinia";

export const todoStore = defineStore("principal", {
    state: () => ({
        sideBar: false,
    }),
    getters: {
        statusSideBar(state) {
            return state.sideBar;
        },
    },
    actions: {
        exchangeSideBar() {
            this.sideBar = !this.sideBar;
        },
    },
});
