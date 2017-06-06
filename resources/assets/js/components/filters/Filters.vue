<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Filters</h3>
        </div>
        <div class="panel-body">
            <form @submit.prevent="apply">
                <div class="row">
                    <div class="col-md-3">
                        <input-filter name="name" :errors="errors"
                            v-model="filters.items.name">
                        </input-filter>
                    </div>
                    <div class="col-md-3">
                        <input-number-filter name="minAge" :errors="errors"
                            v-model="filters.items.minAge">
                        </input-number-filter>
                    </div>
                    <div class="col-md-3">
                        <input-number-filter name="maxAge" :errors="errors"
                            v-model="filters.items.maxAge">
                        </input-number-filter>
                    </div>
                    <div class="col-md-3">
                        <input-filter name="city" :errors="errors"
                            v-model="filters.items.city">
                        </input-filter>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">Filter</button>
                            <button class="btn btn-default" @click="reset">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import store from './../../store.js';
    import InputFilter from './InputFilter';
    import InputNumberFilter from './InputNumberFilter';
    import Filters from './../../helpers/ObjectCollection';

    export default {
        props: ['errors'],

        data() {
            return {
                filters: new Filters({
                    name: null,
                    city: null,
                    minAge: null,
                    maxAge: null,
                }),
                globalFilters: store.filters
            }
        },

        methods: {
            /**
             * Apply filters.
             *
             * @return {void}
             */
            apply() {
                this.update();
                this.$emit('apply-filters');
            },

            /**
             * Update filters.
             *
             * @return {void}
             */
            update() {
                for(let filter in this.filters.all()) {
                    this.globalFilters.remove(filter);
                    this.addGlobalFilter(filter);
                }
            },

            /**
             * @param {string} filter
             * @return {void}
             */
            addGlobalFilter(filter) {
                if (this.filters.has(filter)) {
                    this.globalFilters.add(filter, this.filters.get(filter));
                }
            },

            /**
             * Reset filters.
             *
             * @return {void}
             */
            reset() {
                this.filters.reset();

                this.apply();
             },
        },

        components: { InputFilter, InputNumberFilter }
    }
</script>
