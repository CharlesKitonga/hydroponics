<template>
    <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Create blog</p>
					<div class="_input_field">
						 <Input type="text" v-model="data.title" placeholder="Title" />
					</div>
					<div class="_overflow _table_div blog_editor">
                        <vue-editor v-model="data.metaDescription"></vue-editor>
					</div>
					<div class="_input_field">
						 <Input  type="textarea" v-model="data.post_excerpt" :rows="4" placeholder="Post excerpt " />
					 </div>
					<div class="_input_field">
						<Select  filterable multiple placeholder="Select category" v-model="data.category_id">
							<Option v-for="(c, i) in category" :value="c.id" :key="i">{{ c.category_name }}</Option>
						</Select>
					</div>
					<div class="_input_field">
						<Select  filterable multiple placeholder="Select tag" v-model="data.tag_id">
							<Option v-for="(t, i) in tag" :value="t.id" :key="i">{{ t.tag_name }}</Option>
						</Select>
					</div>

					 <div class="_input_field">
						 <Button @click="addBlog" :loading="isAdding" >{{isAdding ? 'Please wait...' : 'Create blog'}}</Button>
					 </div>

				</div> 
			</div>
		</div>
    </div>
</template>


<script>

// Basic Use - Covers most scenarios
import { VueEditor } from "vue2-editor";

export default {
	components:{
		VueEditor
	},
	data(){
		return {
            initData: null,
            data: {
				title : '',
				post_excerpt : '',
				metaDescription : '',
				category_id : [],
				tag_id : [],
			},
			isAdding: false,
			category : [],
			tag : [],
		}
	},
	methods : {
        async addBlog(response){
            var data = response
            this.data.jsonData = JSON.stringify(data)
			const res = await this.callApi('post', 'app/create-blog', this.data)
            if(this.data.title.trim()=='') return this.e('Title is required')
            if(this.data.post_excerpt.trim()=='') return this.e('Post exerpt is required')
            if(this.data.metaDescription.trim()=='') return this.e('Meta description is required')
            if(!this.data.tag_id.length) return this.e('Tag is required')
            if(!this.data.category_id.length) return this.e('Category is required')

			if(res.status===200){
				this.s('Blog has been created successfully!')
                // redirect...
                this.$router.push('/blogs')
			}else{
                if(res.status==422){
                    for(let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                    }
                }else{
                    this.swr()
                }
			}
        }
	},
	async created(){
		const [cat, tag] = await Promise.all([
			this.callApi('get', 'app/get_categories'),
			this.callApi('get', 'app/get_tags'),
		])
		if(cat.status==200){
			this.category = cat.data
			this.tag = tag.data
		}else{
			this.swr()
		}
	}
}
</script>


<style>

	.blog_editor {
		width: 717px;
		margin-left: 160px;
		padding: 4px 7px;
		font-size: 14px;
		border: 1px solid #dcdee2;
		border-radius: 4px;
		color: #515a6e;
		background-color: #fff;
		background-image: none;
		z-index:  -1;
	}
	._input_field{
		margin: 20px 0 20px 160px;
    	width: 717px;
	}
</style>