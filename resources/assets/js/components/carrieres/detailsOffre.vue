<template>
        <div class="post_details_div">
            <div class="col-12">
                   <div class="col-12 post_title">
                         <p>{{offre.Title}}</p>
                    </div>

                    <div class="col-12 post_txt">
                        <p v-html="offre.Text"></p>
                    </div>
                
            </div>
        </div>
</template>

<script>
    export default {
        props :{
            offre :Object
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
