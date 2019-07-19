<template>
    <section class="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <profile />
                </div>
                <div class="col-12 col-lg-4">
                    <party />
                </div>
                <div class="col-12 col-lg-8">
                    <dapil />
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
