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
                <multiselect v-model="categorie" :options="categories" label="title" :searchable="true" track-by="id" :multiple="true" placeholder="Selectionner catégories">
               </multiselect>
             </div>
        </div>
        <div class="row">
        <div class="col-12">
            <div class="file-upload">
                  <div class="image-upload-wrap">
                      <input class="file-upload-input" type='file' v-on:change="onImageChange" accept="image/*" />
                      <div class="drag-text">
                         <h3>Selectionner une image</h3>
                      </div>
                  </div>
                  <div class="file-upload-content">
                      <img class="file-upload-image" src="#" :src="image" alt="your image" />
                      <div class="image-title-wrap">
                        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )" v-if="image">Modifier l'image</button>
                          <button type="button" @click="removeUpload" class="remove-image">Supprimer</button>
                      </div>
                  </div>
                </div>
          </div>
        </div>
       <div class="row">
        <div class="col-12" id="content_div">
           <vue-editor v-model="content"></vue-editor>
        </div>
      </div>
      <div class="row center_div">
        <div class="col-12">
          <button class="btn btn-success" @click="createNewPost(1)">
              Enregister et Publier
          </button>
          <button class="btn btn-info" @click="createNewPost(2)">
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
      image :'',
      title :'',
      filename :'',
      categorie: [],
      categories: []
    };
  },
  methods:{
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
    onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                  if (files && files[0]) 
                    this.createImage(files[0]);
                  else {
                    this.removeUpload();
                  }       
     },
  removeUpload() {
           this.image = ''
           this.filename =''
          $('.file-upload-input').replaceWith($('.file-upload-input').clone());
          $('.file-upload-content').hide();
          $('.image-upload-wrap').show();
            },
    createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    this.image = e.target.result;
                    this.filename = file.name;
                    $('.image-upload-wrap').hide();
                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();
                    // $('.image-title').html(files[0].name);
                };
                reader.readAsDataURL(file);
            },
    createNewPost(action){
        let params = {
              title :this.title,
              text  :this.content,
              image :this.image,
              filename : this.filename,
              categories :this.categorie.map(x => x.id),
              action : action

        }
          axios.post('/posts', params).then(response => {
                  Swal.fire({  
                        title: 'Nouveau post', 
                        text: 'Vote post a été crée avec succés', 
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
    this.loadCategories()
  }
}
</script>