<template>
    <div class="row">
       <div class=" create_div col-lg-7 col-md-7 col-xs-11  col-md-offset-2">
         <div class="row" id="content_div">
             <div class="col-12">
                 <textarea v-model="title" placeholder="Entrer le titre ici" id="title_textarea "></textarea>
            </div>
        </div>
        <div class="row" id="content_div">
            <div class="col-12">
                 <multiselect v-model="secteur" :options="secteurs" label="title" :searchable="true" track-by="id" :multiple="false">
                 </multiselect>
            </div>
        </div>
        <div class="row">
           <div class="col-12" id="content_div">
             <vue-editor v-model="content"></vue-editor>
           </div>
      </div>
      <div class="row center_div">
        <div class="col-12">
          <button class="btn btn-success" @click="createNewOffre(1)">
              Enregister et Publier
          </button>
          <button class="btn btn-info" @click="createNewOffre(2)">
              Enregister sans Publier
          </button>
        </div>
      </div>
      </div>
    </div>
</template>
<script>
import { VueEditor, Quill } from "vue2-editor"
import Multiselect from 'vue-multiselect'
import Swal from "sweetalert2"


export default {
  components: {
    VueEditor,
    Multiselect
  },

  data() {
    return {
      content: "Entrer votre contenu ici",
      title :'',
      secteur: [],
      secteurs: []
    };
  },
  methods:{
     //Load all secteurs d'activité
      LoadSecteurs() {
                 axios.get('/LoadSecteurs').then((response) => {
                  
                   this.secteurs= response.data.secteurs;
                   

                }).catch((response) => {
                  
                    Swal({ 
                        title: "Erreur!", 
                        html:"", 
                        type: "error", 
                        confirmButtonText: "Fermer" 
                    });
                });
            
      },

    createNewOffre(action){
        let params = {
              title :this.title,
              text  :this.content,
              secteur:this.secteur.id,
              action : action

        }
          axios.post('/offres', params).then(response => {
                  Swal.fire({  
                        title: 'Nouvelle offre', 
                        text: 'Vote offre a été crée avec succés', 
                        icon: 'success', 
                        confirmButtonText: 'Fermer', 
                    });
                 
                })
                .catch((error) => {

                  let errors = error.response.data.errors
                
                  let errorsUl =''
                   $.each(errors, function( index, err ) {

                      errorsUl = errorsUl+'<li style="text-align: left;font-size: 16px;padding-bottom: 14px;">'+err+'</li>'
                    });
                  errorsUl = '<ul>'+errorsUl+'</ul>'
                    Swal.fire({ 
                        title: "Attention!", 
                        html: errorsUl, 
                        icon: "warning", 
                        confirmButtonText: "Fermer" 
                    });
                }); 
    }        
  },
  mounted() {
    $('#quill-container').css('height','48rem')
    this.LoadSecteurs()
  }
}
</script>