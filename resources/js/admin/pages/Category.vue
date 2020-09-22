<template>
    <div>
        <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Catgeories Table <Button  type="primary" @click="addModal=true"><Icon type="md-add-circle" /> Add a Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Image</th>
								<th>Category Name</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
								<!-- ITEMS -->
							<tr v-for="(category, i) in categories" :key="i">
								<td>{{category.id}}</td>
                                <td class="table_image">
                                    <img :src="category.iconImage" alt=" Avatar">
                                </td>
								<td class="_table_name">{{category.category_name}}</td>
								<td>
                                    <Button type="info" size="small" @click="showEditModal(category, i)">Edit</Button>
                                    <Button type="error" size="small" @click="showDeleteCategory(category, deletingIndex)" :loading="category.isDeleting">Delete</Button>
								</td>
							</tr>
							<!-- ITEMS -->
						</table>
					</div>
				</div>

                <!-- Add Category Modal-->
                <Modal
                    v-model="addModal"
                    title="Add Category"
                    :mask-closable="false"
                    :closable="false"
                    >
                        <Input v-model="data.category_name" placeholder="Add category name..." required/>
                        <div class="space"></div>
                         <Upload
                            ref="uploads"
                            type="drag"
                            :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest' }"
                            :on-success="handleSuccess"
                            :on-error="handleError"
                            :format="['jpg','jpeg','png', 'svg']"
                            :max-size="2048"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            action="/app/uploads">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
                        <div class="demo-upload-list" v-if="data.iconImage">

							<img :src="`${data.iconImage}`">
							<div class="demo-upload-list-cover">
								<Icon type="ios-trash-outline" @click="deleteImage"></Icon>
							</div>
					    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModal=false"> Close</Button>
                        <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding...' : 'Add Category'}}</Button>
                    </div>
                </Modal>

                <!-- Edit Category Modal-->
                <Modal
                    v-model="editModal"
                    title="Edit Category"
                    :mask-closable="false"
                    :closable="false"
                    >
                        <Input v-model="editData.category_name" placeholder="Edit category name..." required/>
                        <div class="space"></div>
                         <Upload v-show="isIconImageUploadNew"
                            ref="editDataUploads"
                            type="drag"
                            :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest' }"
                            :on-success="handleSuccess"
                            :on-error="handleError"
                            :format="['jpg','jpeg','png', 'svg']"
                            :max-size="2048"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            action="/app/uploads">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
                        <div class="demo-upload-list" v-if="editData.iconImage">

							<img :src="`${editData.iconImage}`">
							<div class="demo-upload-list-cover">
								<Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
							</div>
					    </div>

                    <div slot="footer">
                        <Button type="default" @click="closeEditModal"> Close</Button>
                        <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding...' : 'Edit Category'}}</Button>
                    </div>
                </Modal>

                <!-- Delete Category Modal-->
                <Modal v-model="showDeleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>You won't be able to revert this!</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteCategory">Delete</Button>
                    </div>
                </Modal>
			</div>
		</div>
    </div>
</template>

<script>
export default {

    data(){
        return{
            data :{
                category_name : '',
                iconImage : ''
            },
            addModal : false,
            editModal : false,
            isAdding : false,
            isDeleting : false,
            categories : [],
            editData : {
                category_name : '',
                iconImage : ''
            },
            index : -1,
            showDeleteModal : false,
            deleteItem : {},
            deletingIndex : -1,
            token : '',
            isIconImageUploadNew : false,
            isEditingItem : false
        }
    },

    methods : {
        async addCategory(){
            if (this.data.category_name.trim()=='') return this.e('Category name field is required')
            if (this.data.iconImage.trim()=='') return this.e('Image field is required')
            this.data.iconImage = `${this.data.iconImage}`
            const res = await this.callApi('post', 'app/create_category', this.data)
            if (res.status===201) {
                this.categories.unshift(res.data)
                this.s('Category Added Successfully')
                this.addModal= false

            }else{
                this.swr()
            }
        },

        async editCategory(){
            if (this.editData.category_name.trim()=='') return this.e('Category name is required')
            if (this.editData.iconImage.trim()=='') return this.e('Image is required')
            const res = await this.callApi('post', 'app/edit_category', this.editData)
            if (res.status===200) {
                this.categories[this.index].category_name = this.editData.category_name
                this.categories[this.index].iconImage = this.editData.iconImage
                this.s('Category Edited Successfully')
                this.editModal= false
            }else{
                this.swr()
            }
        },

        showEditModal(category, index){
            let obj = {
                id : category.id,
                category_name : category.category_name,
                iconImage : category.iconImage
            }
            this.editData = obj
            this.editModal = true
            this.index = index
            this.isEditingItem = true
        },

        async deleteCategory(){
            this.deletingIndex = true
            const res = await this.callApi('post', 'app/delete_category', this.deleteItem)
            if (res.status===200) {
                this.categories.splice(this.deletingIndex,1)
                this.s('Category Deleted Successfully')
            }else{
                this.swr()
            }
            this.deletingIndex = false
            this.showDeleteModal= false
        },

        showDeleteCategory(category, i){
            this.deleteItem = category
            this.deletingIndex = i
            this.showDeleteModal= true
        },

        async deleteImage(isAdd=true){
            let image
            if(!isAdd){//for editing
                image = this.editData.iconImage
                this.editData.iconImage = ''
                this.$refs.editDataUploads.clearFiles()
                this.isIconImageUploadNew = true

            }else{
                image = this.data.iconImage
                this.data.iconImage = ''
                this.$refs.uploads.clearFiles()
            }
            const res = await this.callApi('post', 'app/delete_image', {imageName: image})
            if (res.status!=200) {
                this.data.iconImage = image
                this.swr()
            }


        },
        closeEditModal(){
            this.isEditingItem = false
            this.editModal = false
        },

        handleSuccess (res, file) {
            res = `/images/categories/${res}`
            if (this.isEditingItem) {
                return  this.editData.iconImage = res
            }else{
                this.data.iconImage = res
            }
        },
        handleError (res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: `${file.errors.file  ? file.errors.file[0] : 'Something Went Wrong'}`
            });
        },
        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },

    },

    async created(){
        this.token = window.Laravel.csrfToken
        const res = await this.callApi('get', 'app/get_categories')
        if (res.status===200) {
            this.categories = res.data
        }else{
            this.swr()
        }
    }

}
</script>
