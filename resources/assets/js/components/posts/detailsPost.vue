<template>
        <div class="post_details_div">
            <div class="col-12">
                   <div class="col-12 ">
                        <div class="post_title">
                             <p>{{post.Title}}</p>
                        </div>
                          <div class="col-12 published_by">
                             <p><span class="post_user_avatar"></span> Par: {{post.user.name}}</p>
                         </div>
                    </div>
                    <div class="col-12" v-if="post.Image">
                        <img :src="post.Image" class="post_img">  
                    </div>
                    <div class="col-12 post_txt">
                        <p v-html="post.Text"></p>
                    </div>
            </div>
        </div>
</template>

<script>
    export default {
        props :{
            post :Object
        },
        mounted() {
        }
    }
</script>
