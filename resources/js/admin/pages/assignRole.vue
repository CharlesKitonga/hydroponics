<template>
    <div>
        <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Role Management
                        <Select v-model="data.role_id" style="width:200px" placeholder="Select User Type...">
                            <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>
                        </Select>
                    </p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Resource Name</th>
								<th>Read</th>
								<th>Write</th>
								<th>Update</th>
								<th>Delete</th>
							</tr>
								<!-- TABLE TITLE -->
								<!-- ITEMS -->
							<tr>
								<td>Blog</td>
								<td>Yes</td>
								<td>Yes</td>
								<td>Yes</td>
								<td>Yes</td>
							</tr>
							<!-- ITEMS -->
						</table>
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
            data :{
                roleName : '',
                role_id: null
            },
            resources: [],
            roles: [
                {resourceName: home, read: false, write:false, update:false, delete: false, name: home},
                {resourceName: tags, read: false, write:false, update:false, delete: false, name: tags},
                {resourceName: categories, read: false, write:false, update:false, delete: false, name: categories},
                {resourceName: adminusers, read: false, write:false, update:false, delete: false, name: adminusers},
                {resourceName: role, read: false, write:false, update:false, delete: false, name: role},
                {resourceName: assignRole, read: false, write:false, update:false, delete: false, name: assignRole},

            ],
        }
    },

    methods : {


    },

    async created(){
        //console.log(this.$route)
        const res = await this.callApi('get', 'app/get_roles')
        if (res.status===200) {
            this.roles = res.data
        }else{
            this.swr()
        }
    }

}
</script>
