<template>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default btn-xs" @click="sort()">
            <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"
                v-if="order=='asc'"></span>
            <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"
                v-if="order=='desc'"></span>
        </button>
    </div>
</template>

<script>
    import store from './../../store.js';

    export default {
        props: ['filter', 'order'],

        data() {
            return {
                globalFilters: store.filters,
            }
        },

        methods: {
            /**
             * Start sorting
             *
             * @return {void}
             */
            sort() {
                if (! this.filter) {
                    return;
                }

                this.globalFilters.add('sort', this.filter);
                this.globalFilters.add('order', this.order);

                this.$emit('apply-filters');
            }
        }
    }
</script>
