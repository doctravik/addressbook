import Errors from './ObjectCollection.js';

class Form
{
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data;

        this.fill(data);

        this.errors = new Errors();
    }

    /**
     * Fill form with data.
     *
     * @param  {object} data
     * @return {void}
     */
    fill(data) {
        for (let field in this.originalData) {
            this[field] = data[field];
        }
    }

    /**
     * Fetch all relevant data for the form.
     *
     * @return {Object}
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    /**
     * Reset the form fields.
     *
     * @return void
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = null;
        }
    }

    /**
     * Send a POST request to the given URL.
     *
     * @param {string} url
     * @return {Promise}
     */
    post(url, attributes) {
        return this.submit('post', url);
    }

    /**
     * Send a PUT request to the given URL.
     *
     * @param {string} url
     * @return {Promise}
     */
    put(url) {
        return this.submit('put', url);
    }


    /**
     * Send a PATCH request to the given URL.
     *
     * @param {string} url
     * @return {Promise}
     */
    patch(url) {
        return this.submit('patch', url);
    }


    /**
     * Send a DELETE request to the given URL.
     *
     * @param {string} url
     * @return {Promise}
     */
    delete(url) {
        return this.submit('delete', url);
    }

    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     * @return {Promise}
     */
     submit(requestType, url) {
         return new Promise((resolve, reject) => {
             axios[requestType](url, this.data())
                 .then(response => {
                     this.onSuccess(response.data.data);

                     resolve(response.data.data);
                 })
                 .catch(error => {
                     this.onFail(error.response.data);

                     reject(error.response.data);
                 });
         });
     }

    /**
     * Handle a successful form submission.
     *
     * @param {Object} data
     * @return {void}
     */
    onSuccess(data) {
        this.errors.clear();
    }

    /**
     * Handle a failed form submission.
     *
     * @param {Object} errors
     * @return {void}
     */
    onFail(errors) {
        this.errors.set(errors);
    }
}

export default Form;
