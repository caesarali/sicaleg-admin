<template>
    <div class="login-box">
        <div class="login-logo">
            <img src="/images/vote.png" alt="Logo" class="img-fluid mx-auto d-block" style="width: 75px">
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <h3 class="login-box-msg pb-0 font-weight-bold text-secondary">
                    SIMCALEG
                </h3>
                <small class="d-block text-center text-secondary pb-3">Sistem Monitoring Kinerja Relawan Caleg</small>

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
                    <button type="submit" class="btn btn-info btn-block" :disabled="isLoading">
                        <i class="fas fa-sign-in-alt mr-1"></i> Log In
                    </button>
                </form>
            </div>
            <div class="overlay d-flex justify-content-center" v-if="isLoading" style="align-items: center;">
                <i class="fas fa-2x fa-spinner fa-spin"></i>
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
    created() {
        if (this.isAuth) {
            this.$router.push({ path: '/' })
        }
    },
    computed: {
        ...mapGetters(['isAuth', 'isLoading']),
      	...mapState(['errors'])
    },
    methods: {
        ...mapActions('auth', ['submit']),
        ...mapMutations(['CLEAR_ERRORS']),

        postLogin() {
            this.CLEAR_ERRORS()
            this.submit(this.data).then(() => {
                if (this.isAuth) {
                    this.CLEAR_ERRORS()
                    this.$router.push({ path: '/' })
                }
            })
        }
    }
}
</script>
