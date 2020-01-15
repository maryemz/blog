<template>
        <div class="row content_div">
            <div>
               <!--  <button>
                    <router-link :to="{ name: 'PreviewPost', params: {Title:title,Image:image,Text:content,Categories:categorie}, target:'_blank' }"> Retour</router-link>
                </button> -->
            </div>
            <div class="col-12">
                   <div class="col-12 post_title">
                         <p>{{Title}}</p>
                    </div>

                    <div class="col-12 ">
                        <img :src="Image" class="post_img">  
                    </div>
                    <div class="col-12 post_txt">
                        <p v-html="Text"></p>
                    </div>
                
            </div>
        </div>
</template>

<script>
    export default {
        props :{
            Text :String,
            Title :String,
            Image :String,
            Categories :Array
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
