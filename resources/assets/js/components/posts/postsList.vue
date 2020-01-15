<template>
  <div>
    <div class="row search_div">
      <div class="col-12">
        <div class="col-lg-5 col-md-5 col-sm-8 col-12 col-xs-12">
           <multiselect v-model="categorie" :options="categories" label="title" :searchable="true" track-by="id" :multiple="true" placeholder="Recherche par catégories">
          </multiselect>
        </div>
          <input type="text" name="" placeholder="Recherche par titre" class="col-lg-4 col-md-4 col-sm-8 col-12 col-xs-12 text_search_title" v-model="title">
          <button class="btn btn-primary pull-right" @click="FilterPosts(pageCourante)"> Recherche </button>
      </div>  
    </div>
    <div class="row content_div">
      <div class="col-12">
          <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12" v-for="(post,index) in posts">
            <div class="thumbnail" id="post_thumbnail">
                <div class="post_img_div">
                   <img :src='post.Image' > 
                </div>
              <div class="caption">
                <h4>
                    <span class="post_title_span">
                       {{post.Title}}
                   </span>
               </h4>
                <div class="meta">
                    <ul class="date_post">
                        <li>{{post.datePublication}}</li>
                    </ul>
                </div>
                <p><span v-html="post.SubText"></span></p>
              </div>
              <div class="btn_more_details">
                  <a class="btn post_read_more_btn pull-right" role="button">
                      <router-link :to="{ name: 'details', params: {postId:post.id,post:post}}">Voir Plus</router-link>
                 </a> 
                  <a  v-if="$auth.check() && post.user_id == $auth.watch.data"  class="btn btn-primary post_read_more_btn" role="button">
                      <router-link :to="{ name: 'EditPost', params: {postId:post.id,post:post}}">Modifier
                      </router-link>
                 </a>  
                  <a  v-if="$auth.check() && post.user_id == $auth.watch.data"  class="btn btn-danger post_read_more_btn" role="button" @click="DeletePost(post.id,index)">
                       Supprimer
                 </a> 
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="row center_div" v-if="total > 9">
        <div class="col-12">
                <ul class='col align-self-center pagination'>
                    <li :class='{pagination:true,disabled:pageCourante==pagePremiere}'>
                        <a v-on:click='paginationNav(pagePremiere)'><i> << </i></a>
                    </li>
                    <li :class='{pagination:true,disabled:pageCourante==pagePremiere}'>
                        <a v-on:click='paginationNav(pagePrecedente)'><i> < </i></a>
                    </li>
                    <li class="pagination disabled">
                        <a v-text="pageCourante"></a>
                    </li>
                    <li :class='{pagination:true,disabled:pageCourante==pageDerniere}'>
                        <a v-on:click='paginationNav(pageSuivante)'><i> > </i></a>
                    </li>
                    <li class="pagination" :class='{pagination:true,disabled:pageCourante==pageDerniere}'>
                        <a v-on:click='paginationNav(pageDerniere)'><i> >> </i></a>
                    </li>
                </ul>
        </div>        
      </div>
  </div>          
</template>

<script>
import Multiselect from 'vue-multiselect'
import Swal from "sweetalert2"
    export default {
      components: {
          Multiselect
      },
     data(){
      return {
        posts:[],
        categorie: [],
        categories: [],
        title :'',
        pageCourante                    : 1,
        pagePremiere                    : 1,
        pagePrecedente                  : "",
        pageSuivante                    : "",
        pageDerniere                    : 1,
        pagination                      : false,
        page                            : 1,
        pageNav                         : 0,
        total                           :''
        
      }
    },

    methods: {
      //Load all categories
      loadCategories() {
                 axios.get('/LoadCategories').then((response) => {

                    this.categories= response.data.categories;
                   
                }).catch((response) => {
                  
                    Swal({ 
                        title: "Erreur!", 
                        html:"", 
                        type: "error", 
                        confirmButtonText: "Fermer" 
                    });
                });
            
      },
        //Load all published posts
        loadPosts(page) {
                 axios.get('/loadPublishedPosts?page='+page).then((response) => {
                   this.posts= response.data.posts.data;
                   this.pageCourante = response.data.posts.current_page
                   this.pageSuivante = (response.data.posts.current_page != response.data.posts.last_page) ? this.pageCourante + 1:''
                   this.pageDerniere = response.data.posts.last_page
                   this.total = response.data.posts.total
                   $.each(this.posts, function( index, value ) {
                        let  UpdatedDate = new Date(value.updated_at); 
                        value.datePublication = UpdatedDate.toLocaleDateString('fr-FR')
                        let textWitoutHtml = value.Text.replace(/<\/?[^>]+(>|$)/g, "")
                        value.SubText = (value.Title.length< 30) ? textWitoutHtml.substring(0,60)+'...' :textWitoutHtml.substring(0,20)+'...'
                    });

                }).catch((response) => {
                  
                    Swal.fire({ 
                        title: "Erreur!", 
                        html:"", 
                        type: "error", 
                        confirmButtonText: "Fermer" 
                    });
                });
            
            },
            DeletePost(id,index) {
              axios.delete('/posts/'+id)
                  .then(resp => {
                      this.posts.splice(index, 1);
                  })
                  .catch(error => {
                      console.log(error);
              })
            },
          FilterPosts(page){
            let params = {
              title :this.title,
              categories :this.categorie.map(x => x.id),
              }
              this.pageNav = 1;
               axios.post('/filterPosts?page='+page, params).then(response => {
                        this.posts = response.data.posts.data 
                        this.pageCourante = response.data.posts.current_page
                        this.pageSuivante = (response.data.posts.current_page != response.data.posts.last_page) ? this.pageCourante + 1:''
                        this.pageDerniere = response.data.posts.last_page
                        this.total = response.data.posts.total
                        $.each(this.posts, function( index, value ) {
                          let textWitoutHtml = value.Text.replace(/<\/?[^>]+(>|$)/g, "")
                          value.SubText = (value.Title.length< 30) ? textWitoutHtml.substring(0,60)+'...' :textWitoutHtml.substring(0,20)+'...'
                    });
                })
                 .catch((error) => {

                }); 
          },
         paginationNav(page){
                if(this.pageNav == 0){
                    this.loadPosts(page)
                }else if(this.pageNav == 1){
                    this.FilterPosts(page)
                }
            },
        },
        mounted() {
            this.loadPosts(1)
            this.loadCategories()
        }
    }
</script>
