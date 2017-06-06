<template>
    <div class="row">
        <div class="col-md-4">
            <create-person-form
                @create-person="selectPersonsFromDb()">
            </create-person-form>
        </div>
        <div class="col-md-8">
            <filters :errors="errors" @apply-filters="updatePersons()"></filters>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">People list</h3>
                </div>
                <div class="panel-body">
                    <person-list :persons="persons" v-if="hasPersons"
                        @apply-filters="updatePersons()">
                    </person-list>
                    <p v-else>There are no people with the given requirements</p>
                </div>
            </div>
            <pagination :paginator="paginator" v-if="hasPaginator"
                @page-was-changed="navigate">
            </pagination>
        </div>
    </div>
</template>

<script>
    import store from './../store.js';
    import PersonList from './PersonList';
    import Filters from './filters/Filters';
    import Pagination from './pagination/Pagination';
    import Errors from './../helpers/ObjectCollection';
    import CreatePersonForm from './forms/CreatePersonForm';
    import LaravelPaginator from './pagination/ServerFractalPaginator';

    export default {
        computed: {
            hasPaginator() {
                return this.paginator && this.paginator.lastPage > 1;
            },

            hasPersons() {
                return !! this.persons && this.persons.length;
            }
        },

        /**
         * Mounted event of component.
         *
         * @return {void}
         */
        mounted() {
            this.selectPersonsFromDb();
            this.listenEvents();
        },

        data() {
            return {
                persons: [],
                paginator: null,
                errors: new Errors(),
                filters: store.filters,
                endpoint: '/api/persons',
            }
        },

        methods: {
            /**
             * @return {void}
             */
            selectPersonsFromDb() {
                axios.get(this.endpoint, { params: this.filters.all() })
                    .then(response => {
                        this.parseData(response.data);
                        this.errors.clear();
                    })
                    .catch(error => {
                        this.errors.set(error.response.data);
                    });
            },

            /**
             * Parse response data.
             *
             * @param  {Object} data
             * @return {void}
             */
            parseData(data) {
                this.paginator = LaravelPaginator.make(data.meta.pagination);
                this.persons = data.data;
            },

            /**
             * Navigate through the pagination.
             *
             * @param  {number} page
             * @return {void}
             */
            navigate(page)
            {
                this.filters.add('page', page);
                this.selectPersonsFromDb();
            },

            /**
             * @return {void}
             */
            updatePersons() {
                this.filters.remove('page');
                this.selectPersonsFromDb();
            },

            /**
             * @return {void}
             */
            listenEvents() {
                eventDispatcher.$on('delete-person', () => {
                    this.updatePersons();
                });
            }
        },

        components: {
            Filters,
            PersonList,
            Pagination,
            CreatePersonForm
        }
    }
</script>
