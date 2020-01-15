<template>
  <div class="login_container">
      <div class="col-lg-4 col-md-4 col-xs-9 col-sm-6 login_form">
        <div class="alert alert-danger" v-if="error">
            <p>Login ou mot de passe incorrect.</p>
        </div>
        <form  @submit.prevent="login" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
            </div>
            <div class="btn_login_div">
            <button type="submit" class="btn btn-default">Se connecter</button>
            <button type="submit" class="btn btn-default">
             <router-link :to="{ name: 'register' }">Céer un compte</router-link>
           </button>

            </div>
        </form>
     </div>
  </div>
</template>
<script>
  export default {
    data(){
      return {
        email: null,
        password: null,
        error: false
      }
    },
    methods: {
      login(){
        var app = this
        this.$auth.login({
            params: {
              email: app.email,
              password: app.password
            }, 
            success: function () {},
            error: function () {this.error = true},
            rememberMe: true,
            redirect: '/postsList',
            fetchUser: true,
        });  
        console.log(this.$auth)     
      },
    }
  }
</script>