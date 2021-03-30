<template>
    <div>
        <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Role Management <Button  type="primary" @click="addModal=true" v-if="isWritePermitted"><Icon type="md-add-circle" /> Add a New Role</Button></p>

					<div class="_overflow _table_div blog_editor">
                        <Editor 
                            ref="editor" 
                            autofocus
                            holder-id="codex-editor"
                            save-button-id="save-button"
                            :init-data="initData"
                            @save="onSave"
                            :config="{
                                tools: {
                                header: require('@editorjs/header')
                                }
                            }"
                         />
					</div>

                    <div class="_input_field">
                        <input type="text" placeholder="title">
                    </div>
                    <div class="_input_field">
                        <Button @click="save">Save the Data</Button>
                    </div>
				</div>
			</div>
		</div>
    </div>
</template>
<script>
import { Editor } from 'vue-editor-js/src/index'

export default {
    components: {
        Editor,
    },
    data(){
        return{
            config: {
                image: {
                // Like in https://github.com/editor-js/image#config-params
                field: 'image',
                types: 'image/*',
                },
            },
            initData : '',
            data :{
            }
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

        onSave(response){
            console.log('Response on save', response)
        },
        async save(){
           await this.$refs.editor.save()

        }

    }

}
</script>

<style >
    .blog_editor{
        width: 717px;
        margin-left: 160px;
        padding: 4px 7px;
        font-size: 14px;
        border: 1px solid #dcdee2;
        border-radius: 4px;
        color: #515a6e;
        background-color: #fff;
        background-image: none;
        z-index: -1;
    }

    .blog_editor:hover{
        border: 1px solid #57a3f3;
    }

    ._input_field{
        margin: 20px 0 0 160px;
        width: 717px;
    }

</style>
