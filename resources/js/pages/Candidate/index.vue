<template>
    <section class="content">
        <div class="container-fluid mt-3">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <profile />
                    <nav>
                        <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-dapil-tab" data-toggle="tab" href="#nav-dapil" role="tab" aria-controls="nav-dapil" aria-selected="true">DAPIL</a>
                            <a class="nav-item nav-link" id="nav-partai-tab" data-toggle="tab" href="#nav-partai" role="tab" aria-controls="nav-partai" aria-selected="false">PARTAI</a>
                        </div>
                    </nav>
                    <div class="tab-content mt-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-dapil" role="tabpanel" aria-labelledby="nav-dapil-tab">
                            <dapil />
                        </div>
                        <div class="tab-pane fade" id="nav-partai" role="tabpanel" aria-labelledby="nav-partai-tab">
                            <party />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Profile from './Profile'
import Party from './Party'
import Dapil from './Dapil'
export default {
    components: {
        Profile, Party, Dapil
    },

    data() {
        return {
            endpoint: '/candidate/profile/',
            profile: [],
            provinces: [],
            form: new Form({
                id: '',
                name: '',
                number: '',
                locationable_id: '',
                locationable_name: '',
            }),
            image: {
                src: '/images/sipileg-logo.png',
                caption: 'asdasda'
            }
        }
    },

    created() {
        this.$root.back_button = false;
    }
}
</script>
