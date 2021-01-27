<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            	
            	<div class="card">
            		<div style="padding-top: 8px; padding-bottom: 5px" class="card-header">
            			<div>
            				<h2>
            					<span>Products</span>
            					<router-link style="float: right" to="products/create" class="btn btn-success"><i class="fa fa-plus"></i> Add Product</router-link>
            				</h2>
            			</div>
            		</div>
            		<div class="card-body table-responsive">
            			<table class="table table-bordered table-hover table-stripped">
		                	<thead>
		                		<tr style="color: white" class="bg-info text-center">
		                			<th class="td" width="5%">ID</th>
		                			<th class="td" width="15%">Title</th>
		                			<th class="td" width="45%">Description</th>
		                			<th class="td" width="10%">Price</th>
		                			<th class="td" width="15%">Image</th>
		                			<th class="td" width="10%">Action</th>
		                		</tr>
		                	</thead>
		                	<tbody>
		                		<tr v-for="product in products">
		                			<td class="td">{{ product.id }}</td>
		                			<td class="td">{{ product.title }}</td>
		                			<td class="td"><span v-if="product.description != null">{{  product.description | textShort(100,'...') }}</span></td>
		                			<td class="td text-right">{{ product.price }}</td>
		                			<td style="padding: 5px" class="text-center">
		                				<img v-if="product.image != null" style="max-height:70px; max-width:100px" :src="showImage(product.image)">
		                				<img v-else style="max-height:70px; max-width:100px" :src="noImage()">
		                			</td>
		                			<td class="td">
		                				<router-link title="Edit" :to="{name: 'edit-product', params: { id: product.id }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></router-link>
		                				<a title="Delete" @click.prevent="deleteProduct(product.id)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
		                			</td>
		                		</tr>
		                	</tbody>
		                </table>
            		</div>
            		<pagination v-if="pagination.last_page > 1" 
			          :pagination="pagination" 
			          :offset="7" 
			          @paginate="getProducts()">
			        </pagination>
            	</div>
            	
                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
    	data(){
    		
    		return{
    			products: [],
		        pagination: {
		            current_page: 1,
		        },
    		}
    	},
        mounted() {
            this.getProducts()
        },
        methods:{
			textShort(text, length, suffix){
				if(text.length > length){
					return text.substring(0, length)+' '+suffix;
				}else{
					return text.substring(0, length);
				}
			},
			getProducts(){
	          axios.get('/api/products?page='+this.pagination.current_page)
	              .then(response => {
	                  this.products = response.data.data;
	                  this.pagination = response.data.meta;
	              });
	        },
			showImage(image){
				return "/images/products/"+image;
			},
			noImage(){
				return '/images/products/no-image.png';
			},
			deleteProduct(id){
	          swal.fire({
	          title: 'Are you sure to delete ?',
	          showCancelButton: true,
	          confirmButtonText: `Delete`,
	          confirmButtonColor: '#d33',
	        }).then((result) => {
	             if (result.isConfirmed) {
	              axios.delete('/api/products/'+id)
	                    .then(response => {
	                    	this.$toast.success({
		                        title:'Success',
		                        message:'Product successfully deleted !'
		                    })
	                      	this.getProducts();
	                    });
	                }
	          })
	        },
		}
    }
</script>
