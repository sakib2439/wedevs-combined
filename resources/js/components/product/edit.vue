<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <span>Edit Product</span>
                            <router-link style="float: right; color: white" to="/products" class="btn bg-info"><i class="fa fa-list"></i> Products</router-link>
                        </h2>
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="updateProduct" @keydown="form.onKeydown($event)">
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
                                        <input @change="changeImage($event)" type="file" name="image" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div style="height: 100px" class="form-group">
                                        <img :src="showImage()" style="max-height: 100px; max-width: 200px; float: right">
                                        <has-error :form="form" field="image"></has-error>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" style="color: white" class="btn bg-info">Update</button>
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
                id : '',
                form: new Form({
                    title:'',
                    description:'',
                    price:'',
                    image:'',
                })
            }
        },
        mounted() {
            this.loadProductDetails();
        },
        methods: {
            loadProductDetails(){
                let id = this.$route.params.id;
                axios.get('/api/products/'+id+'/edit')
                  .then(response => {
                      this.form.fill(response.data.product);
                  });
            },
            changeImage(event){
                let file = event.target.files[0];
                //console.log(file.type.split('/')[0]);
                if(file.type.split('/')[0] != 'image'){
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Sorry, the file is not image!',
                    })
                }else if(file.size > 4194304){
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Sorry, the image is too large!',
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
            updateProduct(){
                let id = this.$route.params.id;
                this.form.put('/api/products/'+id)
                  .then(response => {
                    this.$toast.success({
                        title:'Success',
                        message:'Product successfully updated !'
                    })
                  });
            },
            showImage(){
                let image = this.form.image;
                if(image){
                    if(image.length > 100){
                        return image
                    }else{
                        return "/images/products/"+image;
                    }
                    
                }
            }
        }
    }
</script>
