<template>
    <nav aria-label="Page navigation" v-if="paginator.lastPage > 1">
        <ul class="pagination">
            <li :class="{'disabled': !hasPrev() }">
                <a href="#" aria-label="Previous" @click.prevent="prev">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <template v-for="(item, key) in pages">
                <li v-if="isArray(item) && key != 'first'">
                    <span>&hellip;</span>
                </li>

                <li v-for="page in item" @click.prevent="navigate(page)"
                    :class="{'active': isCurrent(page)}">
                        <a href="#" v-text="page"></a>
                </li>
            </template>

            <li :class="{'disabled': !hasNext()}">
                <a href="#" aria-label="Next" @click.prevent="next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    import PageViewport from './PageViewport.js';

    export default {
        props: ['paginator'],

        computed: {
            pages: function() {
                return PageViewport.make(this.paginator);
            }
        },

        methods: {
            /**
             * Notify parent that page has been changed
             *
             * @param  {number} page
             * @return {void}
             */
            navigate(page) {
                this.$emit('page-was-changed', page);
            },

            /**
             * Move to the previous page.
             *
             * @return {void}
             */
            prev() {
                if(this.hasPrev()) {
                    this.navigate(this.paginator.currentPage - 1);
                }
            },

            /**
             * Move to the next page.
             *
             * @return {void}
             */
            next() {
                if(this.hasNext()) {
                    this.navigate(this.paginator.currentPage + 1);
                }
            },

            /**
             * Check if there is a previous element.
             *
             * @return {boolean}
             */
            hasPrev() {
                return this.paginator.currentPage > 1;
            },

            /**
             * Check if there is a next element.
             *
             * @return {boolean}
             */
            hasNext() {
                return this.paginator.currentPage < this.paginator.lastPage;
            },

            /**
             * Check if the page is the current page.
             *
             * @param  {nteger}  page
             * @return {boolean}
             */
            isCurrent(page) {
                return this.paginator.currentPage == page;
            },

            /**
             * @param {mix} array
             * @return {boolean}
             */
            isArray(array) {
                return array instanceof Array;
            }
        }
    }
</script>
