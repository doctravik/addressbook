class ServerFractalPaginator
{
    /**
     * Create a new server Fractal paginator instance.
     *
     * @param  {object} paginator
     * @return {void}
     */
    constructor(paginator) {
        this.paginator = paginator;
    }

    static make(paginator) {
        return (new ServerFractalPaginator(paginator)).adapt();
    }

    /**
     * Adapt paginator data.
     *
     * @return {object}
     */
    adapt() {
        return {
            'items': [],
            'currentPage': this.paginator.current_page,
            'lastPage': this.paginator.total_pages,
            'perPage': this.paginator.per_page,
            'total': this.paginator.total
        };
    }
}

export default ServerFractalPaginator;
