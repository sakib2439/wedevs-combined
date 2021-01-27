<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <span>Create Product</span>
                            <router-link style="float: right; color: white" to="/products" class="btn bg-info"><i class="fa fa-list"></i> Products</router-link>
                        </h2>
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="createProduct" @keydown="form.onKeydown($event)">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input v-model="form.title" :class="{ 'is-invalid': form.errors.has('title') }" type="text" name="title" class="form-control">
                                        <has-error :form="form" field="title"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input v-model="form.price" :class="{ 'is-invalid': form.errors.has('price') }" type="number" step="0.01" name="price" class="form-control">
                                        <has-error :form="form" field="price"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea  v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }"class="form-control" name="description"></textarea>
                                        <has-error :form="form" field="description"></has-error>
                                    </div>
                                    
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input @change="changeImage($event)" type="file" name="file" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div style="height: 100px" class="form-group">
                                        <img :src="form.image" style="max-height: 100px; max-width: 200px; float: right">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" style="color: white" class="btn bg-info">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                form: new Form({
                    title:'',
                    description:'',
                    price:'',
                    image:'',

                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            changeImage(event){
                let file = event.target.files[0];
                //console.log(file.type.split('/')[0]);
                if(file.type.split('/')[0] != 'image'){
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Sorry, the file is not image!',
                      // footer: '<a href>Why do I have this issue?</a>'
                    })
                }else if(file.size > 4194304){
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Sorry, the image is too large!',
                      // footer: '<a href>Why do I have this issue?</a>'
                    })
                }
                else{
                    let reader = new FileReader();
                    reader.onload = (event)=>{
                        this.form.image = event.target.result;
                    }
                    reader.readAsDataURL(file);
                }
                
            },
            createProduct(){
                this.form.post('/api/products')
                .then(response => {
                    this.$router.push('/products');
                    this.$toast.success({
                        title:'Success',
                        message:'Product successfully saved !'
                    })
                    // swal.fire({
                    //     icon: 'success',
                    //     text: "Items successfully added !",
                    // })
                });
            }
        }
    }
</script>
