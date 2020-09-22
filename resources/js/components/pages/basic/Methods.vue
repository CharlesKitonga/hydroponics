<template>
    <div>
        <h2>The number is: {{views}}</h2>

        <button @click="updateCounter(1)">Increase</button>
        <button @click="updateCounter(-1)">Decrease</button>
        <br>
        <br><br>

        <div v-for="(blog, i) in blogs" :key="i" >
            <h1>{{blog.title}}</h1>
            <p>{{blog.post}}</p>
        </div>


        <br>
        <br>
        <br>


        <div>
            <h1 v-if="showItem">Show this item if "showItem" is true</h1>
            <h1 v-else>Show this item if "showItem" is false</h1>
        </div>

        <button @click="showItem = !showItem">change showItem </button>
    </div>
</template>

<script>
export default {
    data(){
        return{
            views: 0,
            blogs : [],
            showItem : false
        }
    },
    methods:{
        updateCounter(number){
            this.views += number
        },
        changeShowItem(){
            this.showItem = !this.showItem
        }
    },

    created(){
        //call the server to get the views of this blog post
        this.views = 100
        //get the blog posts
        let posts = [

                {title: 'This is the blog title', 'post' : 'This is the blog post', id: 1},
                {title: 'This is the blog title 1', 'post' : 'This is the blog post 1', id: 2},
                {title: 'This is the blog title 2', 'post' : 'This is the blog post 2', id: 3},
                {title: 'This is the blog title 3', 'post' : 'This is the blog post 3', id: 4}
        ]

        this.blogs = posts
    }
}
</script>
