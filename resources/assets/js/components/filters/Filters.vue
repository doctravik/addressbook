<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Filters</h3>
        </div>
        <div class="panel-body">
            <form @submit.prevent="apply">
                <div class="row">
                    <div class="col-md-3">
                        <input-filter v-model="filters.items.name" name="name"
                            :errors="errors"></input-filter>
                    </div><div class="col-md-3">
                        <input-filter v-model="filters.items.age" name="age"
                            :errors="errors"></input-filter>
                    </div><div class="col-md-3">
                        <input-filter v-model="filters.items.city" name="city"
                            :errors="errors"></input-filter>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success">Filter</button>
                        <button class="btn btn-default" @click="reset">Reset</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
    import store from './../../store.js';
    import InputFilter from './InputFilter';
    import Filters from './../../helpers/ObjectCollection';

    export default {
        props: ['errors'],

        data() {
            return {
                filters: new Filters({
                    age: null,
                    name: null,
                    city: null,
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

        components: { InputFilter }
    }
</script>
