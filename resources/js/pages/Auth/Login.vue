<template>
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>SI</b>CALEG</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Log in to start your session</p>
                <div class="alert alert-danger" v-if="errors.invalid">{{ errors.invalid }}</div>
                <form @submit.prevent="postLogin">
                    <div class="form-group">
                        <input type="text" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="data.email" name="email" placeholder="Username or Email..." required autofocus>
                        <span class="invalid-feedback" role="alert" v-if="errors.email">
                            <strong>{{ errors.email[0] }}</strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" :class="{ 'is-invalid': errors.password }" v-model="data.password" name="password" placeholder="Password.." required>
                        <span class="invalid-feedback" role="alert" v-if="errors.password">
                            <strong>{{ errors.password[0] }}</strong>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="data.remember">

                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapGetters, mapState } from 'vuex';
export default {
    data() {
        return {
            data: {
                email: '',
                password: '',
                remember_me: false
            }
        }
    },
    //SEBELUM COMPONENT DI-RENDER
    created() {
        //KITA MELAKUKAN PENGECEKAN JIKA SUDAH LOGIN DIMANA VALUE isAuth BERNILAI TRUE
        if (this.isAuth) {
            //MAKA DI-DIRECT KE ROUTE DENGAN NAME home
            this.$router.push({ path: '/' })
        }
    },
    computed: {
        ...mapGetters(['isAuth']), //MENGAMBIL GETTERS isAuth DARI VUEX
      	...mapState(['errors'])
    },
    methods: {
        ...mapActions('auth', ['submit']), //MENGISIASI FUNGSI submit() DARI VUEX AGAR DAPAT DIGUNAKAN PADA COMPONENT TERKAIT. submit() BERASAL DARI ACTION PADA FOLDER STORES/auth.js
        ...mapMutations(['CLEAR_ERRORS']),

      	//KETIKA TOMBOL LOGIN DITEKAN, MAKA AKAN MEMINCU METHODS postLogin()
        postLogin() {
            //DIMANA TOMBOL INI AKAN MENJALANKAN FUNGSI submit() DENGAN MENGIRIMKAN DATA YANG DIBUTUHKAN
            this.submit(this.data).then(() => {
                //KEMUDIAN DI CEK VALUE DARI isAuth
                //APABILA BERNILAI TRUE
                if (this.isAuth) {
                    this.CLEAR_ERRORS()
                    //MAKA AKAN DI-DIRECT KE ROUTE DENGAN NAME home
                    this.$router.push({ path: '/' })
                }
            })
        }
    }
}
</script>
