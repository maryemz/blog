<template>
    <div class="row">
       <div class="create_div col-lg-7 col-md-7 col-xs-11  col-md-offset-2">
          <div class="row" id="content_div">
             <div class="col-12">
                <textarea v-model="post.Title" style ="width: 100%;"placeholder="Entrer le titre ici"></textarea>
            </div>
        </div>
        <div class="row" id="content_div">
             <div class="col-12">
                <multiselect v-model="post.categories" :options="categories" label="title" :searchable="true" track-by="id" :multiple="true">
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
                      <img class="file-upload-image" src="#" :src="post.Image" alt="your image" />
                      <div class="image-title-wrap">
                        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )" v-if="post.Image">Modifier l'image</button>
                          <button type="button" @click="removeUpload" class="remove-image">Supprimer</button>
                      </div>
                  </div>
                </div>
          </div>
        </div>



       <!--  <div class="row">
             
            <div class="col-md-3" v-if="image">
                  <img :src="image" class="img-responsive" height="70" width="90">
             </div>
             <div class="col-md-3" v-else-if="post.Image">
                  <img :src="post.Image" class="img-responsive" height="70" width="90">
             </div>
            <div class="col-md-6">
                <input type="file" v-on:change="onImageChange" class="form-control">
            </div>
        </div> -->
       <div class="row">
        <div class="col-12" id="content_div">
        <vue-editor v-model="post.Text"></vue-editor>
     </div>
      </div>
      <div class="row center_div">
        <div class="col-12">
          <button class="btn btn-success" @click="UpdatePost(post.id)">
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
    post :Object
  },

  data() {
    return {
      content: "<h1>Entrer votre contenu ici</h1>",
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
                   

                }).catch((error) => {
                  
                    swal.fire({ 
                        title: "Erreur!", 
                        html:"", 
                        icon: "error", 
                        confirmButtonText: "Fermer" 
                    });
                });
            
      },
      removeUpload() {
           this.image = ''
           this.filename =''
          $('.file-upload-input').replaceWith($('.file-upload-input').clone());
          $('.file-upload-content').hide();
          $('.image-upload-wrap').show();
            },
    onImageChange(e) {
               let files = e.target.files || e.dataTransfer.files;
                  if (files && files[0]) 
                    this.createImage(files[0]);
                  else {
                    this.removeUpload();
                  }  
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
                };
                reader.readAsDataURL(file);
            },
    UpdatePost(id){
        let params = {
              title :this.post.Title,
              text  :this.post.Text,
              image :this.image,
              filename : this.filename,
              categories :this.post.categories.map(x => x.id),
           

        }
          axios.put('/posts/'+id, params).then(response => {
                  swal.fire({  
                        title: 'Modification post', 
                        text: 'Vote post a été modifié avec succés', 
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
     $('#quill-container').css('height','48rem')
     if(this.post.Image){
        $('.image-upload-wrap').hide();
        $('.file-upload-image').attr('src', this.post.Image);
        $('.file-upload-content').show();
     }
    this.loadCategories()
  }
}
</script>