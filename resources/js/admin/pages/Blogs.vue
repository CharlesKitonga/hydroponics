<template>
    <div>
        <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Blogs <Button  type="primary" @click="$router.push('/createBlog')" v-if="isWritePermitted"><Icon type="md-add-circle" /> Create Blog</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Title</th>
								<th>Categories</th>
								<th>Tags</th>
								<th>Views</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
								<!-- ITEMS -->
							<tr v-for="(blog, i) in blogs" :key="i">
								<td>{{blog.id}}</td>
								<td class="_table_name">{{blog.title}}</td>
								<td > <span v-for="(c, i) in blog.cat" :key="i" v-if="blog.cat.length"><Tag color="default">{{c.category_name}}</Tag></span></td>
								<td> <span v-for="(tag, i) in blog.tag" :key="i" v-if="blog.tag.length"><Tag color="default">{{tag.tag_name}}</Tag></span></td>
								<td>{{blog.views}}</td>
								<td>
                                    <Button type="info" size="small">Visit blog</Button>
                                    <Button type="info" size="small" @click="$router.push(`/editblog/${blog.id}`)"  v-if="isUpdatePermitted">Edit</Button>
                                    <Button type="error" size="small" @click="showDeleteBlog(blog, deletingIndex)" :loading="blog.isDeleting" v-if="isDeletePermitted">Delete</Button>
								</td>
							</tr>
							<!-- ITEMS -->
						</table>
					</div>
				</div>
                
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
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteBlog">Delete</Button>
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
            
            isAdding : false,
            isDeleting : false,
            tags : [],
            index : -1,
            showDeleteModal : false,
            deleteItem : {},
            deletingIndex : -1,
            blogs: []
        }
    },

    methods : {
        

        async deleteBlog(){
            this.deletingIndex = true
            const res = await this.callApi('post', 'app/delete_blog', this.deleteItem)
            if (res.status===200) {
                this.tags.splice(this.deletingIndex,1)
                this.s('Tag Deleted Successfully')
                this.$router.push('/blogs')
            }else{
                this.swr()
            }
            this.deletingIndex = false
            this.showDeleteModal= false
        },

        showDeleteBlog(tag, i){
            this.deleteItem = tag
            this.deletingIndex = i
            this.showDeleteModal= true
        }

    },

    async created(){
        //console.log(this.isReadPermitted)
        const res = await this.callApi('get', 'app/blogdata')
        if (res.status===200) {
            this.blogs = res.data
        }else{
            this.swr()
        }
    }

}
</script>
