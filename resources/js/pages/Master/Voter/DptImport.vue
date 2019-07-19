<template>
    <modal id="importModal">
        <template slot="title">Import DPT</template>
        <div class="px-3 pt-3 pb-1 border-bottom">
            <h5>
                <span class="text-danger">*</span> Penting!!!
            </h5>
            <ul>
                <li>
                    Format file harus menggunakan ekstensi
                    <abbr title="Contoh: dpt_file_name.xlsx" class="font-weight-normal font-italic mx-1">.xlsx</abbr>
                    dengan ukuran file maksimal 2048 KB.
                </li>
                <li>
                    Format data harus mengikuti template yang sudah kami sediakan.
                    <br>
                    Template file bisa anda download <a href="#">disini...</a>
                </li>
            </ul>
        </div>
        <form @submit.prevent="importFile">
            <div class="modal-body">
                <div class="form-group" v-if="!upload.busy">
                    <div class="custom-file">
                        <input type="file" ref="file" class="custom-file-input" :class="{ 'is-invalid': !validation && file.size > 0 }" @change="getFile()">
                        <label class="custom-file-label" for="customFile">{{ file.name }}</label>
                        <div class="invalid-feedback">
                            File yang anda pilih tidak memenuhi persyaratan.
                        </div>
                    </div>
                </div>
                <div class="my-5 text-center" v-else>
                    <app-loader :loading="upload.busy" loader="moon" class="mb-3"></app-loader>
                    Sedang meng-upload...
                </div>
            </div>
            <div class="modal-footer border-top-0 bg-light">
                <button-default type="submit" class="btn-block-xs" :disabled="upload.busy || !validation">
                    <i class="fas fa-check mr-1"></i> Import
                </button-default>
            </div>
        </form>
    </modal>
</template>

<script>
export default {
    data() {
        return {
            file: {
                src: '',
                name: '',
                size: 0,
            },
            upload: {
                percentage: 0,
                busy: false,
                successful: false,
                errors: {},
            }
        }
    },

    computed: {
        validation: function() {
            if (this.file.size > 0 && this.file.size <= 2048000) {
                return true;
            } return false;
        },
        uploading: function () {
            return 'width: ' + this.upload.percentage + '%'
        },
    },

    methods: {
        show() {
            this.file.src = '';
            this.file.name = 'Pilih file..';
            this.file.size = 0;
            this.modal('show');
        },

        getFile() {
            this.file.src = this.$refs.file.files[0];
            this.file.name = this.$refs.file.files[0].name;
            this.file.size = this.$refs.file.files[0].size;
        },

        importFile() {
            this.upload.busy = true;

            let form = event.target;
            let data = new FormData;
            data.append('tps_id', this.$route.params.tps_id);
            data.append('file', this.file.src);

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Content-Type': 'application/json'
                },
                // onUploadProgress: function( progressEvent ) {
                //     this.upload.percentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
                // }.bind(this)
            };

            axios.post('/dpt/import', data, config)
            .then(({ data }) => {
                swal('Sukses!', data.message, 'success')
                this.$parent.init()
            })
            .catch(() => {
                swal('Gagal!', 'Pastikan file yang anda import menggunakan aturan standar yang sudah kami tentukan.', 'error')
            })
            .then(() => {
                this.modal('hide');
                this.upload.busy = false;
                form.reset();
            });
        },

        modal(action) {
            $('#importModal').modal(action);
        }
    },
}
</script>
