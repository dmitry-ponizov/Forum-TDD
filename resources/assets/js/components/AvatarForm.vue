<template>
    <div>
        <div class="level">
            <img :src="avatar"  class="mr-1" name='foobar ' width="100px" height="100px">
            <h1>{{ user.name }}</h1>
        </div>

        <form v-if="canUpdate"  method="POST" enctype="multipart/form-data">
            <image-upload @loaded="onLoad"></image-upload>
        </form>

    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';

    export default {
        components:{ ImageUpload },
        props:['user'],
        data(){
            return {
                avatar:  this.user.avatar_path
            }
        },
        computed:{
            canUpdate(){
               return this.authorize(user => user.id === this.user.id);
            }
        },
        methods:{
            onLoad(data){
                this.avatar = data.src;

                this.persist(data.file);
            },
            persist(file){
                let data = new  FormData();

                data.append('avatar',file);

                axios.post(`/api/users/${this.user.name}/avatar`, data)
                    .then(() => flash('Avatar uploaded!'))
            }
        }
    }
</script>

