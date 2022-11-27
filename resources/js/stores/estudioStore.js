import { defineStore } from "pinia";

export const estudioStore = defineStore("estudios", {
    state: () => ({
        openDialogSearchEstudio: false,
    }),
    getters: {

        statusDialogSearchEstudio(state) {
            return state.openDialogSearchEstudio;
        }
    },
    actions: {
        exchangeDialogSearchEstudio() {
            this.openDialogSearchEstudio = !this.openDialogSearchEstudio;
        }
    },
});
