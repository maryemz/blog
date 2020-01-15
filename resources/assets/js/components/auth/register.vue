<template>
   <div class="login_container">
      <div class="col-lg-4 col-md-4 col-xs-9 col-sm-6 login_form">
        <div class="alert alert-danger" v-if="error && !success">
            <p>Une erreur s'est produite, impossible de terminer l'enregistrement.</p>
        </div>
        <div class="alert alert-success" v-if="success">
            <p>Votre compte a été crée avec succée.<router-link :to="{name:'login'}">Se connecter.</router-link></p>
        </div>
        <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">
            <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
                <label for="name">Nom d'utlisateur</label>
                <input type="text" id="name" class="form-control" v-model="name" required>
                <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                <span class="help-block" v-if="error && errors.email">{{ errors.email }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
                <span class="help-block" v-if="error && errors.password">{{ errors.password }}</span>
            </div>
            <div class="btn_login_div">
                <button type="submit" class="btn btn-default">Enregistrer
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
                name: '',
                email: '',
                password: '',
                error: false,
                errors: {},
                success: false
            };
        },
        methods: {
            register(){
                var app = this
                this.$auth.register({
                    data: {
                        name: app.name,
                        email: app.email,
                        password: app.password
                    }, 
                    success: function () {
                        this.success = true
                    },
                    error: function (resp) {
                        this.error = true;
                        this.errors = resp.response.data.errors;
                    },
                    redirect: null
                });                
            }
        }
    }
</script>