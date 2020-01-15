<template>
  <div>
     <div class="row search_div">
      <div class="col-12">
        <div class="col-lg-5 col-md-5 col-sm-8 col-12 col-xs-12" >
          <multiselect v-model="secteur" :options="secteurs" label="title" placeholder="Recherche par secteur d'activité" :searchable="true" track-by="id" :multiple="false">
          </multiselect>
        </div>
          <input type="text" v-model="title" class="col-lg-4 col-md-4 col-sm-8 col-12 col-xs-12 text_search_title" name="">
          <button class="btn btn-primary pull-right"  @click="FiltreOffre(pageCourante)" placeholder="Recherche par poste">Recherche</button>
      </div>
    </div>
   <div class="content_div">
        <div class="section">
            <div>
                <div class="blog-post" v-for="(offre,index) in offres">
                    <h1 class="blog-title">{{offre.Title}}  </h1>
                    <h2 class="date">{{offre.datePublication}} </h2>
                    <p class="blog-content">{{offre.SubText}}</p>
                    <div class="row">
                        <a class="btn post_read_more_btn pull-right" role="button">
                            <router-link :to="{ name: 'detailsOffre', params: {offreId:offre.id,offre:offre}}"> Voir Plus</router-link>
                        </a>
                        <a v-if="$auth.check() && offre.user_id == $auth.watch.data" class="btn btn-primary post_read_more_btn" href="#" >
                            <router-link :to="{ name: 'EditOffre', params: {offreId:offre.id,offre:offre}}"> Modifier</router-link>
                        </a>
                        <a v-if="$auth.check() && offre.user_id == $auth.watch.data" href="#" class="btn btn-danger post_read_more_btn" @click="DeleteOffre(offre.id,index)">
                            Supprimer
                        </a>
                    </div>
                    
                </div> 
            </div>
      </div>
       <div class="row center_div" v-if="total > 5">
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
 </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import swal from "sweetalert2"
    export default {
      components: {
          Multiselect
      },
     data(){
      return {
        offres:[],
        title :'',
        secteurs :[],
        secteur :'',
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

        //Load all published offres
        loadOffres(page) {
                 axios.get('/loadPublishedOffres?page='+page).then((response) => {
                  
                   this.offres= response.data.offres.data;

                   $.each(this.offres, function( index, value ) {
                      let  UpdatedDate = new Date(value.updated_at); 
                      value.datePublication = UpdatedDate.toLocaleDateString('fr-FR')
                      let textWitoutHtml = value.Text.replace(/<\/?[^>]+(>|$)/g, "")
                      value.SubText = (value.Title.length< 30) ? textWitoutHtml.substring(0,100)+'...' :textWitoutHtml.substring(0,70)+'...'
                    });
                   this.pageCourante = response.data.offres.current_page
                   this.pageSuivante = (response.data.offres.current_page != response.data.offres.last_page) ? this.pageCourante + 1:''
                   this.pageDerniere = response.data.offres.last_page
                   this.total = response.data.offres.total

                }).catch((response) => {
                  
                    swal.fire({ 
                        title: "Erreur!", 
                        html:"", 
                        type: "error", 
                        confirmButtonText: "Fermer" 
                    });
                });
            
            },
      //Load all secteurs d'activité
      LoadSecteurs() {
                 axios.get('/LoadSecteurs').then((response) => {
                   this.secteurs= response.data.secteurs;
                   
                }).catch((response) => {
                  
                    swal.fire({ 
                        title: "Erreur!", 
                        html:"", 
                        type: "error", 
                        confirmButtonText: "Fermer" 
                    });
                });
            
      },
            DeleteOffre(id,index) {
              axios.delete('/offres/'+id)
                  .then(resp => {
                      this.offres.splice(index, 1);
                  })
                  .catch(error => {
                      console.log(error);
              })
            },
          FiltreOffre(page){
            this.pageNav = 1;
            let params = {
              title :this.title,
              secteur :this.secteur ? this.secteur.id :''
              }
               axios.post('/filterOffres', params).then(response => {
                      this.offres= response.data.offres.data
                      this.pageCourante = response.data.offres.current_page
                      this.pageSuivante = (response.data.offres.current_page != response.data.offres.last_page) ? this.pageCourante + 1:''
                      this.pageDerniere = response.data.offres.last_page
                      this.total = response.data.offres.total
                })
                 .catch((error) => {

                }); 
          },
           paginationNav(page){ 
                if(this.pageNav == 0){
                    this.loadOffres(page)
                }else if(this.pageNav == 1){
                    this.FiltreOffre(page)
                }
            },
        },
        mounted() {
            this.loadOffres(1)
            this.LoadSecteurs()
        }
    }
</script>

