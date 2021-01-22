<template>
    <div>
        <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Role Management <Button  type="primary" @click="addModal=true"><Icon type="md-add-circle" /> Add a New Role</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Role Name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
								<!-- ITEMS -->
							<tr v-for="(role, i) in roles" :key="i">
								<td>{{role.id}}</td>
								<td class="_table_name">{{role.roleName}}</td>
								<td>{{role.created_at | myDate}}</td>
								<td>
                                    <Button type="info" size="small" @click="showEditModal(role, i)">Edit</Button>
                                    <Button type="error" size="small" @click="showDeleteRole(role, deletingIndex)" :loading="role.isDeleting">Delete</Button>
								</td>
							</tr>
							<!-- ITEMS -->
						</table>
					</div>
				</div>

                <!-- Add Tag Modal-->
                <Modal
                    v-model="addModal"
                    title="Add Role"
                    :mask-closable="false"
                    :closable="false"
                    >
                        <Input v-model="data.roleName" placeholder="Add a role name..." required/>


                    <div slot="footer">
                        <Button type="default" @click="addModal=false"> Close</Button>
                        <Button type="primary" @click="addRole" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding...' : 'Add Role'}}</Button>
                    </div>
                </Modal>

                <!-- Edit Tag Modal-->
                <Modal
                    v-model="editModal"
                    title="Edit Tag"
                    :mask-closable="false"
                    :closable="false"
                    >
                        <Input v-model="editData.roleName" placeholder="Edit Role name..." required/>


                    <div slot="footer">
                        <Button type="default" @click="editModal=false"> Close</Button>
                        <Button type="primary" @click="editRole" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding...' : 'Edit Tag'}}</Button>
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
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteRole">Delete</Button>
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
                roleName : ''
            },
            addModal : false,
            editModal : false,
            isAdding : false,
            isDeleting : false,
            roles : [],
            editData : {
                roleName : ''
            },
            index : -1,
            showDeleteModal : false,
            deleteItem : {},
            deletingIndex : -1
        }
    },

    methods : {
        async addRole(){
            if (this.data.roleName.trim()=='') return this.e('Role name is required')
            const res = await this.callApi('post', 'app/create_role', this.data)
            if (res.status===201) {
                this.roles.unshift(res.data)
                this.s('Role Added Successfully')
                this.addModal= false,
                this.data.roleName=''
            }else{
                if(res.status==422){
                    if(res.data.errors.roleName){
                        this.e(res.data.errors.roleName[0])
                    }
                }else{
                    this.swr()
                }
            }
        },

        async editRole(){
            if (this.editData.roleName.trim()=='') return this.e('Role name is required')
            const res = await this.callApi('post', 'app/edit_role', this.editData)
            if (res.status===200) {
                this.roles[this.index].roleName = this.editData.roleName
                this.s('Role Edited Successfully')
                this.editModal= false
            }else{
                this.swr()
            }
        },

        showEditModal(tag, index){
            let obj = {
                id : tag.id,
                roleName : tag.roleName
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },

        async deleteRole(){
            this.deletingIndex = true
            const res = await this.callApi('post', 'app/delete_role', this.deleteItem)
            if (res.status===200) {
                this.roles.splice(this.deletingIndex,1)
                this.s('Role Deleted Successfully')
            }else{
                this.swr()
            }
            this.deletingIndex = false
            this.showDeleteModal= false
        },

        showDeleteRole(role, i){
            this.deleteItem = role
            this.deletingIndex = i
            this.showDeleteModal= true
        }

    },

    async created(){
        const res = await this.callApi('get', 'app/get_roles')
        if (res.status===200) {
            this.roles = res.data
        }else{
            this.swr()
        }
    }

}
</script>
