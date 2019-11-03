<template>
    <div class="row">
        <div class="col-md-3" style="background: #f6f7f8; height: 1000px" >
            <div style="margin: 40px;">
                <router-link to="/" style="display: block;" class="mb-3">Home</router-link>
                <router-link to="/app_index" style="display:block;" class="mb-3">アプリケーション一覧</router-link>
                <p>today</p>
                <p>news</p>
                <p>create newb board</p>
                <p>recently read</p>
                <p>intergration</p>
            </div>
        </div>
        <div class="col-md-9">
                <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>