<template>
  <div>
    <div id="menu">
            <nav role="navigation">
              <ul class="nav nav-pills ul_nav">
                <li class="nav-item">
                    <router-link :to="{ name: 'welcome' }">Accueil</router-link>
                </li>
                <li class="nav-item topmenu">
                    <a href="" aria-haspopup="true">
                        <router-link :to="{ name: 'posts' }">Posts</router-link>
                    </a>
                    <ul class="dropdown" aria-label="submenu">

                        <li class="submenu" v-if="$auth.check()">
                          <a href="#">
                            <router-link :to="{ name: 'createPost' }">Créer post</router-link>
                          </a>
                        </li>
                        <li class="submenu" v-if="$auth.check()"><router-link :to="{ name: 'Myposts' }">Mes Posts</router-link></li>
                   </ul>
                </li>
                <li class="nav-item topmenu">
                    <router-link :to="{ name: 'carrieres' }">Carrieres</router-link>
                     <ul class="dropdown" aria-label="submenu">
                        <li class="submenu" v-if="$auth.check()">
                          <a href="#">
                            <router-link :to="{ name: 'createOffre' }">Nouvelle Offre</router-link>
                          </a>
                        </li>
                        <li class="submenu" v-if="$auth.check()"><a href="#">Mes offres</a></li>
                   </ul>
                </li>
               
                <li v-if="!$auth.check()" class="pull-right">
                  <router-link :to="{ name: 'login' }">Login</router-link>
              </li>
              <li v-if="$auth.check()" class="pull-right">
                    <a href="#" @click.prevent="$auth.logout()">Déconnexion</a>
              </li>
                
              </ul>
          </nav>
    </div>
    <div class="container_div" >
        <router-view></router-view>
    </div>
 </div>
</template>
<script>
    export default {}
</script>
