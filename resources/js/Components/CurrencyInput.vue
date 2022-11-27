<template>
    <input
        ref="inputRef"
        type="text"
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
    />
</template>

<script>
import { useCurrencyInput } from 'vue-currency-input'
import { watch } from 'vue'
export default {
    name: 'CurrencyInput',
    props: {
        modelValue: Number, // Vue 2: value
        options: Object
    },
    setup(props) {
        const { inputRef, setOptions, setValue } = useCurrencyInput(props.options)
        watch(
            () => props.modelValue, // Vue 2: props.value
            (value) => {
                setValue(value)
            }
        )


        return { inputRef }
    }
}
</script>
