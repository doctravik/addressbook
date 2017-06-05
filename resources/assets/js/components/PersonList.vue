<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Photo</th>
                <th v-for="header in headers"> {{ header }} &nbsp;
                    <sort-filter order="asc" :filter="sortMap[header]"
                        @apply-filters="applyFilters"></sort-filter>

                    <sort-filter order="desc" :filter="sortMap[header]"
                        @apply-filters="applyFilters"></sort-filter>
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <person v-for="person in persons" :key="person.id"
                :person="person">
            </person>
        </tbody>
    </table>
</template>

<script>
import Person from './Person';
import SortFilter from './filters/SortFilter';

export default {
    props: ['persons'],

    data() {
        return {
            headers: ['Name', 'Age', 'City'],
            sortMap: {
                'Age': 'age',
                'Name': 'name',
                'City': 'city'
            }
        }
    },

    methods: {
        /**
         * @return {void}
         */
        applyFilters() {
            this.$emit('apply-filters');
        },
    },

    components: {
        Person,
        SortFilter,
    }
}
</script>
