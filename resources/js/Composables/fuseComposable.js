// import { onMounted, computed } from "vue";
import Fuse from "fuse.js";
export function fuseComposable(term, puestos) {
    let fuse = null;
    const parse = (p) => {
        const arr = new Array();
        p.forEach((element) => {
            arr.push(element.data.attributes);
        });
        return arr;
    };
    const options = {
        includeScore: false,
        keys: ["nombre"],
    };
    // onMounted(() => {
    //     fuse = new Fuse(parse(puestos), options);
    //     console.log(fuse);
    // });

    // let results = computed(() => {
    //     return term.value ? fuse.search(term.value) : [];
    // });
    fuse = new Fuse(parse(puestos), options);
    let results = term.value ? fuse.search(term.value) : [];
    // let results = term.value ? fuse.search("man") : [];

    return results;
}
