<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="error-page mt-5 pt-5 text-center">
                        <i class="fas fa-exclamation-circle text-warning fa-5x d-block mb-3"></i>
                        <h3>Oops! <br> Halaman tidak ditemukan.</h3>
                        <p>
                            Kami tidak menemukan halaman yang ada cari. <br>
                            Sementara itu, kamu bisa <router-link :to="{ name: 'home' }">kembali ke dashboard.</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {

}
</script>