import { defineStore } from "pinia";

export const todoStore = defineStore("principal", {
    state: () => ({
        sideBar: false,
        openDialogDelete: false,
    }),
    getters: {
        statusSideBar(state) {
            return state.sideBar;
        },
        statusDialogDelete(state) {
            return state.openDialogDelete;
        }
    },
    actions: {
        exchangeSideBar() {
            this.sideBar = !this.sideBar;
        },
        exchangeDialogDelete() {
            this.openDialogDelete = !this.openDialogDelete;
        }
    },
});
