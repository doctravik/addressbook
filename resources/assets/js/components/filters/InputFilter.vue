<template>
    <div class="form-group" :class="{'has-error': errors.has(name)}">
        <!-- <label v-text="name"></label> -->
        <input type="text" class="form-control" :placeholder="name" ref="input"
            v-bind:value="value"
            @input="update($event.target.value)">
        <span class="help-block" v-if="errors.has(name)">
            <strong v-text="errors.get(name)"></strong>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['value', 'name', 'errors'],

        methods: {
            /**
             * Update filters.
             *
             * @param {string} value
             * @return {void}
             */
            update(value) {
                this.$refs.input.value = value;
                this.$emit('input', value);
            },
        },
    }
</script>
