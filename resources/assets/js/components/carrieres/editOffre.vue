<template>
    <div class="row">
       <div class=" create_div col-lg-7 col-md-7 col-xs-11  col-md-offset-2">
         <div class="row" id="content_div">
             <div class="col-12">
                <textarea v-model="offre.Title" style ="width: 100%;"placeholder="Entrer le titre ici"></textarea>
        </div>
        </div>
        <div class="row" id="content_div">
            <div class="col-12">
          <multiselect v-model="offre.secteur" :options="secteurs" label="title" :searchable="true" track-by="id" :multiple="false">
    </multiselect>
        </div>
        </div>
        <div class="row">
           <div class="col-12" id="content_div">
        <vue-editor v-model="offre.Text"></vue-editor>
      </div>
      </div>
      <div class="row center_div">
        <div class="col-12">
          <button class="btn btn-success" @click="UpdateOffre(offre.id)">
              Enregister 
          </button>
       </div>
      </div>
      </div>
    </div>  
</template>

<script>
import { VueEditor, Quill } from "vue2-editor"
import Multiselect from 'vue-multiselect'
import swal from "sweetalert2"

export default {
  components: {
    VueEditor,
    Multiselect
  },
  props :{
    offre :Object
  },

  data() {
    return {
      content: "<h1>Entrer votre contenu ici</h1>",
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
    
    UpdateOffre(id){
        let params = {
              title :this.offre.Title,
              text  :this.offre.Text,
              secteur :this.offre.secteur.id,
           

        }
          axios.put('/offres/'+id, params).then(response => {
                  swal.fire({  
                        title: 'Modification offre', 
                        text: 'Vote offre a été modifié avec succés', 
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
                    swal.fire({ 
                        title: "Attention!", 
                        html: errorsUl, 
                        icon: "warning", 
                        confirmButtonText: "Fermer" 
                    });
                }); 
    }        
  },
  mounted() {
    this.LoadSecteurs()
  }
}
</script>