<template>
    <div>
        <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Users Table <Button  type="primary" @click="addModal=true"><Icon type="md-add-circle" /> Add User</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
							<tr v-for="(user, i) in users" :key="i">
								<td>{{user.id}}</td>
                                <td class="_table_name">{{user.fullName}}</td>
                                <td >{{user.email}}</td>
                                <td >{{user.userType}}</td>
								<td>{{user.created_at | myDate}}</td>
								<td>
                                    <Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
                                    <Button type="error" size="small" @click="showDeleteTag(user, deletingIndex)" :loading="user.isDeleting">Delete</Button>
								</td>
							</tr>
							<!-- ITEMS -->
						</table>
					</div>
				</div>

                <!-- Add User Modal-->
                <Modal
                    v-model="addModal"
                    title="Add User"
                    :mask-closable="false"
                    :closable="false"
                    >
                        <div class="space">
                            <Input type="text" v-model="data.fullName" placeholder="Full name..." required/>
                        </div>
                        <div class="space">
                            <Input type="email" v-model="data.email" placeholder="Email..." required/>
                        </div>
                        <div class="space">
                            <Input type="password" v-model="data.password" placeholder="password..." required/>
                        </div>
                        <div class="space">

                            <Select v-model="data.userType" style="width:200px" placeholder="Select User Type...">
                                <Option value="Admin">Admin</Option>
                                <Option value="Editor">Editor</Option>
                            </Select>
                        </div>



                    <div slot="footer">
                        <Button type="default" @click="addModal=false"> Close</Button>
                        <Button type="primary" @click="addUser" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding...' : 'Add User'}}</Button>
                    </div>
                </Modal>

                <!-- Edit User Modal-->
                <Modal
                    v-model="editModal"
                    title="Edit User"
                    :mask-closable="false"
                    :closable="false"
                    >
                        <div class="space">
                            <Input type="text" v-model="editData.fullName" placeholder="Edit Full name..." required/>
                        </div>

                        <div class="space">
                            <Input type="email" v-model="editData.email" placeholder="Edit Email..." required/>
                        </div>

                        <div class="space">
                            <Input type="password" v-model="editData.password" placeholder="Edit Password...(Optional if you still remember:)" required/>
                        </div>

                        <div class="space">

                            <Select v-model="editData.userType" style="width:200px" placeholder="Select User Type...">
                                <Option value="Admin">Admin</Option>
                                <Option value="Editor">Editor</Option>
                            </Select>
                        </div>


                    <div slot="footer">
                        <Button type="default" @click="editModal=false"> Close</Button>
                        <Button type="primary" @click="editUser" :disabled="isAdding" :loading="isAdding"> {{isAdding ? 'Adding...' : 'Edit User'}}</Button>
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
                fullName : '',
                email : '',
                password : '',
                userType : ''
            },
            addModal : false,
            editModal : false,
            isAdding : false,
            isDeleting : false,
            users : [],
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
        async addUser(){
            if (this.data.fullName.trim()=='') return this.e('Full name field is required')
            if (this.data.email.trim()=='') return this.e('Email field is required')
            if (this.data.password.trim()=='') return this.e('Password field is required')
            if (this.data.userType.trim()=='') return this.e('Usertype field is required')

            const res = await this.callApi('post', 'app/create_user', this.data)
            if (res.status===201) {
                this.users.unshift(res.data)
                this.s('User Added Successfully')
                this.addModal= false
            }else{
                if (res.status==422) {
                    //console.log(res.data.errors);
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i][0])
                    }
                }
                this.swr()
            }
        },

        async editUser(){
            if (this.editData.fullName.trim()=='') return this.e('Full name field is required')
            if (this.editData.email.trim()=='') return this.e('Email field is required')
            if (this.editData.userType.trim()=='') return this.e('Usertype field is required')

            const res = await this.callApi('post', 'app/edit_user', this.editData)
            if (res.status===200) {
                this.users[this.index] = this.editData
                this.s('User Edited Successfully')
                this.editModal= false
            }else{
                if (res.status==422) {
                    console.log(res.editData.errors);
                    for (let i in res.editData.errors) {
                        this.e(res.editData.errors[i][0])
                    }
                }
                this.swr()
            }
        },

        showEditModal(user, index){
            let obj = {
                id : user.id,
                fullName : user.fullName,
                email : user.email,
                userType: user.userType
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },

        async deleteTag(){
            this.deletingIndex = true
            const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
            if (res.status===200) {
                this.users.splice(this.deletingIndex,1)
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
        const res = await this.callApi('get', 'app/get_users')
        if (res.status===200) {
            this.users = res.data
        }else{
            this.swr()
        }
    }

}
</script>
