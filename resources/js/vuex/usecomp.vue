<template>
    <div class="content">
        <div class="container-fluid">
            <h1>Show how vuex works</h1>
            Current Counter State is : {{$store.state.counter}}
            <div>
                <compA></compA>
            </div>
            <div>
                <compB></compB>
            </div>
            <div>
                <compC></compC>
            </div>

            <Button type="info" @click="changeCounter"> Change the State of The Counter</Button>
        </div>
    </div>
</template>

<script>
    import compA from './compA'
    import compB from './compB'
    import compC from './compC'

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            changeCounter(){
                this.$store.commit('changeTheCounter', 1)
            }
        },
        created(){
            console.log(this.$store)
        },
        components : {
            compA, compB, compC
        }
    }


</script>
