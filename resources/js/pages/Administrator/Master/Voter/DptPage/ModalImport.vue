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
        <form @submit.prevent="importVoters" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" ref="file" class="custom-file-input" id="file" @change="fileUpload()" accept=".xls, .xlsx" :class="{ 'is-invalid': !uploadIsValid && file }">
                        <label class="custom-file-label" for="customFile">{{ upload.caption }}</label>
                        <div class="invalid-feedback">Example invalid feedback text</div>
                    </div>
                </div>
                <app-loader v-if="upload.percentage > 0"></app-loader>
            </div>
            <div class="modal-footer border-top-0 bg-light">
                <button-default type="submit" :disabled="!uploadIsValid" class="btn-block-xs">
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
            file: '',
            upload: {
                caption: '',
                size: 0,
                percentage: 0,
            }
        }
    },

    computed: {
        uploading: function () {
            return 'width: ' + this.upload.percentage + '%'
        },
        uploadIsValid: function() {
            if (this.upload.size <= 2048000 && this.upload.size > 0) {
                return true;
            } return false;
        }
    },

    methods: {
        show() {
            this.upload.percentage = 0;
            this.upload.caption = 'Pilih file..';
            this.file = '';
            $('#importModal').modal('show');
        },

        fileUpload() {
            this.upload.caption = this.$refs.file.files[0].name;
            this.upload.size = this.$refs.file.files[0].size;
            this.file = this.$refs.file.files[0];
        },

        importVoters() {
            let form = event.target;
            let data = new FormData;
            data.append('locationable_id', this.$route.params.tps_id);
            data.append('file', this.file);

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: function( progressEvent ) {
                    this.upload.percentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
                }.bind(this)
            };

            axios.post('/import-voters', data, config)
            .then(({ data }) => {
                swal( 'Berhasil!', data.message, 'success' )
                this.loadVoters();
            })
            .catch(() => {
                swal('Gagal!', 'Pastikan data yang kamu import menggunakan format standar yang sudah kami tentukan.', 'error')
            })
            .then(() => {
                $('.modal').modal('hide');
                form.reset();
            });
        }
    },
}
</script>
