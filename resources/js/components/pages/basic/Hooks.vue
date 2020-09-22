<template>
    <div>
        <h1 refs="myrefs">Hooks Page</h1>
        <h2>My name is: {{name}}</h2>
    </div>
</template>

<script>
export default {
    data(){
        return{
            name: "Kyalo"
        }
    },

    created(){
        //callmostly initial data from it...
        console.log('data and other functions are available but not html', this.name)
    },
    mounted(){
        console.log(this.$refs.myref)
    }
}
</script>
