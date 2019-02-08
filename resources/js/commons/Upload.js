export default class Upload {
    constructor (data = {}) {
        this.busy = false
        this.successful = false
        this.errors = {}

        Object.assign(this, data)
    }

    post (url) {
        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        };
        return this.submit('post', url, config)
    }

    // submit(method, url, config = {}) {
    //     return new Promise((resolve, reject) => {
    //         axios.post(url, this.data(), config)
    //         .then(response => {
    //             resolve(response)
    //             alert(response)
    //         })
    //         .catch(error => {
    //             reject(error)
    //         })
    //     })
    // }
}
