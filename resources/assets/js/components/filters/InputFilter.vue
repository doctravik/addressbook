<template>
    <div class="form-group" :class="{'has-error': errors.has(name)}">
        <input type="text" class="form-control" :placeholder="name" ref="input"
            v-bind:value="value"
            @input="update($event.target.value)">
        <span class="help-block" v-if="errors.has(name)">
            <strong v-text="errors.get(name)[0]"></strong>
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
             * @return {boolean|void}
             */
            update(value) {
                value = this.normalize(value);

                this.$refs.input.value = value;

                if (value) {
                    this.$emit('input', value);
                }
            },

            /**
             * @param {string} value
             * @return {string}
             */
            normalize(value) {
                return value;
            }
        },
    }
</script>
