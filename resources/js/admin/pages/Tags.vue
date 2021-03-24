<template>
    <div>
        <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags Table <Button  type="primary" @click="addModal=true" v-if="isWritePermitted"><Icon type="md-add-circle" /> Add a Tag</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag Name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
								<!-- ITEMS -->
							<tr v-for="(tag, i) in tags" :key="i">
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tag_name}}</td>
								<td>{{tag.created_at | myDate}}</td>
								<td>
                                    <Button type="info" size="small" @click="showEditModal(tag, i)"  v-if="isUpdatePermitted">Edit</Button>
                                    <Button type="error" size="small" @click="showDeleteTag(tag, deletingIndex)" :loading="tag.isDeleting" v-if="isDeletePermitted">Delete</Button>
								</td>
							</tr>
							<!-- ITEMS -->
						</table>
					</div>
				</div>

                <!-- Add Tag Modal-->
                <Modal
                    v-model="addModal"
                    title="Add Tag"
                    :mask-closable="false"
                    :closable="false"
                    >
                        <Input v-model="data.tag_name" placeholder="Add a tag name..." required/>


                    <div slot="footer">
                        <Button type="default" @click="addModal=false"> Close</Button>
                        <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding...' : 'Add Tag'}}</Button>
                    </div>
                </Modal>

                <!-- Edit Tag Modal-->
                <Modal
                    v-model="editModal"
                    title="Edit Tag"
                    :mask-closable="false"
                    :closable="false"
                    >
                        <Input v-model="editData.tag_name" placeholder="Edit tag name..." required/>


                    <div slot="footer">
                        <Button type="default" @click="editModal=false"> Close</Button>
                        <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding...' : 'Edit Tag'}}</Button>
                    </div>
                </Modal>

                <!-- Delete Tag Modal-->
                <Modal v-model="showDeleteModal" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>You won't be able to revert this!</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
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
                tag_name : ''
            },
            addModal : false,
            editModal : false,
            isAdding : false,
            isDeleting : false,
            tags : [],
            editData : {
                tag_name : ''
            },
            index : -1,
            showDeleteModal : false,
            deleteItem : {},
            deletingIndex : -1
        }
    },

    methods : {
        async addTag(){
            if (this.data.tag_name.trim()=='') return this.e('Tag name is required')
            const res = await this.callApi('post', 'app/create_tag', this.data)
            if (res.status===201) {
                this.tags.unshift(res.data)
                this.s('Tag Added Successfully')
                this.addModal= false,
                this.data.tag_name=''
            }else{
                if(res.status==422){
                    if(res.data.errors.tag_name){
                        this.e(res.data.errors.tag_name[0])
                    }
                }else{
                    this.swr()
                }
            }
        },

        async editTag(){
            if (this.editData.tag_name.trim()=='') return this.e('Tag name is required')
            const res = await this.callApi('post', 'app/edit_tag', this.editData)
            if (res.status===200) {
                this.tags[this.index].tag_name = this.editData.tag_name
                this.s('Tag Edited Successfully')
                this.editModal= false
            }else{
                this.swr()
            }
        },

        showEditModal(tag, index){
            let obj = {
                id : tag.id,
                tag_name : tag.tag_name
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },

        async deleteTag(){
            this.deletingIndex = true
            const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
            if (res.status===200) {
                this.tags.splice(this.deletingIndex,1)
                this.s('Tag Deleted Successfully')
            }else{
                this.swr()
            }
            this.deletingIndex = false
            this.showDeleteModal= false
        },

        showDeleteTag(tag, i){
            this.deleteItem = tag
            this.deletingIndex = i
            this.showDeleteModal= true
        }

    },

    async created(){
        //console.log(this.isReadPermitted)
        const res = await this.callApi('get', 'app/get_tags')
        if (res.status===200) {
            this.tags = res.data
        }else{
            this.swr()
        }
    }

}
</script>
